<?php
/**
 * Plugin Name: Xrispi On-Site
 * Plugin URI: https://xrispi.com/
 * Description: Xrispi is a concise content sharing platform, made to promote online articles, boost site traffic and increase reader engagement for online publishers
 * Version: 1.6
 * Author: Xrispi Labs Ltd.
 * Author URI: https://xrispi.com
 * License: GPL2
 */

function xrispi_onsite_wp_head_action() {
	$guid = get_option( 'xrispi_onsite_publisher_guid', false );
	$output = "<script>\n";
	
	$output .= "(function(w,d,t,s){var a=d.createElement(t),m=d.getElementsByTagName(t)[0]; a.async=1; a.src=s;m.parentNode.insertBefore(a,m);";
	$output .= "a.setAttribute('data-xrispi', '{\"platform\":\"wp\",\"v\":\"1.6\"}');";
	if($guid) {
		$output .= "})(window,document,'script', '//s.xrispi.com/publishers/".$guid.".nocache.js');";
	} else {
		$output .= "})(window,document,'script', '//s.xrispi.com/static/xriscript/xriscript.nocache.js');";
	}
	
	$output .= "\n</script>\n";
	echo $output;
}

function xrispi_onsite_admin_menu() {
	add_options_page( 'Xrispi Settings', 'Xrispi', 'manage_options', 'xrispi_onsite', 'xrispi_onsite_settings');

	add_settings_section(
		'xrispi_onsite_setting_section',
		'',
		'xrispi_onsite_setting_section_callback_function',
		'xrispi_onsite'
	);
	
	add_settings_field(
		'xrispi_onsite_publisher_guid',
		'Publishing folder ID',
		'xrispi_onsite_setting_guid_callback_function',
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
<strong>Boosting site traffic by Xrisp Publishing</strong>
</p><p>
As a website owner, you can get special permissions for promoting your articles. Once you select an article, you can then highlight sentences you would like to emphasize within the text and click on the “Share” button, then the highlighted text (named as “Xrisps”) will immediately become visible and sharable for any user browsing your site. On top of that, your site readers receive push notifications in their browsers as soon as your Xrisps are published, featuring a link to this specific article with a focus on your highlighted text.
</p><p>
Enabling Xrisp Publishing: <br />
In case you have not done it yet, first fill in <a href="https://xrispi.com/##xrispiOnSite" target="_blank">this form</a> and you will receive an email with simple installation instructions. After completion of these quick steps a special account for publishing online Xrisps will be automatically created for your URL.
</p><p>
Note: published Xrisps are saved under unique <a href="https://xrispi.com/publishers/" target="_blank">Publishing Folders</a>. As a website owner, you can choose to “Add Editors” to your folder, so that your article editors will be able to promote articles by publishing Xrisps on your site by themselves.
</p><p>
<a href="https://xrispi.com/help/how_to_publish/" target="_blank">How to publish a new Xrisp?</a>
</p>

<!--
<p>
Control how Xrispi will behave on your site.<br />
<a href="https://xrispi.com/publisher/" target="_blank">Publishing Folders</a> | <a href="https://xrispi.com/newpublisher/<?php echo urlencode(parse_url(get_site_url())['host']) ?>" target="_blank">Create Publishing Folder</a>
</p>
-->
<?php
}

function xrispi_onsite_setting_guid_callback_function() {
	$setting = esc_attr( get_option( 'xrispi_onsite_publisher_guid' ) );
	?>
	<input type="text" name="xrispi_onsite_publisher_guid" id="xrispi_onsite_publisher_guid" size="46" value="<?php echo $setting?>" />&nbsp;<a id="editorsLink" style="display:none;" target="_blank">Settings</a>
<script>
(function() {
	var input = document.getElementById('xrispi_onsite_publisher_guid');
	var anchor= document.getElementById('editorsLink');
	
	function updateLink() {
		if(input.value && input.value.length == 36) {
			anchor.style.display = '';
			anchor.setAttribute('href', 'https://xrispi.com/publishers/' + input.value + '/info/');
		} else {
			anchor.style.display = 'none';
		}
	}
	updateLink();
	anchor.addEventListener('change', updateLink);
	
})();

</script>
	<?php
	echo "";
}

function xrispi_onsite_settings() {
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