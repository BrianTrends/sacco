/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 *
 * @package octo
 * @since   1.0.0
 */

( function() {
	
	const toggleButton           = document.querySelector( '.menu-toggle-button' );
	const body                   = document.body;
	const toggleButtonContainer  = document.querySelector( '.menu-toggle' );
	const mobileNavigation       = document.querySelector( ':is(.mobile-navigation, .flyout-navigation, .full-screen-navigation)' );
	const allMenus               = document.querySelectorAll( '#primary-menu, #mobile-menu, #off-canvas-menu' );	
	const primaryMenu            = document.querySelector( ':is(.main-navigation, .flyout-navigation, .full-screen-navigation) .menu' );
	const mobileMenu             = document.querySelector( ':is(.mobile-navigation, .flyout-navigation, .full-screen-navigation) .menu' );
	var   dropdownTarget;
	
	// Return early if the toggleButton doesn't exist.
	if ( 'undefined' === typeof toggleButton || null === toggleButton ) {
		return;
	}
	
	// Hide menu toggle button, if menu is empty and return early.
	if ( 'undefined' === typeof mobileMenu || null === mobileMenu ) {
		toggleButtonContainer.style.display = 'none';
		return;
	}

	// Toggle mobile menu when hamburger toggleButton is clicked.
	toggleButton.addEventListener( 'click', function() {
		
		toggleButton.classList.toggle( 'toggled' );
		mobileNavigation.classList.toggle( 'toggled' );

		if ( toggleButton.getAttribute( 'aria-expanded' ) === 'true' ) {
			toggleButton.setAttribute( 'aria-expanded', 'false' );
		} else {
			toggleButton.setAttribute( 'aria-expanded', 'true' );
		}

		if ( mobileNavigation.classList.contains( 'toggled' ) ) {
			mobileMenu.setAttribute( 'aria-hidden', 'false' );
			closeSubmenu();
		} else {
			mobileMenu.setAttribute( 'aria-hidden', 'true' );
		}
		
	} );

	// Remove the .toggled and .submenu-open class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {

		const isClicktoggleButton = toggleButton.contains( event.target );
		const isClickInside = mobileMenu.contains( event.target );

		if ( ! isClicktoggleButton && ! isClickInside ) {
			closeMenu();
			closeSubmenu();
		}

	} );
	
	for ( const menu of allMenus ) {
		// Depending on the customizer settings, hovering the menu item, a click on the arrow icon or the menu item will open the sub-menu.
		// Hence we want to select all arrow icons or menu-item, that have child-elements as click target.
		if ( body.classList.contains( 'octo-dropdown-click-item' ) ) {
			dropdownTargets = menu.querySelectorAll( '.menu-item-has-children > a' );
		} else if ( body.classList.contains( 'octo-dropdown-click-icon' ) || body.classList.contains( 'octo-dropdown-hover' ) ) {
			dropdownTargets = menu.querySelectorAll( '.menu-item-has-children > a .submenu-toggle-icon' );
		}

		// Add event listener to all target elements.
		for ( const target of dropdownTargets ) {

			// Change target for elements, that are set to #.
			if ( body.classList.contains( 'octo-dropdown-click-icon' ) || body.classList.contains( 'octo-dropdown-hover' ) ) {
				var newTarget = target.closest( 'a' );
				var href      = newTarget.getAttribute( 'href' );
			}

			if ( 'null' != href && '#' == href ) {
				newTarget.addEventListener( 'click' ,toggleSubmenu, true );
				newTarget.addEventListener( 'keydown', toggleSubmenu, true );
			} else {
				target.addEventListener( 'click' ,toggleSubmenu, true );
				target.addEventListener( 'keydown', toggleSubmenu, true );
			}

		}
		
	}	
	
	// Get all the link elements within the menu.
	var primaryMenuTargets = primaryMenu.getElementsByTagName( 'a' );

	// Toggle focus each time a menu link is focused.
	for ( const target of primaryMenuTargets ) {
		target.addEventListener( 'focus', focusSubmenu, true );
		target.addEventListener( 'blur', focusSubmenu, true );
	}
	
	// Close menu and submenus, when menu changes from mobile to desktop navigation.
	let   buttonContainerDisplay = window.getComputedStyle( toggleButtonContainer ).display;
	
	window.addEventListener( 'resize', function() {

		if ( buttonContainerDisplay !== window.getComputedStyle( toggleButtonContainer ).display ) {
			closeMenu();
			closeSubmenu();
			buttonContainerDisplay = window.getComputedStyle( toggleButtonContainer ).display;
		}

	}, false );
	
	/**
	 * Toggles the submenu by adding or removing .submenu-open class.
	 */
	function toggleSubmenu() {

		if ( event.type === 'keydown' ) {
			var key = event.which || event.keyCode;
		}

		if ( ( event.type === 'click' || key === 13 ) && ( body.classList.contains( 'octo-dropdown-click' ) || mobileNavigation.classList.contains( 'toggled' ) ) ) {

			let self = this.closest( 'li' );

			//Prevent link from being executed.
			event.preventDefault();
			event.stopPropagation();

			// Get elements of all open child submenus by class name .submenu-open.
			var closestUl            = self.closest( 'ul' );
			var allOpenChildSubmenus = closestUl.querySelectorAll( '.submenu-open' );

			// Close all open child submenus by removing .submenu-open class.
			if ( ! self.classList.contains( 'submenu-open' ) && 0 < allOpenChildSubmenus.length ) {
				for ( var i = 0; i < allOpenChildSubmenus.length; i++ ) {
					var openChildSubmenu = allOpenChildSubmenus[i];
					openChildSubmenu.classList.remove( 'submenu-open' );
				}
			}

			self.classList.toggle( 'submenu-open' );

		}
	}
	
	/**
	 * Closes navigation menu by removing .toggled class.
	 */
	function closeMenu() {
		mobileNavigation.classList.remove( 'toggled' );
		mobileMenu.setAttribute( 'aria-hidden', 'true' );
		toggleButton.classList.remove( 'toggled' );
		toggleButton.setAttribute( 'aria-expanded', 'false' );
	}
	
	/**
	 * Closes all open submenus by removing .submenu-open classes from all elements.
	 */
	function closeSubmenu() {

		var openSubmenus = document.querySelectorAll( '.submenu-open' );

		if ( 0 < openSubmenus.length ) {
			for ( var i = 0; i < openSubmenus.length; i++ ) {
				var openSubmenu = openSubmenus[i];
				openSubmenu.classList.remove( 'submenu-open' );
			}
		}

	}
	
	/**
	 * Closes the sub menu, when a menu item without a sub menu is focused.
	 */
	function focusSubmenu() {

		if ( body.classList.contains( 'octo-dropdown-click' ) ) {

			let self = this.closest( 'li' );

			if ( ! self.classList.contains( 'menu-item-has-children' ) ) {
				let parent = self.parentNode;

				if ( ! parent.classList.contains( 'sub-menu' ) ) {
					closeSubmenu();
				}
			}

		} else {

			if ( event.type === 'focus' || event.type === 'blur' ) {

				let self = this;

				// Move up through the ancestors of the current link until we hit .nav-menu.
				while ( ! self.classList.contains( 'nav-menu' ) ) {
					// On li elements toggle the class .focus.
					if ( 'li' === self.tagName.toLowerCase() ) {
						self.classList.toggle( 'focus' );
					}
					self = self.parentNode;
				}

			}

		}

	}
	
	/**
	 * Add a class, if mouse is used to navigate the site.
	 */
	if ( 'querySelector' in document && 'addEventListener' in window ) {
		body.addEventListener( 'mousedown', function() {
			body.classList.add( 'octo-using-mouse' );
		} );

		body.addEventListener( 'keydown', function() {
			body.classList.remove( 'octo-using-mouse' );
		} );
	}

}() );
