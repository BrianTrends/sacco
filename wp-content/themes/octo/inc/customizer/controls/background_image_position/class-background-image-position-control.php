<?php
/**
 * Background_Control class.
 *
 * @package octo
 * @since   1.1.0
 */

namespace octo\customizer\controls\background_image_position;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

/**
 * This class creates a jQuery background image position control.
 * It can be used to position a background image.
 *
 * @since 1.1.0
 */
class Background_Image_Position_Control extends WP_Customize_Control {
	
	/**
     * Type.
     *
     * @var String
     */
    public $type = 'octo-background-image-position';
		
	/**
	 * Control group.
	 *
	 * @var String
	 */
	public $group = '';
	
	/**
     * Enqueue scripts/styles for the padding input.
     *
     * @since 1.0.0
     */
    public function enqueue() {
       wp_enqueue_script( 'octo-background-image-position-control', get_template_directory_uri() . '/inc/customizer/controls/background_image_position/background-image-position-control.js', array( 'jquery', 'customize-base' ), OCTO_VERSION, true );
       wp_enqueue_style( 'octo-background-image-position-control', get_template_directory_uri() . '/inc/customizer/controls/background_image_position/background-image-position-control.css', array(), OCTO_VERSION, 'all' );     
    }
	
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.0.0
	 * @uses  WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		
		$this->json['group'] = $this->group;

	}	
 
    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     *
     * @since 1.0.0
     */
    public function render_content() {}
 
    /**
     * Render a JS template for the content of the color picker control.
     *
     * @since 1.0.0
     */
    public function content_template() {
	
		$options = array(
            array(
                'left top'   => array(
                    'label' => __( 'Top Left', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-left-alt',
                ),
                'center top' => array(
                    'label' => __( 'Top', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-up-alt',
                ),
                'right top'  => array(
                    'label' => __( 'Top Right', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-right-alt',
                ),
            ),
            array(
                'left center'   => array(
                    'label' => __( 'Left', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-left-alt',
                ),
                'center center' => array(
                    'label' => __( 'Center', 'octo' ),
                    'icon'  => 'background-position-center-icon',
                ),
                'right center'  => array(
                    'label' => __( 'Right', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-right-alt',
                ),
            ),
            array(
                'left bottom'   => array(
                    'label' => __( 'Bottom Left', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-left-alt',
                ),
                'center bottom' => array(
                    'label' => __( 'Bottom', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-down-alt',
                ),
                'right bottom'  => array(
                    'label' => __( 'Bottom Right', 'octo' ),
                    'icon'  => 'dashicons dashicons-arrow-right-alt',
                ),
            ),
        );
        ?>
        <# if ( data.label ) { #>
            <span class="customize-control-title">{{{ data.label }}}</span>
        <# } #>
        <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>
        <div class="customize-control-content octo-background-wrapper">			
			<div class="background-position-control">
				<?php foreach ( $options as $group ) : ?>
				<div class="button-group">
				<?php foreach ( $group as $value => $input ) : ?>
					<label>
						<input class="ui-helper-hidden-accessible" name="background-position" type="radio" value="<?php echo esc_attr( $value ); ?>">
						<span class="display-options position"><span class="<?php echo esc_attr( $input['icon'] ); ?>" aria-hidden="true"></span></span>
					</label>
				<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			</div>			
        </div>
        <?php
    }

}
