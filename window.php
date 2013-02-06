<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
// check for rights
if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') && ! current_user_can('edit_candidate_posts') ) 
	wp_die(__("You are not allowed to be here"));

global $wpdb;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo __('Embed a Post', 'wp-embed-posts'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo plugins_url('wp-embed-posts'); ?>/tinymce.js"></script>
	<base target="_self" />
</head>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">

<?php
$posts = WPEmbedPosts::get_posts();
?>
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="NDPGallery" action="#">
	
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="videourl"><?php echo __('Select a Post', 'wp-embed-posts'); ?></label></td>
            <td>
              <select id="post-id" name="post-id">
              	<?php
              		foreach($posts as $lable => $ps){
              			echo '<optgroup label="'.$lable.'">';
              			foreach($ps as $id => $title){
              				echo '<option value="'.$id.'">'.$title.'</option>';
              			}
              			echo '</optgroup>';
              		}
              	?>
              </select>

              <?php 
                if(isset($_GET['id'])){
                  echo "<input type=\"hidden\" id=\"content_window_id\" value=\"".$_GET['id']."\" />";
                }
              ?>
              
            </td>
          </tr>
        </table>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onClick="insertPostID();" />
		</div>
	</div>
</form>
</body>
</html>