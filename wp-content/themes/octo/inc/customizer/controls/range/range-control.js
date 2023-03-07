/**
 * File range-control.js
 *
 * Handles range control
 *
 * @package octo
 * @since   1.0.0
 */

( function( $ ) {

	wp.customize.controlConstructor['octo-range'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';

			var control = this;

			// Sync values for input range and number.
			this.container.on( 'input', '.octo-range-number, .octo-range-slider', function() {

				var _this = $( this ),
					container = _this.closest( '.octo-controls-wrapper' ),
					value     = _this.val(),
					input     = container.children( '.octo-range-number, .octo-range-slider' );

				input.val( value );

			} );

			// Change input attributes depending on the chosen unit.
			this.container.on( 'change', 'select.octo-range-unit', function() {

				var _this        = $( this ),
					container    = _this.closest( '.octo-controls-wrapper' ),
					inputNumber  = container.find( 'input.octo-range-number' ),
					inputUnit    = container.find( 'input.octo-range-unit' ),
					selectedUnit = container.find( 'select.octo-range-unit option:selected' ).val(),
					defaults     = control.params[ 'inputAttrsDefaults' ][ selectedUnit ];

				$.each( defaults, function( key, value ) {
					container.find( 'input' ).attr( key, value );
				} );

				inputNumber.trigger( 'input' );

			} );

			// Reset to default value
			this.container.on( 'click', 'button.octo-reset-button', function() {

				var _this        = $( this ),
					selector     = ( control.params[ 'responsive' ] ) ? '.octo-controls-wrapper.active' : '.octo-controls-wrapper',
					container    = _this.parents( '.customize-control-octo-range' ).find( selector ),
					inputNumber  = container.find( 'input[type=number]' ),
					selectUnit   = container.find( 'select.octo-range-unit' ),
					defaultUnit  = selectUnit.data( 'default' ),
					defaultValue = container.find( 'input.octo-range-slider' ).data( 'default' ),
					optionsUnit  = container.find( 'select.octo-range-unit option' );

				optionsUnit.removeAttr( 'selected' );
				selectUnit.val( defaultUnit );
				inputNumber.val( defaultValue );
				selectUnit.trigger( 'change' );
				inputNumber.trigger( 'input' );

			} );

			// Save changes.
			this.container.on( 'input', '.octo-range-number, .octo-range-slider', function() {

				var _this       = $( this ),
					container   = _this.closest( '.octo-controls-wrapper' ),
					inputNumber = container.find( 'input.octo-range-number' ),
					inputUnit   = container.find( 'input.octo-range-unit' ),
					selectUnit  = container.find( 'select.octo-range-unit option:selected' ),
					device      = inputNumber.data( 'device' ),
					setting     = control.settings[device];
					//value       = {};

				// Determine, if we have a single value or an value and unit array.
				if ( 0 === inputUnit.length && 0 === selectUnit.length ) {
					var value;
					value = inputNumber.val();
				} else {
					var value      = {};
					value['value'] = inputNumber.val();

					if ( 0 < selectUnit.length ) {
						value['unit'] = selectUnit.val();
					} else {
						value['unit'] = inputUnit.val();
					}
				}			

				setting.set( value );

			} );
		}
	} );
} )( jQuery );
