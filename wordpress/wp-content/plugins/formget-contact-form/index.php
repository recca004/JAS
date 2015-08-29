<?php
/*
  Plugin Name: FormGet Contact Form
  Plugin URI: http://www.formget.com
  Description: FormGet Contact Form is an eassy and effective form builder tool which enable you to bulid and embed form on your website in few steps. With FormGet Contact Form manage all your contact forms and your entire client communication at one single place.
  Version: 1.6
  Author: FormGet
  Author URI: http://www.formget.com
 */
function my_admin_notice() {
	$fg_iframe_form = get_option('fg_embed_code');
	$string = "sideBar";
        $pos = strpos($fg_iframe_form, $string);
        if ($pos == false) {
		global $current_user ;
		$user_id = $current_user->ID;
 /* Check that the user hasn't already clicked to ignore the message */
	 if ( ! get_user_meta($user_id, 'admin_ignore_notice') ){
	?>
    <div class="fg_trial-notify">
        <p>
	<a href='<?php echo admin_url('admin.php?page=cf_page'); ?>'>Click to Create your own Advance Contact Form.</a> You can add your built form to any Page, Post, Sidebar or as a Tabbed Content.<?php printf(__('<a class="fg_hide_notice", href="%1$s">Hide Notice</a>'), '?admin_nag_ignore=0'); ?></p>
    </div>
    <?php
	 }}}
add_action( 'admin_notices', 'my_admin_notice' );

function admin_nag_ignore() {
    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['admin_nag_ignore']) && '0' == $_GET['admin_nag_ignore'] ) {
             add_user_meta($user_id, 'admin_ignore_notice', 'true', true);
    }
}
add_action('admin_init', 'admin_nag_ignore');

function delete_user_entry(){
	 global $current_user;
        $user_id = $current_user->ID;
delete_user_meta( $user_id, 'admin_ignore_notice', 'true', true );
}
register_deactivation_hook(__FILE__, 'delete_user_entry');

function cf_add_style() {
    wp_enqueue_style('form1_style1_sheet1', plugins_url('css/fgstyle.css', __FILE__));
}

add_action("init", "cf_add_style");


//setting page
add_action('admin_menu', 'cf_menu_page');

function cf_menu_page() {
    add_menu_page('cf', 'Contact Form', 'manage_options', 'cf_page', 'cf_setting_page', plugins_url('image/favicon.ico', __FILE__), 109);
}

function cf_setting_page() {
    $url = plugins_url();
    ?><div id="fg_of_container" class="fg_wrap">
        <form id="fg_ofform" action="" method="POST">
            <div id="fg_header">
                <div class="fg_logo">
                    <h2> FormGet Contact Form</h2>
                </div>
                <a target="#">
                    <div class="fg_icon-option"> </div>
                </a>
                <div class="clear"></div>
            </div>
            <div id="fg_main">

                <div id="fg_of-nav">
                    <ul>

                        <li> <a class="pn-view-a" href="#pn_content" title="Form Builder">Contact Form Builder </a></li>
                        <li> <a class="pn-view-a" href="#pn_displaysetting" title="Embed Code">Embed Code</a></li>
                        <li> <a class="pn-view-a" href="#pn_template" title="Help">Help</a></li>	
						<li> <a class="pn-view-a" href="#pn_contactus" title="Help">Plugin Support</a></li>

                    </ul>

                </div>
                <div id="fg_content">
                    <div class="fg_group" id="pn_content">
                        <h2>Contact Form Builder</h2>

                        <div class="fg_section section-text">
                            <h3 class="fg_heading"> Create your custom form by just clicking the fields on left side of the panel.</h3>

                            <iframe src="http://www.formget.com/app" name="iframe" id="iframebox" style="width:100%; height:750px; border:1px solid #dfdfdf; align:center;">
                            </iframe>
                        </div>

                    </div>	

                    <div class="fg_group" id="pn_displaysetting">
                        <h2>Embed Code</h2>

                        <div class="fg_section section-text">
                            <h3 class="fg_heading">Embed code field will only accept code for tabbed widgets. Please do not place shortcode here. </h3>
                            <div class="option">
                                <div class="fg_controls">
                                    <textarea name="content[html]" cols="60" rows="10"   class="regular-text"  id="fg_content_html" style="width:900px"><?php echo embeded_code(); ?></textarea>
                                    
									<input id="submit-form" class="fg_embed_code_save button-primary" type="button" value="Save Changes" name="submit_form" style="display:none;">			
									 <div id="loader_img" align="center" style="margin-left:460px; display:none;">
                                        <img src="<?php echo plugins_url('image/ajax-loader.gif', __FILE__); ?>">
                                    </div>

                                </div>
								
								</div>
                        </div>

                    </div>
                    <div class="fg_group" id="pn_template">
                        <h2>Steps to use FormGet Contact Form Plugin</h2>

                        <div class="fg_section section-text">
                            <h3></h3>
                            <div id="help_txt" style="width:900px;">
                                <ol class="step_ol">

                                    <li class="step_li">Click on the fields and create your contact form</br></br></br>
                                   <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Sign_Up_and_Create_Your_Form.png', __FILE__); ?>"></div></li></br></br></br>

                                    <li class="step_li">To rename the form in your own text, click on the tab field. You can make fields required if you want, just check mark the box. At last save your changes.</br></br></br>
                                        <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Rename the Contact Form.png', __FILE__); ?>"></div></li></br></br></br>
										
								  <li class="step_li">If you are already a registed member on FormGet then log in with your credentials to view your form or sign up yourself</br></br></br>
								  <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Sign_Up.png', __FILE__); ?>"></div></li></br></br></br>
								   <li class="step_li">Now you can embed your Contact Form on your website.</br></br></br>
								  <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Message.png', __FILE__); ?>"></div></li></br></br></br>
                                    <li class="step_li">To embed the form on your website click on Embed option.</br></br></br>
                                        <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Embed the form.png', __FILE__); ?>"></div></li></br></br></br>
                                    <li class="step_li">Copy the code for tabbed widget.</br></br></br>
                                        <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Copy the code.png', __FILE__); ?>"></div></li></br></br></br>
                                    <li class="step_li">Paste the copied embed code in the Embed Code section. At last save your changes.</li></br></br>
									<p><b>NOTE:- Only tabbed widget code can be placed in Embed Code field. 
</b></p></br>
                                    <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Paste the code.png', __FILE__); ?>"></div></li></br></br></br>
                                    <li class="step_li">This is how the tabbed widget will look on your website.</li></br></br>
                                    <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Tabbed_Widget_On_Website.png', __FILE__); ?>"></div></li></br></br></br>
                     
					                                 
                                    <li class="step_li">To display your Contact Form individually on pages, post, widgets and sidebar, just copy the code from the WordPress shortcode field.</li></br></br>
									                                  <div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Copy_the_code.png', __FILE__); ?>"></div></li></br></br></br>
                                    <li class="step_li">Paste the copied code either of the above options. Like I just paste it in a page.</li></br></br>
									<p><b>NOTE:- Remember shortcodes are made to show your contact form on individual pages/posts/siderbar/footer. Do not put your code in Embed Code field. It will not work.
</b></p></br>
									<div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Shortcode For Page.png', __FILE__); ?>"></div></li></br></br></br>
									<li class="step_li">This is how your Contact Form will appear on website's page through shortcode.</li></br></br>
									<div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Contact Form through shortcode.jpg', __FILE__); ?>"></div></li></br></br></br>
									<li class="step_li">If you have any issues or need any help you can just click on Plugin Support section and submit your query.</li></br></br>
									                                  
                              
								<div id="step_img" style="width:963px; border: 1px solid #dfdfdf;"><img src="<?php echo plugins_url('image/Plugin_Support.png', __FILE__); ?>"></div></li></br></br></br>
                              <div style="font-size:15px;"> <b> Thanks,</br></br>
                                FormGet Team</i></b></div>
                            </div>
                        </div>

                    </div>
					 <div class="fg_group" id="pn_contactus">
                      <iframe height='570' allowTransparency='true' frameborder='0' scrolling='no' style='width:100%;border:none'  src='http://www.formget.com/app/embed/form/qQvs-639'>Your Contact </iframe>
                      
                    </div>	

                </div>
                <div class="clear"></div>
            </div>

            <div class="fg_save_bar_top">

                

            </div>

        </form>
    </div>


    <?php
}

function cf_embeded_script() {
    wp_enqueue_script('embeded_script', plugins_url('js/fg_script.js', __FILE__), array('jquery'));
    wp_localize_script('embeded_script', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
}
if($_GET['page']=='cf_page'){
add_action('init', 'cf_embeded_script');
}

function cf_text_ajax_process_request() {
    $text_value = $_POST['value'];
    update_option('fg_embed_code', $text_value);
	echo 1;
	die();
}

add_action('wp_ajax_master_response', 'cf_text_ajax_process_request');
add_action('wp_ajax_nopriv_master_response', 'cf_text_ajax_process_request');
if (!function_exists('embeded_code')) {

    function embeded_code() {
        global $wpdb;
        $fg_iframe_form = get_option('fg_embed_code');

        $string = "sideBar";
        $pos = strpos($fg_iframe_form, $string);
        if ($pos == true) {
            echo stripslashes($fg_iframe_form);
        }
    }

}
add_action('wp_head', 'embeded_code');

//schort code function
if (!function_exists('formget_shortcode')) {

    function formget_shortcode($atts, $content = null) {
        extract(shortcode_atts(array(
            'user' => '',
            'formcode' => '',
            'allowTransparency' => true,
            'height' => '500',
            'tab' => ''
                        ), $atts));
        $iframe_formget = '';
        $url = "http://www.formget.com/app/embed/form/" . $formcode;
        if ($tab == 'page') {
            $iframe_formget .="<iframe height='" . $height . "' allowTransparency='true' frameborder='0' scrolling='no' style='width:100%;border:none'  src='" . $url . "' >";
            $iframe_formget .="</iframe>";
            add_filter('widget_text', 'do_shortcode');
            return $iframe_formget;
        }
        if ($tab == 'tabbed') {
            $tabbed_formget = <<<EOD
<script type="text/javascript">
    var sideBar;
    (function(d, t) {
        var s = d.createElement(t),
                options = {
            'tabKey': '{$formcode}',
            'tabtext':'Contact Us',
            'height': '{$height}',
            'position': "",
            'textColor': 'ffffff',
            'tabColor': '7d9f2b',
            'fontSize': '16',
        };
        s.src = 'http://www.formget.com/app/app_data/user_js/widget.js';
        s.onload = s.onreadystatechange = function() {
            var rs = this.readyState;
            if (rs)
                if (rs != 'complete')
                    if (rs != 'loaded')
                        return;
            try {
                sideBar = new buildTabbed();
                sideBar.initializeOption(options);
                sideBar.loadContent();
                sideBar.buildHtml();
            } catch (e) {
            }
        };
        var scr = d.getElementsByTagName(t)[0], par = scr.parentNode;
        par.insertBefore(s, scr);
    })(document, 'script');
</script>
EOD;
            return $tabbed_formget;
        }
		
    }

}
add_shortcode('formget', 'formget_shortcode');
?>