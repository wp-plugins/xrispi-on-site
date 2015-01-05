<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Installs xrispi on-site in your word press
 * Version: 1.4
 * Author: Xrispi Labs LTD.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$guid = get_option( 'xrispi_onsite_publisher_guid', false );
	$output = "<script>\n";
	if($guid) {
		$output .= "var XrispiOptions = {publisher:'".$guid."'};\n";
	}
	$output .= "(function(w,d,t,s){var a=d.createElement(t),m=d.getElementsByTagName(t)[0]; a.async=1; a.src=s;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//s.xrispi.com/static/xriscript/xriscript.nocache.js');\n</script>\n";
	echo $output;
}

function xrispi_onsite_admin_menu() {
	add_options_page( 'Xrispi Settings', 'Xrispi', 'manage_options', 'xrispi_onsite', 'xrispi_onsite_settings');

	add_settings_section(
		'xrispi_onsite_setting_section',
		'Xrisp Publishing',
		'xrispi_onsite_setting_section_callback_function',
		'xrispi_onsite'
	);
	
	add_settings_field(
		'xrispi_onsite_publisher_guid',
		'Publishing folder',
		'xrispi_onsite_setting_callback_function',
		'xrispi_onsite',
		'xrispi_onsite_setting_section'
	);	
}

function xrispi_onsite_admin_init() {
	register_setting( 'xrispi_onsite', 'xrispi_onsite_publisher_guid', 'sanitize_xrispi_onsite_publisher_guid' );
}

function sanitize_xrispi_onsite_publisher_guid($value) {
	if(!preg_match('/^\s*([a-zA-Z0-9]{36})\s*$/', $value, $matches)) {
		return '';
	}
	return $matches[1];
}

function xrispi_onsite_setting_section_callback_function() {
?>
<p>
In this section, you are able to link your Xrispi account directly to your website, allowing all website visitors to see and engage with each xrisp you publish.<br />
<a href="https://xrispi.com/publisher/" target="_blank">Show Me My Publishing Folders</a>
</p>
<?php
}

function xrispi_onsite_setting_callback_function() {
	$setting = esc_attr( get_option( 'xrispi_onsite_publisher_guid' ) );
	echo "<input type='text' name='xrispi_onsite_publisher_guid' size='46' value='$setting' />";
}

function xrispi_onsite_settings() {
    //if (!current_user_can('manage_options')) {
    //    wp_die('You do not have sufficient permissions to access this page.');
    //}

	?>
<div class="wrap">
<h2>Xrispi Settings</h2>
<form method="post" action="options.php"> 
<?php 
settings_fields( 'xrispi_onsite' );
do_settings_sections( 'xrispi_onsite' );
submit_button();
 ?>
 </form>
 </div>

	<?php
    
}


function xrispi_onsite_plugin_action_links($links, $file) {
	static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=xrispi_onsite">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}


add_filter('plugin_action_links', 'xrispi_onsite_plugin_action_links', 10, 2);
add_action( 'admin_init', 'xrispi_onsite_admin_init' );
add_action( 'admin_menu', 'xrispi_onsite_admin_menu' );
add_action( 'wp_head', 'xrispi_onsite_wp_head_action');