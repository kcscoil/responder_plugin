<?php
/*
   Plugin Name: Responder
   Plugin URI: http://wordpress.org/extend/plugins/responder/
   Version: 0.1
   Author: Tomer Shaked
   Description: Intergration between Rav-Messer to Wordpress
   Text Domain: responder
   License: GPLv3
  */

/*
    "WordPress Plugin Template" Copyright (C) 2016 Michael Simpson  (email : michael.d.simpson@gmail.com)

    This following part of this file is part of WordPress Plugin Template for WordPress.

    WordPress Plugin Template is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    WordPress Plugin Template is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Contact Form to Database Extension.
    If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

$Responder_minimalRequiredPhpVersion = '5.0';
function res_activate(){
    global $wpdb;

        $table_name = $wpdb->prefix . 'res_forms';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          html LONGTEXT,
          UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
}
  register_activation_hook( __FILE__, 'res_activate' );
/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function Responder_noticePhpVersionWrong() {
    global $Responder_minimalRequiredPhpVersion;
    echo '<div class="updated fade">' .
      __('Error: plugin "Responder" requires a newer version of PHP to be running.',  'responder').
            '<br/>' . __('Minimal version of PHP required: ', 'responder') . '<strong>' . $Responder_minimalRequiredPhpVersion . '</strong>' .
            '<br/>' . __('Your server\'s PHP version: ', 'responder') . '<strong>' . phpversion() . '</strong>' .
         '</div>';
}
    function auth_admin_notice__error() {
        $class = 'notice notice-error';
        $message = __( 'Error! Invalid User Key and/or User Sercret.', 'auth-text-domain' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
    }function empty_admin_notice__error() {
        $class = 'notice notice-error';
        $message = __( 'Error! User Key and User Sercret must be filled.', 'auth-text-domain' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
    }function auth_admin_notice__success() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Connected to Rav-Messer!', 'auth-text-domain' ); ?></p>
    </div>
    <?php
    }


function Responder_PhpVersionCheck() {
    global $Responder_minimalRequiredPhpVersion;
    if (version_compare(phpversion(), $Responder_minimalRequiredPhpVersion) < 0) {
        add_action('admin_notices', 'Responder_noticePhpVersionWrong');
        return false;
    }
    return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function Responder_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('responder', false, $pluginDir . '/languages/');
}


//////////////////////////////////
// Run initialization
/////////////////////////////////

// Initialize i18n
add_action('plugins_loadedi','Responder_i18n_init');

// Run the version check.
// If it is successful, continue with initialization for this plugin
if (Responder_PhpVersionCheck()) {
    // Only load and run the init function if we know PHP version can parse it
    include_once('responder_init.php');
    Responder_init(__FILE__);
}

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('Rav Messer Form', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'based on Responder plugin', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$form = apply_filters( 'widget_title', $instance['form'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo __( 'Hello, World!', 'wpb_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
    
if ( isset( $instance[ 'form' ] ) ) {
$form = $instance[ 'form' ];
}
else {
$form = __( 'Select a form', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'form' ); ?>"><?php _e( 'Form:' ); ?></label> 
    <select class="widefat" id="<?php echo $this->get_field_id( 'form' ); ?>" name="<?php echo $this->get_field_name( 'form' ); ?>"  >
        <?php 
    global $wpdb;
    $sql = 'SELECT id FROM `wp_res_forms`';
    $forms = $wpdb->get_results($sql);
        foreach($forms as $form){ ?>
        <option value="<?php echo esc_attr( $form->id ); ?>" /><?php echo esc_attr( $form->id ); ?></option>
        <?php } ?> 
    </select>
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['form'] = ( ! empty( $new_instance['form'] ) ) ? strip_tags( $new_instance['form'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );


add_action( 'wp_dashboard_setup', 'register_rav_messer_statistics' );
function register_rav_messer_statistics() {
	wp_add_dashboard_widget(
		'rav_messer_statistics',
		'Rav Messer Statistics',
		'rav_messer_statistics_display'
	);

}

function rav_messer_statistics_display() {
    
   /* $auth = 3;
    
    if($auth == 1){ echo "<div style='text-align: center; direction: ltr;' >Username/password required to intergrate Rav-Messer. Plese login <a href='http://www.kcs.co.il/wp-admin/plugins.php?page=Responder_PluginSettings#plugin_config-2'>here</a>.</div>"; } elseif($auth == 2){ }elseif($auth == 3){?>
    <div style="text-align: center; direction: ltr;">
        <p><?php echo date('M d ,Y');?></p>
        <p>Happy <?php echo date('l!');?></p>
        <br>
        <h3 style="font-weight:bold; color:green; font-size:300%;">1,954</h3>
        <h3 style="font-weight:bold; ">Emails sent today</h4><br>
        <div><div style="width: 50%;display:inline-block;border-top: 1px solid gray;border-right: 1px solid gray;margin-right: -1px;"><p style="color:green;">37,293</p><p>this week</p></div><div style="width:50%;display:inline-block;border-top: 1px solid gray;"><p style="color:green;">152,459</p><p>this month</p></div></div>
        <div><div style="width:50%;display:inline-block;border-right: 1px solid gray;margin-right: -1px;border-top: 1px solid gray;"><p style="color:green;">146,654</p><p>last month</p></div><div style="width:50%;display:inline-block;border-top: 1px solid gray;"><p style="color:green;">1,236,544</p><p>this year</p></div></div>
</div>
<?php } */
    echo "Coming Soon...";
}


// Add Shortcode
function responder_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'id' => '0',
		),
		$atts,
		'responder'
	);
    
    global $wpdb;
    $sql = 'SELECT html FROM `wp_res_forms` WHERE `id` LIKE '.$atts['id'];
    $output = $wpdb->get_results($sql)[0];
	return( $output->html);

}
add_shortcode( 'responder', 'responder_shortcode' );

     
