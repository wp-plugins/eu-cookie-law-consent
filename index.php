<?php
/* 
Plugin Name: EU Cookie Law Complience Message
Plugin URI:  http://azuliadesigns.com/wordpress-plugin-eu-cookie-law/
Version: 1.00
Author: Azulia Designs
Description: This is a small plug-in which adds a banner to the page on the first page view for each visitor. This plug-in is used for implied consent, which means that if the guest continues using the site they agree to cookie use. See plug-in homepage for live demo.
*/

function EUCLC_enqueueScripts()  
{  
    wp_enqueue_script('jquery');  
} 
add_action('wp_enqueue_scripts', 'EUCLC_enqueueScripts'); 


function EUCLC_cookieMessage()
{
  global $defaultMessage, $defaultTitle;
?>
<script type="text/javascript">
jQuery(function(){ 
  if (navigator.cookieEnabled === true)
  {
    if (document.cookie.indexOf("visited") == -1)
	{
	  jQuery('body').prepend('<div id="cookie" style="display:none;position:absolute;left:0;top:0;width:100%;background:rgba(0,0,0,0.8);z-index:9999"><div style="width:800px;margin-left:auto;margin-right:auto;padding:10px 0"><h2 style="margin:0;padding:0;color:white;display: block;float: left;height: 40px;line-height: 20px;text-align: right;width: 140px;font: normal normal normal 18px Arial,verdana,sans-serif"><?php echo addslashes(get_option('notificationTitle', $defaultTitle)); ?></h2><p style="color:#BEBEBE;display: block;float: left;font: normal normal normal 13px Arial,verdana,sans-serif;height: 64px;line-height: 16px;margin:0 0 0 30px;padding:0;width:450px;"><?php echo addslashes(get_option('notificationMessage', $defaultMessage)); ?></p><div style="float:left;margin-left:10px"><a href="#" id="closecookie" style="color:white;font:12px Arial;text-decoration:none">Close</a></div><div style="clear:both"></div></div></div>');
	  jQuery('#cookie').show("fast");
	  jQuery('#closecookie').click(function() {jQuery('#cookie').hide("fast");});
	  document.cookie="visited=yes; expires=Thu, 31 Dec 2020 23:59:59 UTC; path=/";
	}
  }
})
</script>
<?
}
add_action('wp_footer', 'EUCLC_cookieMessage'); 




function EUCLC_createMenu() 
{
	add_submenu_page('options-general.php', 'EU Cookie Message', 'EU Cookie Message', 'administrator', 'EUCLC_settingsPage', 'EUCLC_settingsPage'); 
	add_action('admin_init', 'EUCLC_registerSettings');
}
add_action('admin_menu', 'EUCLC_createMenu');



function EUCLC_registerSettings() 
{
	register_setting('EUCLC', 'notificationTitle');
	register_setting('EUCLC', 'notificationMessage');
}


function EUCLC_settingsPage() 
{
  global $defaultMessage, $defaultTitle;
?>
<div class="wrap">
<h2>EU Cookie Law Complience Message</h2>
<form method="post" action="options.php">
    <?php settings_fields('EUCLC'); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Message Title</th>
        <td><input name="notificationTitle" class="regular-text" type="text" value="<?php echo get_option('notificationTitle', $defaultTitle); ?>" /></td>
        </tr>
        <tr valign="top">
        <th scope="row">Message Text</th>
        <td><textarea name="notificationMessage" class="large-text code"><?php echo get_option('notificationMessage', $defaultMessage); ?></textarea></td>
        </tr>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>
</div>
<?php } 


  $defaultTitle = 'Cookies on this website';
  $defaultMessage = 'We use cookies to ensure that we give you the best experience on our website. If you continue without changing your settings, we\'ll assume that you are happy to receive all cookies from this website. If you would like to change your preferences you may do so by following the instructions <a href="http://www.aboutcookies.org/Default.aspx?page=1" rel="nofollow" style="color:white">here</a>.'

?>