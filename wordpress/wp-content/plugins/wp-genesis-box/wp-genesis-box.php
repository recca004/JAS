<?php
/*
Plugin Name: WP Genesis Box
Plugin URI: http://www.jimmyscode.com/wordpress/wp-genesis-box/
Description: Display the Genesis framework affiliate box on your WordPress website. Make money as a Studiopress affiliate.
Version: 0.1.3
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/
// plugin constants
define('WPGB_VERSION', '0.1.3');
define('WPGB_PLUGIN_NAME', 'WP Genesis Box');
define('WPGB_SLUG', 'wp-genesis-box');
define('WPGB_OPTION', 'wp_genesis_box');
define('WPGB_LOCAL', 'wp_genesis_box');
/* defaults */
define('WPGB_DEFAULT_ENABLED', true);
define('WPGB_DEFAULT_URL', '');
define('WPGB_ROUNDED', false);
define('WPGB_NOFOLLOW', true);
define('WPGB_AVAILABLE_IMAGES', 'genesis_framework_logo1,genesis_framework_logo2,genesis_framework_logo3,genesis_framework_logo4,genesis_framework_logo5,genesis_framework_logo6,genesis_framework_logo7,genesis_framework_logo8,genesis_framework_logo9,genesis_framework_logo10,genesis_framework_logo11,genesis_framework_logo12,genesis_framework_logo13,genesis_framework_logo14,genesis_framework_logo15,genesis_framework_logo16,genesis_framework_logo17,genesis_framework_logo18,genesis_framework_logo19');
define('WPGB_DEFAULT_IMAGE', '');
define('WPGB_DEFAULT_AUTO_INSERT', false);
define('WPGB_DEFAULT_SHOW', false);
define('WPGB_DEFAULT_NEWWINDOW', false);
/* default option names */
define('WPGB_DEFAULT_ENABLED_NAME', 'enabled');
define('WPGB_DEFAULT_URL_NAME', 'affurl');
define('WPGB_DEFAULT_ROUNDED_NAME', 'rounded');
define('WPGB_DEFAULT_NOFOLLOW_NAME', 'nofollow');
define('WPGB_DEFAULT_IMAGE_NAME', 'img');
define('WPGB_DEFAULT_AUTO_INSERT_NAME', 'autoinsert');
define('WPGB_DEFAULT_SHOW_NAME', 'show');
define('WPGB_DEFAULT_NEWWINDOW_NAME', 'opennewwindow');

// oh no you don't
if (!defined('ABSPATH')) {
  wp_die(__('Do not access this file directly.', WPGB_LOCAL));
}

// delete option when plugin is uninstalled
register_uninstall_hook(__FILE__, 'uninstall_wpgb_plugin');
function uninstall_wpgb_plugin() {
  delete_option(WPGB_OPTION);
}

// localization to allow for translations
add_action('init', 'wp_genesis_box_translation_file');
function wp_genesis_box_translation_file() {
  $plugin_path = plugin_basename(dirname(__FILE__)) . '/translations';
  load_plugin_textdomain(WPGB_LOCAL, '', $plugin_path);
  register_wp_genesis_box_style();
}
// tell WP that we are going to use new options
add_action('admin_init', 'wp_genesis_box_options_init');
function wp_genesis_box_options_init() {
  register_setting('wp_genesis_box_options', WPGB_OPTION, 'wpgb_validation');
  register_wpgb_admin_style();
	register_wpgb_admin_script();
}
// validation function
function wpgb_validation($input) {
  // sanitize url
  $input[WPGB_DEFAULT_URL_NAME] = esc_url($input[WPGB_DEFAULT_URL_NAME]);
  // sanitize image
  $input[WPGB_DEFAULT_IMAGE_NAME] = sanitize_text_field($input[WPGB_DEFAULT_IMAGE_NAME]);
  if (!$input[WPGB_DEFAULT_IMAGE_NAME]) { // set to default
    $input[WPGB_DEFAULT_IMAGE_NAME] = WPGB_DEFAULT_IMAGE;
  }
  return $input;
}
// add Settings sub-menu
add_action('admin_menu', 'wpgb_plugin_menu');
function wpgb_plugin_menu() {
  add_options_page(WPGB_PLUGIN_NAME, WPGB_PLUGIN_NAME, 'manage_options', WPGB_SLUG, 'wp_genesis_box_page');
}
// plugin settings page
// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
function wp_genesis_box_page() {
  // check perms
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permission to access this page', WPGB_LOCAL));
  }
?>
  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php echo WPGB_PLUGIN_NAME; ?></h2>
    <form method="post" action="options.php">
      <div>You are running plugin version <strong><?php echo WPGB_VERSION; ?></strong>.</div>
      <?php settings_fields('wp_genesis_box_options'); ?>
      <?php $options = wpgb_getpluginoptions(); ?>
	<?php /* update_option(WPGB_OPTION, $options); */ ?>
      <table class="form-table" id="theme-options-wrap">
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', WPGB_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="wp_genesis_box[<?php echo WPGB_DEFAULT_ENABLED_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', $options[WPGB_DEFAULT_ENABLED_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter your affiliate URL here. This will be inserted wherever you use the shortcode.', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_URL_NAME; ?>]"><?php _e('Your Affiliate URL', WPGB_LOCAL); ?></label></strong></th>
          <td><input type="url" id="wp_genesis_box[<?php echo WPGB_DEFAULT_URL_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_URL_NAME; ?>]" value="<?php echo $options[WPGB_DEFAULT_URL_NAME]; ?>" /></td>
        </tr>
        <tr valign="top"><td colspan="2"><?php _e('Enter your affiliate URL here. This will be inserted wherever you use the shortcode.', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Do you want to apply rounded corners CSS to the output?', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_ROUNDED_NAME; ?>]"><?php _e('Rounded corners CSS?', WPGB_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="wp_genesis_box[<?php echo WPGB_DEFAULT_ROUNDED_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_ROUNDED_NAME; ?>]" value="1" <?php checked('1', $options[WPGB_DEFAULT_ROUNDED_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Do you want to apply rounded corners CSS to the output?', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Check this box to automatically insert the output at the end of blog posts. If you do not do this then you will need to manually insert shortcode or call the function in PHP.', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_AUTO_INSERT_NAME; ?>]"><?php _e('Auto insert Genesis box at the end of posts?', WPGB_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="wp_genesis_box[<?php echo WPGB_DEFAULT_AUTO_INSERT_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_AUTO_INSERT_NAME; ?>]" value="1" <?php checked('1', $options[WPGB_DEFAULT_AUTO_INSERT_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Check this box to automatically insert the output at the end of blog posts. If you don\'t do this then you will need to manually insert shortcode or call the function in PHP.', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Do you want to add rel=nofollow to all links?', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_NOFOLLOW_NAME; ?>]"><?php _e('Nofollow links?', WPGB_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="wp_genesis_box[<?php echo WPGB_DEFAULT_NOFOLLOW_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_NOFOLLOW_NAME; ?>]" value="1" <?php checked('1', $options[WPGB_DEFAULT_NOFOLLOW_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Do you want to add rel="nofollow" to all links?', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Check this box to open links in a new window.', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_NEWWINDOW_NAME; ?>]"><?php _e('Open links in new window?', WPGB_LOCAL); ?></label></strong></th>
		<td><input type="checkbox" id="wp_genesis_box[<?php echo WPGB_DEFAULT_NEWWINDOW_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_NEWWINDOW_NAME; ?>]" value="1" <?php checked('1', $options[WPGB_DEFAULT_NEWWINDOW_NAME]); ?> /></td>
        </tr>
	  <tr valign="top"><td colspan="2"><?php _e('Check this box to open links in a new window.', WPGB_LOCAL); ?></td></tr>
        <tr valign="top"><th scope="row"><strong><label title="<?php _e('Select the default image.', WPGB_LOCAL); ?>" for="wp_genesis_box[<?php echo WPGB_DEFAULT_IMAGE_NAME; ?>]"><?php _e('Default image', WPGB_LOCAL); ?></label></strong></th>
		<td><select id="wp_genesis_box[<?php echo WPGB_DEFAULT_IMAGE_NAME; ?>]" name="wp_genesis_box[<?php echo WPGB_DEFAULT_IMAGE_NAME; ?>]" onChange="picture.src=this.options[this.selectedIndex].getAttribute('data-whichPicture');">
                <?php $images = explode(",", WPGB_AVAILABLE_IMAGES);
                      for($i=0, $imagecount=count($images); $i < $imagecount; $i++) {
                        $imageurl = plugins_url(plugin_basename(dirname(__FILE__) . '/images/' . $images[$i] . '.png'));
                        if ($images[$i] === $options[WPGB_DEFAULT_IMAGE_NAME]) { $selectedimage = $imageurl; }
                        echo '<option data-whichPicture="' . $imageurl . '" value="' . $images[$i] . '" ' . selected($images[$i], $options[WPGB_DEFAULT_IMAGE_NAME]) . '>' . $images[$i] . '</option>';
                      } ?>
            </select></td></tr>
        <tr><td colspan="2"><img src="<?php if (!$selectedimage) { echo plugins_url(plugin_basename(dirname(__FILE__) . '/images/' . WPGB_DEFAULT_IMAGE . '.png')); } else { echo $selectedimage; } ?>" id="picture" /></td></tr>
	  <tr valign="top"><td colspan="2"><?php _e('Select the default image.', WPGB_LOCAL); ?></td></tr>
      </table>
      <?php submit_button(); ?>
    </form>
    <h3>Plugin Arguments and Defaults</h3>
    <table class="widefat">
      <thead>
        <tr>
          <th title="<?php _e('The name of the parameter', WPGB_LOCAL); ?>"><?php _e('Argument', WPGB_LOCAL); ?></th>
	  <th title="<?php _e('Is this parameter required?', WPGB_LOCAL); ?>"><?php _e('Required?', WPGB_LOCAL); ?></th>
          <th title="<?php _e('What data type this parameter accepts', WPGB_LOCAL); ?>"><?php _e('Type', WPGB_LOCAL); ?></th>
          <th title="<?php _e('What, if any, is the default if no value is specified', WPGB_LOCAL); ?>"><?php _e('Default Value', WPGB_LOCAL); ?></th>
        </tr>
      </thead>
      <tbody>
    <?php $plugin_defaults_keys = array_keys(wpgb_shortcode_defaults());
					$plugin_defaults_values = array_values(wpgb_shortcode_defaults());
					$wpgb_required = wpgb_required_parameters();
					for($i=0; $i<count($plugin_defaults_keys);$i++) { ?>
        <tr>
          <td><?php echo $plugin_defaults_keys[$i]; ?></td>
					<td><?php echo $wpgb_required[$i]; ?></td>
          <td><?php echo gettype($plugin_defaults_values[$i]); ?></td>
          <td><?php 
						if ($plugin_defaults_values[$i] === true) {
							echo 'true';
						} elseif ($plugin_defaults_values[$i] === false) {
							echo 'false';
						} elseif ($plugin_defaults_values[$i] === '') {
							echo '<em>(this value is blank by default)</em>';
						} else {
							echo $plugin_defaults_values[$i];
						} ?></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
    <?php screen_icon('edit-comments'); ?>
    <h3>Support</h3>
	<div class="support">
	<?php echo '<a href="http://wordpress.org/extend/plugins/' . WPGB_SLUG . '/">' . __('Documentation', WPGB_LOCAL) . '</a> | ';
        echo '<a href="http://wordpress.org/plugins/' . WPGB_SLUG . '/faq/">' . __('FAQ', WPGB_LOCAL) . '</a><br />';
			?>
      If you like this plugin, please <a href="http://wordpress.org/support/view/plugin-reviews/<?php echo WPGB_SLUG; ?>/">rate it on WordPress.org</a> and click the "Works" button so others know it will work for your WordPress version. For support please visit the <a href="http://wordpress.org/support/plugin/<?php echo WPGB_SLUG; ?>">forums</a>. <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" title="Donate with PayPal" width="92" height="26" /></a>
    </div>
  </div>
  <?php 
}
// shortcode for posts and pages
add_shortcode('wp-genesis-box', 'genesis_aff_box');
// one function for shortcode and PHP
function genesis_aff_box($atts, $content = null) {
  // get parameters
  extract(shortcode_atts(wpgb_shortcode_defaults(), $atts));
  // plugin is enabled/disabled from settings page only
  $options = wpgb_getpluginoptions();
  $enabled = $options[WPGB_DEFAULT_ENABLED_NAME];

  // ******************************
  // derive shortcode values from constants
  // ******************************
  $temp_url = constant('WPGB_DEFAULT_URL_NAME');
  $affiliate_url = $$temp_url;
  $temp_nofollow = constant('WPGB_DEFAULT_NOFOLLOW_NAME');
  $nofollow = $$temp_nofollow;
  $temp_window = constant('WPGB_DEFAULT_NEWWINDOW_NAME');
  $opennewwindow = $$temp_window;
  $temp_show = constant('WPGB_DEFAULT_SHOW_NAME');
  $show = $$temp_show;
  $temp_rounded = constant('WPGB_DEFAULT_ROUNDED_NAME');
  $rounded = $$temp_rounded;
  $temp_image = constant('WPGB_DEFAULT_IMAGE_NAME');
  $img = $$temp_image;

  // ******************************
  // sanitize user input
  // ******************************
  $affiliate_url = esc_url($affiliate_url);
  $rounded = (bool)$rounded;
  $nofollow = (bool)$nofollow;
  $opennewwindow = (bool)$opennewwindow;
  $show = (bool)$show;
  $img = sanitize_text_field($img);

  // ******************************
  // check for parameters, then settings, then defaults
  // ******************************
  if ($enabled) {
    // check for overridden parameters, if nonexistent then get from DB
    if ($affiliate_url === WPGB_DEFAULT_URL) { // no url passed to function, try settings page
      $affiliate_url = $options[WPGB_DEFAULT_URL_NAME];
      if (($affiliate_url === WPGB_DEFAULT_URL) || ($affiliate_url === false)) { // no url on settings page either
        $enabled = false;
      }
    }
    if ($rounded == WPGB_ROUNDED) {
      $rounded = $options[WPGB_DEFAULT_ROUNDED_NAME];
      if ($rounded === false) {
        $rounded = WPGB_ROUNDED;
      }
    }
    if ($nofollow == WPGB_NOFOLLOW) {
	$nofollow = $options[WPGB_DEFAULT_NOFOLLOW_NAME];
	if ($nofollow === false) {
	  $nofollow = WPGB_NOFOLLOW;
	}
    }
    if ($img == WPGB_DEFAULT_IMAGE) {
      $img = $options[WPGB_DEFAULT_IMAGE_NAME];
      if ($img === false) {
        $img = WPGB_DEFAULT_IMAGE;
      }
    }
    if ($opennewwindow == WPGB_DEFAULT_NEWWINDOW) {
      $opennewwindow = $options[WPGB_DEFAULT_NEWWINDOW_NAME];
      if ($opennewwindow === false) {
        $opennewwindow = WPGB_DEFAULT_NEWWINDOW;
      }
    }
  } // end enabled check

  // ******************************
  // do some actual work
  // ******************************
  if ($enabled) {
    // enqueue CSS only on pages with shortcode
    wp_genesis_box_styles();

    if ($content) {
      $text = wp_kses_post(force_balance_tags($content));
    } else {
      $text = '<p>' . __('Genesis empowers you to quickly and easily build incredible websites with WordPress.', WPGB_LOCAL);
      $text .= __('Whether you\'re a novice or advanced developer, Genesis provides the secure and search-engine-optimized foundation that takes WordPress to places you never thought it could go.', WPGB_LOCAL);
      $text .= __(' It\'s that simple', WPGB_LOCAL) . ' - <a' . ($opennewwindow ? ' onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;" ' : ' ') . ($nofollow ? ' rel="nofollow" ' : ' ') . 'href="' . $affiliate_url . '">' . __('start using Genesis now!', WPGB_LOCAL) . '</a></p>';
      $text .= '<p>' . __('Take advantage of the 6 default layout options, comprehensive SEO settings, rock-solid security, flexible theme options, cool custom widgets, custom design hooks, and a huge selection of child themes ("skins") that make your site look the way you want it to.', WPGB_LOCAL);
      $text .= __(' With automatic theme updates and world-class support included, Genesis is the smart choice for your WordPress website or blog.', WPGB_LOCAL) . '</p>';
    }

    // calculate image url
    $images = explode(",", WPGB_AVAILABLE_IMAGES);
    if (!in_array($img, $images)) {
      $img = $images[$options[WPGB_DEFAULT_IMAGE_NAME]];
      if (!$img) { $img = WPGB_DEFAULT_IMAGE; }
    }
    $imageurl = plugins_url(plugin_basename(dirname(__FILE__) . '/images/' . $img . '.png'));
    $imagedata = getimagesize($imageurl);
    $output = '<div id="genesis-box"' . ($rounded ? ' class="wpgb-rounded-corners"' : '') . '>';
    $output .= '<h3>' . __('This website runs on the Genesis framework', WPGB_LOCAL) . '</h3>';
    $output .= '<a' . ($opennewwindow ? ' onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;" ' : ' ') . ($nofollow ? ' rel="nofollow" ' : ' ') . 'href="' . $affiliate_url . '">';
    $output .= '<img class="alignright" src="' . $imageurl . '" alt="' . __('Genesis Framework', WPGB_LOCAL) . '" title="' . __('Genesis Framework', WPGB_LOCAL) . '" width="' . $imagedata[0] . '" height="' . $imagedata[1] . '" /></a>';
    $output .= do_shortcode($text) . '</div>';
  } else { // plugin disabled
    $output = '<!-- ' . WPGB_PLUGIN_NAME . ': plugin is disabled. Either you did not pass a necessary setting to the plugin, or did not configure a default. Check Settings page. -->';
  }
  if ($enabled) {
    if ($show) {
      echo $output;
    } else {
      return $output;
    }
  }
} // end shortcode function
// auto insert at end of posts?
add_action('the_content', 'wpgb_insert_genesis_box');
function wpgb_insert_genesis_box($content) {
  if (is_single()) {
    $options = wpgb_getpluginoptions();
    if ($options[WPGB_DEFAULT_AUTO_INSERT_NAME]) {
      $content .= genesis_aff_box($options);
    }
  }
  return $content;
}
// show admin messages to plugin user
add_action('admin_notices', 'wpgb_showAdminMessages');
function wpgb_showAdminMessages() {
  // http://wptheming.com/2011/08/admin-notices-in-wordpress/
  global $pagenow;
  if (current_user_can('manage_options')) { // user has privilege
    if ($pagenow == 'options-general.php') {
			if ($_GET['page'] == WPGB_SLUG) { // on WP Genesis Box settings page
        $options = wpgb_getpluginoptions();
				if ($options != false) {
					$enabled = $options[WPGB_DEFAULT_ENABLED_NAME];
					$affiliate_url = $options[WPGB_DEFAULT_URL_NAME];
					if (!$enabled) {
						echo '<div id="message" class="error">' . WPGB_PLUGIN_NAME . ' ' . __('is currently disabled.', WPGB_LOCAL) . '</div>';
					}
					if (($affiliate_url === WPGB_DEFAULT_URL) || ($affiliate_url === false)) {
						echo '<div id="message" class="updated">' . __('WARNING: Affiliate URL missing. Please enter it below, or pass it to the shortcode or function, otherwise the plugin won\'t do anything.', WPGB_LOCAL) . '</div>';
					}
        }
			}
    } // end page check
  } // end privilege check
} // end admin msgs function
// add admin CSS if we are on the plugin options page
add_action('admin_head', 'insert_wpgb_admin_css');
function insert_wpgb_admin_css() {
  global $pagenow;
  if (current_user_can('manage_options')) { // user has privilege
    if ($pagenow == 'options-general.php') {
      if ($_GET['page'] == WPGB_SLUG) { // we are on settings page
        wpgb_admin_styles();
      }
    }
  }
}
// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_genesis_box_plugin_settings_link' );
function wp_genesis_box_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=wp-genesis-box">' . __('Settings', WPGB_LOCAL) . '</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
// http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
add_filter('plugin_row_meta', 'wpgb_meta_links', 10, 2);
function wpgb_meta_links($links, $file) {
  $plugin = plugin_basename(__FILE__);
  // create link
  if ($file == $plugin) {
    $links = array_merge($links,
      array(
        '<a href="http://wordpress.org/support/plugin/' . WPGB_SLUG . '">' . __('Support', WPGB_LOCAL) . '</a>',
        '<a href="http://wordpress.org/extend/plugins/' . WPGB_SLUG . '/">' . __('Documentation', WPGB_LOCAL) . '</a>',
        '<a href="http://wordpress.org/plugins/' . WPGB_SLUG . '/faq/">' . __('FAQ', WPGB_LOCAL) . '</a>'
    ));
  }
  return $links;
}
// enqueue/register the plugin CSS file
function wp_genesis_box_styles() {
  wp_enqueue_style('wp_genesis_box_style');
}
function register_wp_genesis_box_style() {
  wp_register_style('wp_genesis_box_style', 
    plugins_url(plugin_basename(dirname(__FILE__)) . '/css/wp-genesis-box.css'), 
    array(), 
    WPGB_VERSION, 
    'all' );
}
// enqueue/register the admin CSS file
function wpgb_admin_styles() {
  wp_enqueue_style('wpgb_admin_style');
}
function register_wpgb_admin_style() {
  wp_register_style( 'wpgb_admin_style',
    plugins_url(plugin_basename(dirname(__FILE__)) . '/css/admin.css'),
    array(),
    WPGB_VERSION,
    'all' );
}
// enqueue/register the admin JS file
add_action('admin_enqueue_scripts', 'wpgb_ed_buttons');
function wpgb_ed_buttons($hook) {
  if (($hook == 'post-new.php') || ($hook == 'post.php')) {
    wp_enqueue_script('wpgb_add_editor_button');
  }
}
function register_wpgb_admin_script() {
  wp_register_script('wpgb_add_editor_button',
    plugins_url(plugin_basename(dirname(__FILE__)) . '/js/editor_button.js'), 
    array('quicktags'), 
    WPGB_VERSION, 
    true);
}
// when plugin is activated, create options array and populate with defaults
register_activation_hook(__FILE__, 'wpgb_activate');
function wpgb_activate() {
  $options = wpgb_getpluginoptions();
  update_option(WPGB_OPTION, $options);
}
// generic function that returns plugin options from DB
// if option does not exist, returns plugin defaults
function wpgb_getpluginoptions() {
  return get_option(WPGB_OPTION, array(WPGB_DEFAULT_ENABLED_NAME => WPGB_DEFAULT_ENABLED, WPGB_DEFAULT_URL_NAME => WPGB_DEFAULT_URL, WPGB_DEFAULT_ROUNDED_NAME => WPGB_ROUNDED, WPGB_DEFAULT_NOFOLLOW_NAME => WPGB_NOFOLLOW, WPGB_DEFAULT_IMAGE_NAME => WPGB_DEFAULT_IMAGE, WPGB_DEFAULT_AUTO_INSERT_NAME => WPGB_DEFAULT_AUTO_INSERT, WPGB_DEFAULT_NEWWINDOW_NAME => WPGB_DEFAULT_NEWWINDOW));
}
// function to return shortcode defaults
function wpgb_shortcode_defaults() {
  return array(
    WPGB_DEFAULT_URL_NAME => WPGB_DEFAULT_URL, 
    WPGB_DEFAULT_ROUNDED_NAME => WPGB_ROUNDED, 
    WPGB_DEFAULT_NOFOLLOW_NAME => WPGB_NOFOLLOW, 
    WPGB_DEFAULT_IMAGE_NAME => WPGB_DEFAULT_IMAGE, 
    WPGB_DEFAULT_NEWWINDOW_NAME => WPGB_DEFAULT_NEWWINDOW, 
    WPGB_DEFAULT_SHOW_NAME => WPGB_DEFAULT_SHOW
    );
}
// function to return parameter status (required or not)
function wpgb_required_parameters() {
  return array(
    'true',
    'false',
    'false',
    'false',
    'false',
    'false',
  );
}
?>