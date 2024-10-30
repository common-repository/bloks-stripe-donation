<?php
/**
 * Handler widget list
 *
 * @package     Bloks_Stripe
 * @subpackage  Classes/Widget
 * @copyright   Copyright (c) 2017, Bloks
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Bloks_Stripe_Widget extends WP_Widget {

    /**
     * Plugin Database
     * @access private
     **/
    private $db = null;

    // Set up the widget name and description.
    public function __construct() {
        $widget_options = array( 'classname' => 'blope_stripe_widget', 'description' => 'The list donation buttons to select.' );
        parent::__construct( 'blope_stripe_widget', 'Donation Button', $widget_options );
        $this->db = new Bloks_Stripe_Database();
    }


    // Create the widget output.
    public function widget( $args, $instance ) {
        // PART 1: Extracting the arguments + getting the values
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $button = empty($instance['button']) ? '' : $instance['button'];
        $shortCode = '[bloks_button id="'. $button .'"]';

        // Before widget code, if any
        echo (isset($before_widget)?$before_widget:'');

        // PART 2: The title and the text output
        if (!empty($title))
            echo $before_title . $title . $after_title;;
        if (!empty($button) && shortcode_exists('bloks_button'))
            echo do_shortcode($shortCode);

        // After widget code, if any
        echo (isset($after_widget)?$after_widget:'');

    }


    // Create the admin area widget settings form.
    public function form( $instance ) {
        // Extract the data from the instance variable
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'button' => '') );
        $title = $instance['title'];
        $button = $instance['button'];

        $list_buttons = $this->db->getListButtons();

        // Display the fields
        ?>
        <!--  Widget Title field START -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <!-- Widget Title field END -->

        <!-- Widget Button field START -->
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">Select Donation Button:
                <select class='widefat' id="<?php echo $this->get_field_id('button'); ?>"
                        name="<?php echo $this->get_field_name('button'); ?>" type="text">
                <?php foreach ($list_buttons as $btn) : ?>
                    <option value='<?php echo $btn->button_id; ?>' <?php echo ($btn->button_id ==$button)?'selected':''; ?>>
                        <?php echo $btn->button_title; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </label>
        </p>
        <!-- Widget Button field END -->
        <?php
    }


    // Apply settings to the widget instance.
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'button' ] = $new_instance[ 'button' ];
        return $instance;
    }

}


