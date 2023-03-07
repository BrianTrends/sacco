/**
 * File customizer-controls.js.
 *
 * Enhances customizer controls.
 *
 * @package octo
 * @since   1.0.0
 */

( function( $ ) {

	wp.customize.bind( 'ready', function () {

		/**
		 * Responsive preview buttons.
		 * Change preview for different devices. Depending on the selected preview device, different controls are active in the customizer.
		 */
		$( 'ul.octo-responsive-buttons button' ).click( function() {

			var body       = $( '.wp-full-overlay' ),
				device     = $( this ).data( 'device' ),
				controls   = $( '.customize-control .octo-controls-wrapper' ),
				buttons    = $( '.octo-responsive-buttons li' ),
				wp_devices = $( '.wp-full-overlay-footer .devices' );

			// Change preview for different devices.
			body.removeClass( 'preview-desktop preview-tablet preview-mobile' ).addClass( 'preview-' + device );

			// Display active control for respective device.
			controls.removeClass( 'active' );
			$( '.octo-controls-wrapper.' + device ).addClass( 'active' );

			// Change active state of responsive buttons.
			buttons.removeClass( 'active' );
			$( '.octo-responsive-buttons .' + device ).addClass( 'active' );

			// Change state of WP buttons in the footer.
			wp_devices.find( 'button' ).removeClass( 'active' ).attr( 'aria-pressed', false );
			wp_devices.find( 'button.preview-' + device ).addClass( 'active' ).attr( 'aria-pressed', true );

		} );

		$( '.wp-full-overlay-footer .devices button' ).click( function() {

			var device   = $( this ).data( 'device' ),
				controls = $( '.customize-control .octo-controls-wrapper' ),
				buttons  = $( '.octo-responsive-buttons li' );

			// Reset active state of responsive buttons.
			buttons.removeClass( 'active' );

			// Add active state to current button.
			$( '.octo-responsive-buttons .' + device ).addClass( 'active' );

			// Display active control for respective device.
			controls.removeClass( 'active' );
			$( '.octo-controls-wrapper.' + device ).addClass( 'active' );

		} );
		
		/**
		 * Active callbacks for customizer controls.
		 */	
		// Background image position.
		var bodyBgImagePositionRule = [
			['', '!==', 'octo_settings[body_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[body_bg_image_position]', bodyBgImagePositionRule );
		
		// Background image size.
		var bodyBgImageSizeRule = [
			['', '!==', 'octo_settings[body_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[body_bg_image_size]', bodyBgImageSizeRule );
		
		// Background image repeat.
		var bodyBgImageRepeatRule = [
			['', '!==', 'octo_settings[body_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[body_bg_image_repeat]', bodyBgImageRepeatRule );
		
		// Background image attachement.
		var bodyBgImageAttachementRule = [
			['', '!==', 'octo_settings[body_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[body_bg_image_attachement]', bodyBgImageAttachementRule );
		
		// Header alignment.
		var headerAlignmentRule = [
			['nav_top', '===', 'octo_settings[header_layout]'],
			['nav_bottom', '===', 'octo_settings[header_layout]'],
		];		
		octoActiveCallback( 'octo_settings[header_alignment]', headerAlignmentRule );
		
		// Header widgth.
		var headerWidthRule = [
			['full', '===', 'octo_settings[container_layout]'],
			['separated', '===', 'octo_settings[container_layout]'],
		];
		octoActiveCallback( 'octo_settings[header_width]', headerWidthRule );
		
		// Header background image position.
		var headerBgImagePositionRule = [
			['', '!==', 'octo_settings[header_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[header_bg_image_position]', headerBgImagePositionRule );
		
		// Header background image size.
		var headerBgImageSizeRule = [
			['', '!==', 'octo_settings[header_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[header_bg_image_size]', headerBgImageSizeRule );
		
		// Header background image repeat.
		var headerBgImageRepeatRule = [
			['', '!==', 'octo_settings[header_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[header_bg_image_repeat]', headerBgImageRepeatRule );
		
		// Header background image attachement.
		var headerBgImageAttachementRule = [
			['', '!==', 'octo_settings[header_bg_image]'],
		];		
		octoActiveCallback( 'octo_settings[header_bg_image_attachement]', headerBgImageAttachementRule );
		
		// Navigation alignment.
		var navAlignmentRule = [
			['nav_top', '===', 'octo_settings[header_layout]'],
			['nav_bottom', '===', 'octo_settings[header_layout]'],
		];
		octoActiveCallback( 'octo_settings[nav_alignment]', navAlignmentRule );
		octoActiveCallback( 'separator_header_primary_navigation_2', navAlignmentRule );

		// Mobile menu breakpoint.
		var mobileMenuBreakpointRule = [
			['nav_top', '===', 'octo_settings[header_layout]'],
			['nav_bottom', '===', 'octo_settings[header_layout]'],
			['nav_inline', '===', 'octo_settings[header_layout]'],
		];
		octoActiveCallback( 'octo_settings[mobile_menu_breakpoint]', mobileMenuBreakpointRule );
		
		// Logo width.
		var logoWidthRules = [
			[0, '<', 'custom_logo'],
		];
		octoActiveCallback( 'octo_settings[logo_width]', logoWidthRules );
		
		// Mobile logo.
		var mobileLogoRules = [
			[0, '<', 'custom_logo'],
		];
		octoActiveCallback( 'octo_settings[mobile_logo]', mobileLogoRules );
		
		// Mobile logo width.
		var mobileLogoWidthRules = [
			[0, '<', 'custom_logo'],
		];
		octoActiveCallback( 'octo_settings[mobile_logo_width]', mobileLogoWidthRules );
		
		// Blog name.
		var blognameRules = [
			['', '===', 'custom_logo'],
		];
		octoActiveCallback( 'blogname', blognameRules );
		
		// Display title.
		var displayTitleRules = [
			['', '===', 'custom_logo'],
		];
		octoActiveCallback( 'octo_settings[display_title]', displayTitleRules );
		
		// Blog description.
		var blogdescriptionRules = [
			['', '===', 'custom_logo'],
		];
		octoActiveCallback( 'blogdescription', blogdescriptionRules );
		
		// Display tagline.
		var displayTaglineRules = [
			['', '===', 'custom_logo'],
		];
		octoActiveCallback( 'octo_settings[display_tagline]', displayTaglineRules );
		octoActiveCallback( 'separator_header_site_identity_2', displayTaglineRules );		
		
		// Blog post structure featured image.
		var blogPostStructureFeaturedImageRules = [
			['featured_image', '===', 'octo_settings[blog_post_layout]'],
		];
		octoActiveCallback( 'octo_settings[blog_post_structure_featured_image]', blogPostStructureFeaturedImageRules );
		
		// Blog post structure thumbnail.
		var blogPostStructureThumbnailRules = [
			['thumbnail_left', '===', 'octo_settings[blog_post_layout]'],
			['thumbnail_right', '===', 'octo_settings[blog_post_layout]'],
		];
		octoActiveCallback( 'octo_settings[blog_post_structure_thumbnail]', blogPostStructureThumbnailRules );
		
		// Single post structure featured image inside content.
		var singelPostStructureFeaturedImageInsideContentRules = [
			['inside_content', '===', 'octo_settings[single_post_layout]'],
		];
		octoActiveCallback( 'octo_settings[single_post_structure_featured_image_inside_content]', singelPostStructureFeaturedImageInsideContentRules );
		
		// Single post structure featured image before.
		var singelPostStructureFeaturedImageBeforeRules = [
			['full_width', '===', 'octo_settings[single_post_layout]'],
		];
		octoActiveCallback( 'octo_settings[single_post_structure_featured_image_full_width]', singelPostStructureFeaturedImageBeforeRules );
		
		// Content background color.
		var contentBgColorRules = [
			['boxed', '===', 'octo_settings[container_layout]'],
			['separated', '===', 'octo_settings[container_layout]'],
		];
		octoActiveCallback( 'octo_settings[content_bg_color]', contentBgColorRules );
		
		// Footer width.
		var footerWidthRules = [
			['full', '===', 'octo_settings[container_layout]'],
			['separated', '===', 'octo_settings[container_layout]'],
		];
		octoActiveCallback( 'octo_settings[footer_width]', footerWidthRules );
		octoActiveCallback( 'separator_footer_1', footerWidthRules );

	} );

} )( jQuery );
