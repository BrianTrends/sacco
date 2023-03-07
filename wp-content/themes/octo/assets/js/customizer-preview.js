/**
 * File customizer-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package octo
 * @since   1.0.0
 */

( function( $ ) {
	
	/*
	 * Text live previews.
	 */
	
	// Site title.
	octoTextPreview( 'blogname', '.site-title a' );
	
	// Site description.
	octoTextPreview( 'blogdescription', '.site-description' );
	
	// Toggle button text.
	octoTextPreview( 'octo_settings[toggle_button_text]', '.menu-toggle-text' );
	
	// Breadcrumb separator.
	octoTextPreview( 'octo_settings[breadcrumbs_separator]', '.breadcrumb-separator' );

	
	
	
	
	/*
	 * Range live previews.
	 */
	
	// Container Width.
	var containerWidthRule = [
		[':root', '--octo-container-width']
	];
	octoRangePreview( 'octo_settings[container_width]', containerWidthRule );
	
	// Button border radius.
	var buttonBorderRadiusRule = [
		[':root', '--octo-button-border-radius']
	];
	octoRangePreview( 'octo_settings[button_border_radius]', buttonBorderRadiusRule );
	
	// Button border width.
	var buttonBorderWidthRules = [
		[':root', '--octo-button-border-width'],
	];
	octoRangePreview( 'octo_settings[button_border_width]', buttonBorderWidthRules );
	
	// Forms border radius.
	var formsBorderRadiusRules = [
		[':root', '--octo-forms-border-radius'],
	];
	octoRangePreview( 'octo_settings[form_border_radius]', formsBorderRadiusRules );
	
	// Forms border width.
	var formsBorderWidthRules = [
		[':root', '--octo-forms-border-width'],
	];
	octoRangePreview( 'octo_settings[form_border_width]', formsBorderWidthRules );
	
	// Sidebar font size.
	var sidebarFontSizeRules = [
		[':root', '--octo-sidebar-font-size'],
	];
	octoRangePreview( 'octo_settings[sidebar_font_size_desktop]', sidebarFontSizeRules );
	octoRangePreview( 'octo_settings[sidebar_font_size_tablet]', sidebarFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[sidebar_font_size_mobile]', sidebarFontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// Body font Size.
	var bodyFontSizeRule = [
		[':root', '--octo-body-font-size'],
	];
	octoRangePreview( 'octo_settings[body_font_size_desktop]', bodyFontSizeRule );
	octoRangePreview( 'octo_settings[body_font_size_tablet]', bodyFontSizeRule, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[body_font_size_mobile]', bodyFontSizeRule, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// Body line height.
	var BodyLineHeightRule = [
		['html, body, button, input, select, optgroup, textarea', 'line-height'],
	];
	octoRangePreview( 'octo_settings[body_line_height]', BodyLineHeightRule );
	
	// Paragraph spacing.
	var paragraphSpacingRule = [
		[':root', '--octo-paragraph-spacing'],
		//['[class^="wp-block-"].alignfull + :not(.alignfull)', 'margin-top'],
	];
	octoRangePreview( 'octo_settings[paragraph_spacing]', paragraphSpacingRule );
	
	// Heading spacing bottom.
	var headingsSpacingBottomRule = [
		[':root', '--octo-headings-spacing'],
	];
	octoRangePreview( 'octo_settings[headings_spacing]', headingsSpacingBottomRule );
	
	// Heading line height.
	var headingsLineHeightRule = [
		[':root', '--octo-headings-line-height'],
	];
	octoRangePreview( 'octo_settings[headings_line_height]', headingsLineHeightRule );
	
	// H1 font size.
	var h1FontSizeRules = [
		[':root', '--octo-h1-font-size'],
	];
	octoRangePreview( 'octo_settings[h1_font_size_desktop]', h1FontSizeRules );
	octoRangePreview( 'octo_settings[h1_font_size_tablet]', h1FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h1_font_size_mobile]', h1FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H1 line-height.
	var h1LineHeightRules = [
		[':root', '--octo-h1-line-height'],
	];
	octoRangePreview( 'octo_settings[h1_line_height]', h1LineHeightRules );
	
	// H1 spacing bottom.
	var h1SpacingBottomRules = [
		[':root', '--octo-h1-spacing'],
	];
	octoRangePreview( 'octo_settings[h1_spacing_bottom]', h1SpacingBottomRules );	
	
	// H1 entry title font size.
	var h1EntryTitleFontSizeRules = [
		[':root', '--octo-h1-entry-title-font-size'],
	];
	octoRangePreview( 'octo_settings[h1_entry_title_font_size_desktop]', h1EntryTitleFontSizeRules );
	octoRangePreview( 'octo_settings[h1_entry_title_font_size_tablet]', h1EntryTitleFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h1_entry_title_font_size_mobile]', h1EntryTitleFontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H2 font size.
	var h2FontSizeRules = [
		[':root', '--octo-h2-font-size'],
	];
	octoRangePreview( 'octo_settings[h2_font_size_desktop]', h2FontSizeRules );
	octoRangePreview( 'octo_settings[h2_font_size_tablet]', h2FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h2_font_size_mobile]', h2FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H2 line-height.
	var h2LineHeightRules = [
		[':root', '--octo-h2-line-height'],
	];
	octoRangePreview( 'octo_settings[h2_line_height]', h2LineHeightRules );
	
	// H2 spacing bottom.
	var h2SpacingBottomRules = [
		[':root', '--octo-h2-spacing'],
	];
	octoRangePreview( 'octo_settings[h2_spacing_bottom]', h2SpacingBottomRules );
	
	// H2 entry title font size.
	var h2EntryTitleFontSizeRules = [
		[':root', '--octo-h2-entry-title-font-size'],
	];
	octoRangePreview( 'octo_settings[h2_entry_title_font_size_desktop]', h2EntryTitleFontSizeRules );
	octoRangePreview( 'octo_settings[h2_entry_title_font_size_tablet]', h2EntryTitleFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h2_entry_title_font_size_mobile]', h2EntryTitleFontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H3 font size.
	var h3FontSizeRules = [
		[':root', '--octo-h3-font-size'],
	];
	octoRangePreview( 'octo_settings[h3_font_size_desktop]', h3FontSizeRules );
	octoRangePreview( 'octo_settings[h3_font_size_tablet]', h3FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h3_font_size_mobile]', h3FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H3 line-height.
	var h3LineHeightRules = [
		[':root', '--octo-h3-line-height'],
	];
	octoRangePreview( 'octo_settings[h3_line_height]', h3LineHeightRules );
	
	// H3 spacing bottom.
	var h3SpacingBottomRules = [
		[':root', '--octo-h3-spacing'],
	];
	octoRangePreview( 'octo_settings[h3_spacing_bottom]', h3SpacingBottomRules );	
	
	// H4 font size.
	var h4FontSizeRules = [
		[':root', '--octo-h4-font-size'],
	];
	octoRangePreview( 'octo_settings[h4_font_size_desktop]', h4FontSizeRules );
	octoRangePreview( 'octo_settings[h4_font_size_tablet]', h4FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h4_font_size_mobile]', h4FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H4 line-height.
	var h4LineHeightRules = [
		[':root', '--octo-h4-line-height'],
	];
	octoRangePreview( 'octo_settings[h4_line_height]', h4LineHeightRules );
			
	// H5 font size.
	var h5FontSizeRules = [
		[':root', '--octo-h5-font-size'],
	];
	octoRangePreview( 'octo_settings[h5_font_size_desktop]', h5FontSizeRules );
	octoRangePreview( 'octo_settings[h5_font_size_tablet]', h5FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h5_font_size_mobile]', h5FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H5 line-height.
	var h5LineHeightRules = [
		[':root', '--octo-h5-line-height'],
	];
	octoRangePreview( 'octo_settings[h5_line_height]', h5LineHeightRules );
	
	// H6 font size.
	var h6FontSizeRules = [
		[':root', '--octo-h6-font-size'],
	];
	octoRangePreview( 'octo_settings[h6_font_size_desktop]', h6FontSizeRules );
	octoRangePreview( 'octo_settings[h6_font_size_tablet]', h6FontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[h6_font_size_mobile]', h6FontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// H6 line-height.
	var h6LineHeightRules = [
		[':root', '--octo-h6-line-height'],
	];
	octoRangePreview( 'octo_settings[h6_line_height]', h6LineHeightRules );
		
	// Custom logo width. 
	var customLogoWidthRule = [
		[':root', '--octo-custom-logo-width'],
	];
	octoRangePreview( 'octo_settings[logo_width_desktop]', customLogoWidthRule );
	octoRangePreview( 'octo_settings[logo_width_tablet]', customLogoWidthRule, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[logo_width_mobile]', customLogoWidthRule, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// Mobile logo width.
	var customLogoMobileWidthRule = [
		[':root', '--octo-custom-logo-mobile-width'],
	];
	octoRangePreview( 'octo_settings[mobile_logo_width]', customLogoMobileWidthRule );
	
	// Header border bottom height.
	var headerBorderBottomWidthRule = [
		[':root', '--octo-header-border-bottom-width'],
	];
	octoRangePreview( 'octo_settings[header_border_bottom_width]', headerBorderBottomWidthRule );
		
	// Menu item width.
	var menuItemWidthRule = [
		[':root', '--octo-menu-item-width' ],
	];
	octoRangePreview( 'octo_settings[menu_item_width]', menuItemWidthRule );
	
	// Menu item height.
	var menuItemHeightRule = [
		[':root', '--octo-menu-item-height'],
	];
	octoRangePreview( 'octo_settings[menu_item_height]', menuItemHeightRule );
	
	// Submenu item height.
	var submenuItemHeightRules = [
		[':root', '--octo-submenu-item-height'],
	];
	octoRangePreview( 'octo_settings[submenu_item_height]', submenuItemHeightRules );
	
	// Submenu width.
	var submenuWidthRules = [
		[':root', '--octo-submenu-width'],
	];
	octoRangePreview( 'octo_settings[submenu_width]', submenuWidthRules );	
	
	// Menu font size.
	var menuFontSizeRules = [
		[':root', '--octo-menu-font-size'],
	];
	octoRangePreview( 'octo_settings[menu_font_size]', menuFontSizeRules );
	
	// Submenu font size.
	var submenuFontSizeRules = [
		[':root', '--octo-submenu-font-size'],
	];
	octoRangePreview( 'octo_settings[submenu_font_size]', submenuFontSizeRules );
	
	// Mobile menu item width.
	var mobileMenuItemWidthRules = [
		[':root', '--octo-mobile-menu-item-width'],
	];
	octoRangePreview( 'octo_settings[mobile_menu_item_width]', mobileMenuItemWidthRules );
	
	// Mobile menu item height.
	var mobileMenuItemHeightRules = [
		[':root', '--octo-mobile-menu-item-height'],
	];
	octoRangePreview( 'octo_settings[mobile_menu_item_height]', mobileMenuItemHeightRules );
	
	// Mobile menu font size.
	var mobileMenuFontSizeRules = [
		[':root', '--octo-mobile-menu-font-size'],
	];
	octoRangePreview( 'octo_settings[mobile_menu_font_size]', mobileMenuFontSizeRules );
	
	// Sidebar width.
	var sidebarWidthRule = [
		[':root', '--octo-sidebar-width'],
	];
	octoRangePreview( 'octo_settings[sidebar_width]', sidebarWidthRule, 'min-width: ' + octoBreakpoints[ 'sidebar_breakpoint_min_width' ] );
	
	// Sidebar separator spacing.
	var sidebarSeparatorSpacingRules = [
		[':root', '--octo-sidebar-separator-spacing'],
	];
	octoRangePreview( 'octo_settings[sidebar_separator_spacing]', sidebarSeparatorSpacingRules );
	
	// Blog container width.
	var blogContainerWidthRules = [
		[':root', '--octo-container-width-archive'],
	];
	octoRangePreview( 'octo_settings[blog_container_width]', blogContainerWidthRules );
	
	// Single post container width.
	var singlePostContainerWidthRules = [
		[':root', '--octo-container-width-post'],
	];
	octoRangePreview( 'octo_settings[single_post_container_width]', singlePostContainerWidthRules );
	
	// Title font size.
	var titleFontSizeRules = [
		[':root', '--octo-title-font-size'],
	];
	octoRangePreview( 'octo_settings[title_font_size_desktop]', titleFontSizeRules );
	octoRangePreview( 'octo_settings[title_font_size_tablet]', titleFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[title_font_size_mobile]', titleFontSizeRules, 'font-size', 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// Tagline font size.
	var taglineFontSizeRules = [
		[':root', '--octo-tagline-font-size'],
	];
	octoRangePreview( 'octo_settings[tagline_font_size_desktop]', taglineFontSizeRules );
	octoRangePreview( 'octo_settings[tagline_font_size_tablet]', taglineFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[tagline_font_size_mobile]', taglineFontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );
	
	// Footer font size.
	var footerFontSizeRules = [
		[':root', '--octo-footer-font-size'],
	];
	octoRangePreview( 'octo_settings[footer_font_size_desktop]', footerFontSizeRules );
	octoRangePreview( 'octo_settings[footer_font_size_tablet]', footerFontSizeRules, 'max-width: ' + octoBreakpoints[ 'medium_max_width' ] );
	octoRangePreview( 'octo_settings[footer_font_size_mobile]', footerFontSizeRules, 'max-width: ' + octoBreakpoints[ 'small_max_width' ] );

	
	
	
	
	/*
	 * Color live previews.
	 */
	
	// Body background color.
	var bodyBgColorRule = [
		[':root', '--octo-body-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[body_bg_color]', bodyBgColorRule );
	
	// Content background color.
	var contentBgColorRule = [
		[':root', '--octo-content-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[content_bg_color]', contentBgColorRule );
	
	// Header background color.
	var headerBgColorRule = [
		[':root', '--octo-header-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[header_bg_color]', headerBgColorRule );
	
	// Header border bottom color.
	var headerBorderBottomColorRule = [
		['.main-header, .sticky-header .main-header', 'border-bottom-color'],
	];
	octoColorPickerPreview( 'octo_settings[header_border_bottom_color]', headerBorderBottomColorRule );
	
	// Title font color.
	var titleFontColorRules = [
		[':root', '--octo-title-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[title_font_color]', titleFontColorRules );
	
	// Title font color hover.
	var titleFontColorHoverRules = [
		[':root', '--octo-title-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[title_font_color_hover]', titleFontColorHoverRules );
	
	// Tagline font color.
	var taglineFontColorRules = [
		[':root', '--octo-tagline-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[tagline_font_color]', taglineFontColorRules );
	
	// Sidebar background color.
	var sidebarBgColorRule = [
		[':root', '--octo-sidebar-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[sidebar_bg_color]', sidebarBgColorRule );
	
	// Sidebar headings color.
	var sidebarHeadingsFontColorRules = [
		[':root', '--octo-sidebar-h1-color'],
		[':root', '--octo-sidebar-h2-color'],
		[':root', '--octo-sidebar-h3-color'],
		[':root', '--octo-sidebar-h4-color'],
		[':root', '--octo-sidebar-h5-color'],
		[':root', '--octo-sidebar-h6-color'],
	];
	octoColorPickerPreview( 'octo_settings[sidebar_headings_color]', sidebarHeadingsFontColorRules );
	
	// Sidebar font color.
	var sidebarFontColorRules = [
		[':root', '--octo-sidebar-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[sidebar_font_color]', sidebarFontColorRules );
	
	// Sidebar link color.
	var sidebarLinkColorRules = [
		[':root', '--octo-sidebar-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[sidebar_link_color]', sidebarLinkColorRules );
	
	// Sidebar link color hover.
	var sidebarLinkHoverColorRules = [
		[':root', '--octo-sidebar-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[sidebar_link_color_hover]', sidebarLinkHoverColorRules );
	
	// Button font-color.
	var buttonFontColorRule = [
		[':root', '--octo-button-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[button_font_color]', buttonFontColorRule );
	
	// Button font-color hover.
	var buttonFontColorHoverRule = [
		[':root', '--octo-button-font-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[button_font_color_hover]', buttonFontColorHoverRule );
	
	// Button background color.
	var buttonBgColorRule = [
		[':root', '--octo-button-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[button_bg_color]', buttonBgColorRule );
	
	// Button background color hover.
	var buttonBgColorHoverRule = [
		[':root', '--octo-button-bg-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[button_bg_color_hover]', buttonBgColorHoverRule );
	
	// Button border color.
	var buttonBorderColorRules = [
		[':root', '--octo-button-border-color'],
	];
	octoColorPickerPreview( 'octo_settings[button_border_color]', buttonBorderColorRules );
	
	// Button border color hover.
	var buttonBorderColorHoverRules = [
		[':root', '--octo-button-border-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[button_border_color_hover]', buttonBorderColorHoverRules );
	
	// Forms background color.
	var formsBgColorRules = [
		[':root', '--octo-forms-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[form_bg_color]', formsBgColorRules );
	
	// Forms border color.
	var formsBorderColorRules = [
		[':root', '--octo-forms-border-color'],
	];
	octoColorPickerPreview( 'octo_settings[form_border_color]', formsBorderColorRules );
	
	// Forms border color focus.
	var formsBorderColorFocusRules = [
		[':root', '--octo-forms-border-color-focus'],
	];
	octoColorPickerPreview( 'octo_settings[form_border_color_focus]', formsBorderColorFocusRules );

	// Menu background color.
	var menuBgColorRule = [
		[':root', '--octo-menu-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[menu_bg_color]', menuBgColorRule );
	
	// Menu link color.
	var menuLinkColorRules = [
		[':root', '--octo-menu-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[menu_link_color]', menuLinkColorRules );
	
	// Menu link color hover.
	var menuLinkColorHoverRules = [
		[':root', '--octo-menu-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[menu_link_color_hover]', menuLinkColorHoverRules );
	
	// Submenu background color.
	var submenuBgColorRule = [
		[':root', '--octo-submenu-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[submenu_bg_color]', submenuBgColorRule );
	
	// Submenu link color.
	var submenuLinkColorRules = [
		[':root', '--octo-submenu-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[submenu_link_color]', submenuLinkColorRules );
	
	// Submenu link color hover.
	var submenuLinkColorHoverRules = [
		[':root', '--octo-submenu-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[submenu_link_color_hover]', submenuLinkColorHoverRules );
		
	// Mobile menu background color.
	var mobileMenuBgColorRules = [
		[':root', '--octo-mobile-menu-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_menu_bg_color]', mobileMenuBgColorRules );
	
	// Mobile menu link color.
	var mobileMenuLinkColorRules = [
		[':root', '--octo-mobile-menu-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_menu_link_color]', mobileMenuLinkColorRules );
	
	// Mobile menu link color hover.
	var mobileMenuLinkColorHoverRules = [
		[':root', '--octo-mobile-menu-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_menu_link_color_hover]', mobileMenuLinkColorHoverRules );
	
	// Mobile submenu background color.
	var mobileSubmenuBgColorRules = [
		[':root', '--octo-mobile-submenu-bg-color'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_submenu_bg_color]', mobileSubmenuBgColorRules );
	
	// Mobile submenu link color.
	var mobileSubmenuLinkColorRules = [
		[':root', '--octo-mobile-submenu-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_submenu_link_color]', mobileSubmenuLinkColorRules );
	
	// Mobile submenu link color hover.
	var mobileSubmenuLinkColorHoverRules = [
		[':root', '--octo-mobile-submenu-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[mobile_submenu_link_color_hover]', mobileSubmenuLinkColorHoverRules );
	
	// Footer background color.
	var footerBgColorRule = [
		[':root', '--octo-footer-bg-color']
	];
	octoColorPickerPreview( 'octo_settings[footer_bg_color]', footerBgColorRule );
	
	// Footer heading font-color.
	var footerHeadingsColorRules = [
		[':root', '--octo-footer-h1-color'],
		[':root', '--octo-footer-h2-color'],
		[':root', '--octo-footer-h3-color'],
		[':root', '--octo-footer-h4-color'],
		[':root', '--octo-footer-h5-color'],
		[':root', '--octo-footer-h6-color'],
	];
	octoColorPickerPreview( 'octo_settings[footer_headings_color]', footerHeadingsColorRules );
	
	// Footer content font-color.
	var footerFontColorRules = [
		[':root', '--octo-footer-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[footer_font_color]', footerFontColorRules );
	
	// Footer link color.
	var footerLinkColorRules = [
		[':root', '--octo-footer-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[footer_link_color]', footerLinkColorRules );
	
	// Footer link color hover.
	var footerLinkColorHoverRules = [
		[':root', '--octo-footer-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[footer_link_color_hover]', footerLinkColorHoverRules );
	
	// Body font color.
	var bodyFontColorRule = [
		[':root', '--octo-body-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[body_font_color]', bodyFontColorRule );
	
	// Body link color.
	var bodyLinkColorRule = [
		[':root', '--octo-body-link-color'],
	];
	octoColorPickerPreview( 'octo_settings[body_link_color]', bodyLinkColorRule );
	
	// Body link color hover.
	var bodyLinkColorHoverRule = [
		[':root', '--octo-body-link-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[body_link_color_hover]', bodyLinkColorHoverRule );
	
	// Heading font color.
	var headingFontColorRule = [
		[':root', '--octo-headings-color'],
	];
	octoColorPickerPreview( 'octo_settings[headings_font_color]', headingFontColorRule );
	
	// H1 font-color.
	var h1FontColorRules = [
		[':root', '--octo-h1-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h1_font_color]', h1FontColorRules );
	
	// H1 entry title font-color.
	var h1EntryTitleFontColorRules = [
		[':root', '--octo-h1-entry-title-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h1_entry_title_font_color]', h1EntryTitleFontColorRules );
	
	// H2 font-color.
	var h2FontColorRules = [
		[':root', '--octo-h2-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h2_font_color]', h2FontColorRules );
	
	// H2 entry title link color.
	var h2EntryTitleLinkColorRules = [
		[':root', '--octo-h2-entry-title-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h2_entry_title_link_color]', h2EntryTitleLinkColorRules );
	
	// H2 entry title link color hover.
	var h2EntryTitleLinkColorHoverRules = [
		[':root', '--octo-h2-entry-title-font-color-hover'],
	];
	octoColorPickerPreview( 'octo_settings[h2_entry_title_link_color_hover]', h2EntryTitleLinkColorHoverRules );
	
	// H3 font-color.
	var h3FontColorRules = [
		[':root', '--octo-h3-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h3_font_color]', h3FontColorRules );
	
	// H4 font-color.
	var h4FontColorRules = [
		[':root', '--octo-h4-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h4_font_color]', h4FontColorRules );
	
	// H5 font-color.
	var h5FontColorRules = [
		[':root', '--octo-h5-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h5_font_color]', h5FontColorRules );
	
	// H6 font-color.
	var h6FontColorRules = [
		[':root', '--octo-h6-font-color'],
	];
	octoColorPickerPreview( 'octo_settings[h6_font_color]', h6FontColorRules );
	
	
	
	
	
	/*
	 * Spacing live previews.
	 */
	
	// Button spacing.
	var buttonSpacingRules = [
		[':root', ['--octo-button-spacing-top', '--octo-button-spacing-right', '--octo-button-spacing-bottom', '--octo-button-spacing-left']],
	];
	octoSpacingPreview( 'octo_settings[button_spacing]', buttonSpacingRules );
	
	// Forms spacing.
	var formsSpacingRules = [
		[':root', ['--octo-forms-spacing-top', '--octo-forms-spacing-right', '--octo-forms-spacing-bottom', '--octo-forms-spacing-left']],
	];
	octoSpacingPreview( 'octo_settings[form_spacing]', formsSpacingRules );
		
}( jQuery ) );
