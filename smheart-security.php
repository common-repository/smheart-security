<?php
/*
Plugin Name: SMHeart Security
Plugin URI: http://smheart.org/smheart-security/
Description: A WordPress security and hardening plugin from SMHeart Inc.  
The Administrative User is presented with several independently selectable options for making their default installation increasingly secure.
Author: Matthew Phillips
Version: 1.0
Author URI: http://smheart.org


Copyright 2009 SMHeart Inc, Matthew Phillips  (email : matthew@smheart.org)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

http://www.gnu.org/licenses/gpl.txt


*/

/*
Version
        1.0   28 December 2009

*/

add_action('admin_menu', 'smheart_security_menu');
add_action('admin_head', 'smheart_security_styles');
register_activation_hook(__FILE__, 'smheart_security_install');

function smheart_security_install() {
	global $wpdb;
	if (!is_blog_installed()) return;
	add_option('smheart_security_wp_generator', 'on', '', 'no');
	add_option('smheart_security_wlwmanifest_link', 'on', '', 'no');
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	}

function smheart_security_menu() {
	add_options_page('SMHeart Security Options', 'SMHeart Security', 8, __FILE__, 'smheart_security_options');
	}

function smheart_security_styles() {
	?>
 	<link rel="stylesheet" href="/wp-content/plugins/smheart-security/smheart-security.css" type="text/css" media="screen" charset="utf-8"/>
	<?php
	}

function smheart_security_options() {
	if (get_option('smheart_security_wp_generator') == "off"){remove_action('wp_head', 'wp_generator');}
		else{add_action('wp_head', 'wp_generator');}
	if (get_option('smheart_security_wlwmanifest_link') == "off"){remove_action('wp_head', 'wlwmanifest_link');}
		else{add_action('wp_head', 'wlwmanifest_link');}
	if (get_option('smheart_security_rsd_link') == "off"){remove_action('wp_head', 'rsd_link');}
		else{add_action('wp_head', 'rsd_link');}
	if (get_option('smheart_security_comment_html') == "on"){add_filter( 'pre_comment_content', 'wp_specialchars' );}
		else{remove_filter( 'pre_comment_content', 'wp_specialchars' );}
	?>
	<div class="wrap">
		<h2>SMHeart Security V1.0</h2>
		<div id="smheart_security_main">
			<div id="smheart_security_left_wrap">
				<div id="smheart_security_left_inside">
					<h3>Donate</h3>
					<p><em>If you like this plugin and find it useful, help keep this plugin free and actively developed by clicking the <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10784338" target="paypal"><strong>donate</strong></a> button or send me a gift from my <a href="http://amzn.com/w/11GK2Q9X1JXGY" target="amazon"><strong>Amazon wishlist</strong></a>.  Also follow me on <a href="http://twitter.com/kestrachern/" target="twitter"><strong>Twitter</strong></a>.</em></p>
					<a target="paypal" title="Paypal Donate"href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=10784338"><img src="/wp-content/plugins/smheart-security/paypal.jpg" alt="Donate with PayPal" /></a>
					<a target="amazon" title="Amazon Wish List" href="http://amzn.com/w/11GK2Q9X1JXGY"><img src="/wp-content/plugins/smheart-security/amazon.jpg" alt="My Amazon wishlist" /> </a>
					<a target="Twitter" title="Follow me on Twitter" href="http://twitter.com/kestrachern/"><img src="/wp-content/plugins/smheart-security/twitter.jpg" alt="Twitter" /></a>	
				</div>
			</div>
			<div id="smheart_security_right_wrap">
				<div id="smheart_security_right_inside">
				<h3>About the Plugin</h3>
				<p> A security and hardening plugin for WordPress.  
The Administrative User is presented with several independently selectable options for making their default installation increasingly secure.</p>
				</div>
			</div>
		</div>
	<div style="clear:both;"></div>
	<fieldset class="options"><legend>SMHeart Security Option</legend> 
	<form method="post" action="options.php">
		<?php echo wp_nonce_field('update-options'); ?>
			<fieldset class="selectors">
				<legend>WP Generator [<a class="smheart-security_description" title="Click for Description!" onclick="toggleVisibility('wp_generator');">Info</a>]</legend>
				<div class="smheart-security_description_text" id="wp_generator">
					<p>This will completely remove the version number from WordPress header. This information may prove a goldmine for WordPress hackers as they can easily target blogs that are using the older and less secure versions of WordPress software. </p><p> Recommended: Disable</p>
				</div>
				<?php if (get_option('smheart_security_wp_generator') == "off"){ ?>
					<input type="radio" name="smheart_security_wp_generator" value="off" checked/> <strong> Disable</strong> 
					<input type="radio" name="smheart_security_wp_generator" value="on"/> Enable 
				<?php }
				else{ ?>
					<input type="radio" name="smheart_security_wp_generator" value="off"/> <strong> Disable</strong> 
					<input type="radio" name="smheart_security_wp_generator" value="on" checked/> Enable 
				<?php } ?>
			</fieldset>
			<fieldset class="selectors">
				<legend>WLW Manifest Link [<a class="smheart-security_description" title="Click for Description!" onclick="toggleVisibility('wlwmanifest_link');">Info</a>]</legend>
				<div class="smheart-security_description_text" id="wlwmanifest_link">
					<p>The WLW-Manifest function is used by Windows Live Writer to download the styles / themes used in your WordPress blog. Windows Live Writer users who do not use the live preview feature may also turn off this function.</p><p> Recommended: Disable</p>
				</div>
				<?php if (get_option('smheart_security_wlwmanifest_link') == "off"){ ?>
					<input type="radio" name="smheart_security_wlwmanifest_link" value="off" checked/> <strong> Disable</strong> 
					<input type="radio" name="smheart_security_wlwmanifest_link" value="on"/> Enable
				<?php }
				else{ ?>
					<input type="radio" name="smheart_security_wlwmanifest_link" value="off"/><strong> Disable</strong>
					<input type="radio" name="smheart_security_wlwmanifest_link" value="on" checked/> Enable
		<?php }?>
			</fieldset>
			<fieldset class="selectors">
				<legend>Really Simple Discovery Link [<a class="smheart-security_description" title="Click for Description!" onclick="toggleVisibility('rsd_link');">Info</a>]</legend>
				<div class="smheart-security_description_text" id="rsd_link">
					<p>Really Simple Discovery or RSD for short is an XML file that contains the software setup information that client software can use. It is only necessary f you are planning on using any desktop publishing client to post.</p><p> Recommended: Disable</p>
				</div>
				<?php if (get_option('smheart_security_rsd_link') == "off"){ ?>
					<input type="radio" name="smheart_security_rsd_link" value="off" checked/> <strong> Disable</strong> 
					<input type="radio" name="smheart_security_rsd_link" value="on"/> Enable
				<?php }
				else{ ?>
					<input type="radio" name="smheart_security_rsd_link" value="off"/><strong> Disable</strong>
					<input type="radio" name="smheart_security_rsd_link" value="on" checked/> Enable
		<?php }?>
			</fieldset>
			<fieldset class="selectors">
				<legend>Comment HTML Filter [<a class="smheart-security_description" title="Click for Description!" onclick="toggleVisibility('comment_html');">Info</a>]</legend>
				<div class="smheart-security_description_text" id="comment_html">
					<p>The comment box is WordPress is like a basic HTML editor &#45; people can use HTML tags like &lt;b&gt;, &lt;a&gt;, &lt;i&gt;, etc to highlight certain words in their comment or add live links. Enable this to disable HTML in WordPress comments</p><p> Recommended: Enable</p>
				</div>
				<?php if (get_option('smheart_security_comment_html') == "on"){ ?>
					<input type="radio" name="smheart_security_comment_html" value="on" checked/> <strong> Enable</strong> 
					<input type="radio" name="smheart_security_comment_html" value="off"/> Disable
				<?php }
				else{ ?>
					<input type="radio" name="smheart_security_comment_html" value="on"/><strong> Enable</strong>
					<input type="radio" name="smheart_security_comment_html" value="off" checked/> Disable
		<?php }?>
			</fieldset>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="smheart_security_wlwmanifest_link,smheart_security_wp_generator,smheart_security_rsd_link,smheart_security_post_html" />
		<p class="submit">
			<input type="submit" name="Submit" value="Secure <?php echo get_bloginfo('name'); ?>" />
		</p>
	</form>
	</fieldset>
	<div style="clear:both;"></div>			
	<fieldset class="options"><legend>Feature Suggestion/Bug Report</legend> 
	<?php if ($_SERVER['REQUEST_METHOD'] != 'POST'){
      		$me = $_SERVER['PHP_SELF'].'?page=smheart-security/smheart-security.php';
		?>
		<form name="form1" method="post" action="<?php echo $me;?>">
		<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td>
				Make a:
			</td>
			<td>
				<select name="MessageType">
				<option value="Feature Suggestion">Feature Suggestion</option>
				<option value="Bug Report">Bug Report</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Name:
			</td>
			<td>
				<input type="text" name="Name">
			</td>
		</tr>
		<tr>
			<td>
				Your email:
			</td>
			<td>
				<input type="text" name="Email" value="<?php echo(get_option('admin_email')) ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top">
				Message:
			</td>
			<td>
				<textarea name="MsgBody">
				</textarea>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<input type="submit" name="Submit" value="Send">
			</td>
		</tr>
	</table>
</form>
<?php
   } else {
      error_reporting(0);
	$recipient = 'support@smheart.org';
	$subject = stripslashes($_POST['MessageType']).'- SMHeart Security Plugin';
	$name = stripslashes($_POST['Name']);
	$email = stripslashes($_POST['Email']);
	if ($from == "") {
		$from = get_option('admin_email');
	}
	$header = "From: ".$name." <".$from.">\r\n."."Reply-To: ".$from." \r\n"."X-Mailer: PHP/" . phpversion();
	$msg = stripslashes($_POST['MsgBody']);
      if (mail($recipient, $subject, $msg, $header))
         echo nl2br("<h2>Message Sent:</h2>
         <strong>To:</strong> SMHeart Security Support
         <strong>Subject:</strong> $subject
         <strong>Message:</strong> $msg");
      else
         echo "<h2>Message failed to send</h2>";
	}
?>
	</fieldset>				
	</div>
<script type="text/javascript">
<!--
    function toggleVisibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
	}
//-->
</script>


	<?php
	}
?>