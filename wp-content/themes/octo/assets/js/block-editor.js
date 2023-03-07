/**
 * File block-editor.js.
 *
 * Enhances the block editor for a better user experience.
 *
 * @package octo
 * @since   1.0.0
 */

jQuery( document ).ready( function( $ ) {

	/**
	 * Calculate the content width depending on the selected content layout and sidebar layout in the metabox settings.
	 */
	var metabox = $( '#octo-settings-metabox' );

	metabox.on( 'change', 'select', function( event ) {

		if ( 'octo-content-layout' === event.target.id || 'octo-sidebar-layout' === event.target.id ) {
			
			var contentLayout         = $( '#octo-content-layout option:selected' ).val(),
				sidebarLayoutMeta     = $( '#octo-sidebar-layout option:selected' ).val(),
				containerWidth        = parseInt( octoBlockEditor.containerWidth ),
				defaultSidebarLayout  = octoBlockEditor.defaultSidebarLayout,
				singularSidebarLayout = octoBlockEditor.singularSidebarLayout,
				sidebarWidth          = parseInt( octoBlockEditor.sidebarWidth ),
				outerContentSpacing   = parseInt( octoBlockEditor.outerContentSpacing ),
				innerContentSpacing   = parseInt( octoBlockEditor.innerContentSpacing ),
				sidebarMargin         = parseInt( octoBlockEditor.sidebarMargin ),
				containerLayout       = parseInt( octoBlockEditor.containerLayout ),
				sidebarLayout,
				contentWidth;

			// Calculate the content width.
			if ( 'full_width' === contentLayout ) {

				contentWidth = '100%';

				// Set CSS values.
				$( '.block-editor .editor-styles-wrapper' ).css( { 'padding-left': '0', 'padding-right': '0' } );
				$( '.block-editor .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block[data-align="full"]' ).css( { 'margin-left': '0', 'margin-right': '0' } );

			} else {

				// Determine the sidebar layout. Metabox settings need to overwrite the customizer settings, in case they are set. If not, we will just use the customizer settings.
				if ( 'default' === sidebarLayoutMeta || 'undefined' === typeof sidebarLayoutMeta ) {

					sidebarLayout = defaultSidebarLayout;

					if ( 'default' != singularSidebarLayout && 'undefined' != typeof singularSidebarLayout ) {

						sidebarLayout = singularSidebarLayout;
					}

				} else {
					sidebarLayout = sidebarLayoutMeta;
				}

				// Calculate content width depending on if there is a sidebar or not.
				if ( 'disabled' === sidebarLayout || 'undefined' === typeof sidebarLayout ) {
					contentWidth = containerWidth - ( outerContentSpacing + innerContentSpacing ) + 'px';					
				} else {
					contentWidth = ( containerWidth - outerContentSpacing ) / 100 * ( 100 - sidebarWidth ) - ( sidebarMargin + innerContentSpacing ) + 'px';
				}

				// Set CSS values.
				$( '.block-editor .editor-styles-wrapper' ).css( { 'padding-left': '20px', 'padding-right': '20px' } );
				$( '.block-editor .editor-styles-wrapper .block-editor-block-list__layout.is-root-container > .wp-block[data-align="full"]' ).css( { 'margin-left': '-20px', 'margin-right': '-20px' } );

			}

			// Set CSS values.
			$( ':root' ).css( '--octo-post-editor-content-width', contentWidth );
			$( '.block-editor .editor-styles-wrapper .wp-block-quote' ).css( 'max-width', 'calc(' + contentWidth + ' - 1.5rem)' );
			$( '.block-editor .wp-block[data-align=wide]' ).css( 'max-width', 'calc(' + contentWidth + ' + 120px)' );

			}

	} );

} );
