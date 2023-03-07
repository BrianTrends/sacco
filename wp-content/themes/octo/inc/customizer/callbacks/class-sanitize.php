<?php
/**
 * Sanitize class
 *
 * @package octo
 * @since   1.0.0
 */

namespace octo\customizer\callbacks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class provides sanitize callbacks for theme customizer controls.
 *
 * @since 1.0.0
 */
class Sanitize {

	/**
	 * Sanitize select and radio.
	 *
	 * @param Array  $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function choices( $value, $setting ) {

		// Get list of choices from the control associated with the setting.	
		$choices = $setting->manager->get_control( $setting->id )->choices;

		if ( array_key_exists( $value, $choices ) ) {
			return $value;
		} else {
			return $setting->default;
		}

	}

	/**
	 * Sanitize range.
	 *
	 * @param Mixed  $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function int_string( $value, $setting ) {

		if ( is_array( $value ) ) {
			foreach ( $value as $key => $data ) {
				
				if ( 'unit' === $key ) {
					if ( '' !== $data && ! preg_match( '/px|em|rem|%|vw|vh/', $data ) ) {
						$value = $setting->default;
					}
				} else {
					if ( ! is_numeric( $data ) && '' !== $data ) {
						$value = $setting->default;
					}
				}
			}
			
			return $value;
			
		}
		
	}

	/**
	 * Sanitize color.
	 *
	 * @param String $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function color( $value, $setting ) {
		
		$type = substr( $value, 0, 1 );
		
		if ( '#' === $type || '' === $type ) {
			// Now we know, it´s a hex color code.
			if ( preg_match( '/#([a-f0-9]{3}){1,2}/', $value ) || empty( $value ) ) {
				return $value;
			} else {
				return $setting->default;
			}			
		} else {
			// Now we know, it´s a rgba color code.
			$color = str_replace( ' ', '', $value );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
			
		}

	}

	/**
	 * Sanitize checkbox.
	 *
	 * @param Boolean $value   Customizer saved value.
	 * @param Object  $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function checkbox( $value, $setting ) {

		if ( is_bool( $value ) ) {
			return $value;
		} else {
			return $setting->default;
		}

	}

	/**
	 * Sanitize float.
	 *
	 * @param String $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function float( $value, $setting ) {
		
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $data ) {
				
				if ( 'unit' === $key ) {
					if ( '' !== $data && ! preg_match( '/px|em|rem|%|vw|vh/', $data ) ) {
						$value = $setting->default;
					}
				} else {
					if ( '' !== $data && ! preg_match( '/^[0-9.]+$/i', $data ) ) {
						$value = $setting->default;
					}
				}
			}			
		} else {
			if ( '' !== $value && ! preg_match( '/^[0-9.]+$/i', $value ) ) {
				$value = $setting->default;
			}
		}
		
		return $value;

	}

	/**
	 * Sanitize sortable.
	 *
	 * @param Array  $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function sortable( $value, $setting ) {

		if ( is_array( $value ) ) {

			// Get list of choices from the control associated with the setting.
			$choices = $setting->manager->get_control( $setting->id )->choices;

			foreach ( $value as $key ) {
				if ( ! array_key_exists( $key, $choices ) ) {
					return $setting->default;
				}
			}
		}

		return $value;

	}

	/**
	 * Sanitize typography.
	 *
	 * @param String $value   Customizer saved value.
	 * @param Object $setting Customizer setting object.
	 * @since 1.0.0
	 */
	public static function typography( $value, $setting ) {

		if ( preg_match( '/^[a-zA-Z0-9\s]*$/', $value ) ) {
			return $value;
		} else {
			return $setting->default;
		}

	}

}
