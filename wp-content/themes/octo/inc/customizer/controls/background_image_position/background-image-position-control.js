/**
 * File sortalbe-control.js
 *
 * Handles sortable control
 *
 * @package octo
 * @since 1.0.0
 */

( function( $ ) {

	wp.customize.controlConstructor['octo-background-image-position'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';

			var control = this, updateRadios;

			control.container.on( 'change', 'input[name="background-position"]', function() {
				var position = $( this ).val();
				control.setting( position );
			} );
			
			updateRadios = _.debounce( function() {
				var x, y, radioInput, inputValue;
				inputValue = control.setting.get();
				radioInput = control.container.find( 'input[name="background-position"][value="' + inputValue + '"]' );
				radioInput.trigger( 'click' );
			} );
			control.setting.bind( updateRadios );

			updateRadios(); // Set initial UI.
		},

	} );
} )( jQuery );
