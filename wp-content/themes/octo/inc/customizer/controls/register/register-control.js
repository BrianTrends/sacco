/**
 * File regsiter-control.js
 *
 * Handles register control
 *
 * @package octo
 * @since   1.1.0
 */

( function( $ ) {

	wp.customize.controlConstructor['octo-register'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';

			var control          = this,
				registerControls = control.params.registerControls,				
				activeRegister   = control.params.activeRegister;

			wp.customize.bind( 'ready', function () {
				for ( var card in registerControls ) {

					registerControls[ card ].forEach( function ( controlID ) {

						var control = wp.customize.control( controlID );
						
						$( control.container ).attr( 'data-register', card );

						if ( activeRegister === card ) {
							control.container.addClass( 'show' );
						}
						
					} );
				}
			});
			
			//wp.customize.control
			this.container.on( 'click', 'label', function() {
				
					var _this    = $( this ),
						card     = _this.prev( 'input[type=radio]' ).val(),
						section  = _this.closest( 'ul.control-section' ),
						controls = section.children( '[data-register]' ),
						selected = section.children( '[data-register=' + card + ']' );

				controls.removeClass( 'show' );
				selected.addClass( 'show' );
	
			} );
			
		}
	} );	
} )( jQuery );
