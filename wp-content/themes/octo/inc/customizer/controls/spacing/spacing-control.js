( function( $ ) {
	/**
	 * File spacing-responsive.js
	 *
	 * Handles spacing responsive control
	 *
	 * @package Octo
	 */

	wp.customize.controlConstructor['octo-spacing'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';
            
            var control     = this;
			
			// Toggle class for linkin inputs.
			this.container.on( 'click', '.octo-link-inputs', function() {
				
				$( this ).closest( '.octo-controls-wrapper' ).toggleClass( 'inputs-linked' );				

            } );
			
			// Sync linked inputs.
			this.container.on( 'input', '.octo-controls-wrapper.inputs-linked input.octo-spacing-number', function() {
				
				var _this  = $( this ),
					inputs = _this.closest( '.octo-controls-wrapper.inputs-linked' ).find( 'input.octo-spacing-number' ),
					value  = _this.val();

				inputs.val( value );

            } );
			
			// Change input attributes depending on the chosen unit.
			this.container.on( 'change', 'select.octo-spacing-unit', function() {

				var _this          = $( this ),
					container      = _this.closest( '.octo-controls-wrapper' ),
					inputNumber    = container.find( 'input.octo-spacing-number' ),
					inputUnit      = container.find( 'input.octo-spacing-unit' ),
					selectedUnit   = container.find( 'select.octo-spacing-unit option:selected' ).val(),
					defaults       = control.params[ 'inputAttrsDefaults' ][ selectedUnit ];

				$.each( defaults, function( key, value ) {
					container.find( 'input' ).attr( key, value );
				} );

				inputNumber.trigger( 'input' );

			} );
			
			// Reset to default value
			this.container.on( 'click', 'button.octo-reset-button', function() {

				var _this        = $( this ),
					selector     = ( control.params[ 'responsive' ] ) ? '.octo-controls-wrapper.active' : '.octo-controls-wrapper',
					container    = _this.parents( '.customize-control-octo-spacing' ).find( selector ),
					inputNumber  = container.find( 'input.octo-spacing-number' ),
					selectUnit   = container.find( 'select.octo-spacing-unit' ),
					defaultUnit  = selectUnit.data( 'default' ),
					defaultValue = inputNumber.data( 'default' ),
					optionsUnit  = container.find( 'select.octo-spacing-unit option' );

				optionsUnit.removeAttr( 'selected' );
				selectUnit.val( defaultUnit );
				inputNumber.val( defaultValue );
				selectUnit.trigger( 'change' );
				inputNumber.trigger( 'input' );

			} );
                        
			// Save changes
            this.container.on( 'input', 'input.octo-spacing-number', function() {
               
				var _this        = $( this ),
					container    = _this.closest( '.octo-controls-wrapper' ),
					inputNumber  = container.find( 'input.octo-spacing-number' ),
					inputUnit    = container.find( 'input.octo-spacing-unit' ),
					selectUnit   = container.find( 'select.octo-spacing-unit option:selected' ),
					device       = container.data( 'device' ),
					setting      = control.settings[device],
					values       = {};

				inputNumber.each( function() {
					let _this = $( this ),
						value = _this.val(),
						item  = _this.data( 'item' );
					
					values[ item ] = value;
					
				} );
				
				if ( 0 < selectUnit.length ) {
					values['unit'] = selectUnit.val();
				} else {
					values['unit'] = inputUnit.val();
				}

				setting.set( values );
			
            } );
		}
	});
})(jQuery);