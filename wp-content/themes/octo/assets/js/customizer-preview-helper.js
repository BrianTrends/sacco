/**
 * File customizer-preview-helper.js.
 *
 * Helper functions for the customizer preview.
 *
 * @package octo
 * @since   1.0.6
 */
	
/**
 * Add inline css.
 *
 * @param String id    ID of the customizer control.
 * @param String style CSS code.
 */ 
function octoAddInlineCSS( id, style ) {

	var styleNode     = document.createElement( 'style' ),
		inlineCSSNode = document.getElementById( id );

	styleNode.setAttribute( 'id', id );
	styleNode.setAttribute( 'type', 'text/css' );
	styleNode.innerHTML = style;
	
	if ( null !== inlineCSSNode ) {
		inlineCSSNode.replaceWith( styleNode );
	} else {
		document.head.appendChild( styleNode );
	}
}

/**
 * Add inline css.
 *
 * @param Array  rules CSS selectors and properties.
 * @param String value CSS property value.
 */ 
function octoBuildStyle( rules, value ) {
	
	var style = '';

	if ( Array.isArray( rules ) && '' !== value ) {
		// Iterate through the rules and build the css code.
		rules.forEach( function( rule ) {
			let selector = rule[0],
				property = rule[1];

			style += selector + '{' + property + ':' + value + ';}';
		} );
		
		return style;
	}
	
}

/**
 * Live preview update for color picker control.
 *
 * @param String id    ID of the customizer control.
 * @param Array  rules CSS selectors and properties.
 */
function octoColorPickerPreview( id, rules, defaultValue = '' ) {
	wp.customize( id, function( value ) {
		value.bind( function( newValue ) {	
			
			var style = '';
			
			if ( '' === newValue ) {
				if ( '' !== defaultValue ) {
					newValue = defaultValue;
				}
			}

			if ( '' !== newValue ) {
				style = octoBuildStyle( rules, newValue );				
				octoAddInlineCSS( id, style );
			} else {
				wp.customize.preview.send( 'refresh' );
			}

		} );
	} );	
}

/**
 * Live preview update for range control.
 *
 * @param String id         ID of the customizer control.
 * @param Array  rules      CSS selectors and properties.
 * @param String mediaQuery CSS media query.
 */
function octoRangePreview( id, rules, mediaQuery ) {
	wp.customize( id, function( value ) {
		value.bind( function( newValue ) {
	
			var propertyValue = '',
				style         = '';

			if ( 'undefined' !== typeof newValue['value'] && 'undefined' !== typeof newValue['unit'] && '' !== newValue['value'] ) {
				propertyValue = newValue['value'] + newValue['unit'];				 
			} else if ( 'object' !== typeof newValue ) {
				propertyValue = newValue;
			}				

			if ( '' !== propertyValue ) {
				
				style = octoBuildStyle( rules, propertyValue );
				
				if ( '' !== mediaQuery && typeof mediaQuery !== 'undefined' ) {                    
					style = '@media (' + mediaQuery + '){' + style + ';}}';
				}

				octoAddInlineCSS( id, style );
			} else {
				wp.customize.preview.send( 'refresh' );
			}

		} );
	} );
}

/**
 * Live preview update for range control when used for spacing.
 *
 * @param String id         ID of the customizer control.
 * @param Array  rules      CSS selectors and properties.
 * @param String mediaQuery CSS media query.
 */
function octoSpacingPreview( id, rules, mediaQuery ) {
	wp.customize( id, function( value ) {
		
		var prevValue = value.get();
		
		value.bind( function( newValue ) {
			
			var declaration = '', 
				style = '',
				refresh = false;
		
			if ( Array.isArray( rules ) ) {
				// Iterate through the rules and build the css code.
				rules.forEach( function( rule ) {
					let selector = rule[0],
						properties = rule[1],
						negate = ( rule[2] ) ? '-' : '';

					properties.forEach( function( property ) {
						
						jQuery.each( newValue, function( key, value ) {
							
							let propertyKey = property.split( '-' );
								propertyKey = propertyKey[propertyKey.length - 1];

							if ( 'unit' !== key && '' !== value && key === propertyKey ) {
								declaration += property + ':' + negate + value + newValue['unit'] + ';';
							} else if ( 'unit' !== key && '' === value && value !== prevValue[key] ) {
								refresh = true;
							}

						} );
						
					} );
					
					style += selector + '{' + declaration + '}';
					declaration = '';

				} );
				
			}
			
			if ( refresh ) {
				wp.customize.preview.send( 'refresh' );
			} else {				
			
				if ( '' !== mediaQuery && typeof mediaQuery !== 'undefined' ) {                    
					style = '@media (' + mediaQuery + '){' + style + ';}}';
				}
				
				octoAddInlineCSS( id, style );
				
				prevValue = newValue;
				
			}
			
		} );
	} );
}

/**
 * Live preview update for text control.
 */
function octoTextPreview( id, selector ) {
	wp.customize( id, function( value ) {
		value.bind( function( newValue ) {
			var element = jQuery( selector );
			element.text( newValue );
		} );
	} );
}