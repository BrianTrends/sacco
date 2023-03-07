/**
 * File customizer-controls-helper.js.
 *
 * Helper functions for customizer controls.
 *
 * @package octo
 * @since   1.0.6
 */


/**
 * Compares two values according the given comparisonOperator.
 */
function compare( operator1, comparisonOperator, operator2 ) {

	switch ( comparisonOperator ) {
	case '<':
		return operator1 < operator2;
		break;
	case '===':
		return operator1 === operator2;
		break;
	case '!==':
		return operator1 !== operator2;
		break;
	default:
		return;
		break;
	}

}

/**
 * Set a customizer control active or inactive using a single conditional statement.
 *
 * @param String id         ID of the customizer control.
 * @param Array  rules      Condition rules, when a contronl needs to be active.
 */
function octoActiveCallback( id, rules ) {

	wp.customize.control( id, function( control ) {

		var	isActive = function () {
				
				if ( Array.isArray( rules ) ) {
					
					for ( var key in rules ) {

						let compareValue1 = rules[key][0],
							condition1    = rules[key][1],
							setting1      = wp.customize( rules[key][2] ),
							compareValue2 = ( rules[key][3] ) ? rules[key][3] : null,
							condition2    = ( rules[key][4] ) ? rules[key][4] : null,
							setting2      = ( rules[key][5] ) ? wp.customize( rules[key][5] ) : null;
						
						if ( 3 >= rules[key].length ) {							
							if ( true === compare( compareValue1, condition1, setting1.get() ) ) {
								
								return true;
							}	
						} else {
							if ( true === compare( compareValue1, condition1, setting1.get() ) && true === compare( compareValue2, condition2, setting2.get() ) ) {	
								return true;
							}
						}						
								
					}
				}
	
			};

		control.active.validate = isActive;
		control.active.set( isActive );		
		
		for ( var key in rules ) {

			let 
				setting1 = wp.customize( rules[key][2] ),
				setting2 = ( rules[key][5] ) ? wp.customize( rules[key][5] ) : null;

			setting1.bind( function( value ) {
				control.active.set( isActive );
			} );
			
			if ( null !== setting2 ) {
				setting2.bind( function( value ) {
					control.active.set( isActive );
				} );	
			}					

		}

	} );

};