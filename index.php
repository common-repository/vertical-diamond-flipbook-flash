<?php


/*
Plugin Name: Nature FlipBook LITE - jQuery
Plugin URI: https://codecanyon.net/item/nature-flipbook-wordpress-plugin/9120863
Description: jQuery Responsive FlipBook Plugin for WordPress
Version: 1.7
Author: flashmaniac
Author URI: http://flashmaniac.net
*/



///////////////////////UNIQUE DATA 
define( 'NFB_FLIPBOOK_BOOK_NAME', 'Nature Book -jQuery' );   //title in admin Panel
define( 'NFB_FLIPBOOK_POST_TYPE', 'jq_flipbook_v3' );        //post type name
define( 'NFB_FLIPBOOK_BOOK_TAX',  'jq_flipbook_v3_tax' );    //taxonomy name for FlipBook
define( 'NFB_SHORTCODE','nature_book' );             		//show book using shortcode

define( 'NFB_PLUGIN_PATH', plugin_dir_path(__FILE__) );
define( 'NFB_PLUGIN_URL', plugin_dir_url(__FILE__) );
define( 'NFB_BOOK_URL',plugin_dir_url(__FILE__).'flipbook/');

///////////////////////////////////////////////////////////include other files
include_once(NFB_PLUGIN_PATH . '/lib/function.php');
include_once(NFB_PLUGIN_PATH . '/lib/structure.php');
include_once(NFB_PLUGIN_PATH . '/lib/categories_custom_fields.php');
include_once(NFB_PLUGIN_PATH . '/lib/shortcodes.php');
include_once(NFB_PLUGIN_PATH . '/lib/simple-page-ordering.php');


///add variable from php to js
add_action('wp_head','nfb_pluginurl');
function nfb_pluginurl() {
?>
    <script>
	
	  var fb5_books=[];
	
	</script>
<?php	

$terms = get_terms(NFB_FLIPBOOK_BOOK_TAX);	
foreach($terms as $term){
	$term_id=$term->term_id;
	$slug=$term->slug;
	$config= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id);
	if( $config['bcg_type']=='color' ){
	  $bcg=$config['bcg_color'];
    }else{
	  $bcg=$config['bcg'];
    }
	$w=$config['page_width'];
	$h=$config['page_height'];
	$opacity=$config['bcg_opacity'];
	$toolbar_visible=$config['toolbar_visible'];
	if( $toolbar_visible == "true"){
	  $toolsHeight='80';	
	}else{
	  $toolsHeight='0'	;
	}	
	?>
    <script>
	
	  fb5_books['<?php echo $slug; ?>']={bcg:"<?php echo $bcg; ?>",w:"<?php echo $w; ?>",h:"<?php echo $h; ?>",opacity:"<?php echo $opacity; ?>",toolsHeight:"<?php echo $toolsHeight; ?>"}
	  	  
	
	</script>
    
    <?php
	//echo $slug."<br>";

}

	
?>


<script type="text/javascript">
var fb5_plugin_url = '<?php echo NFB_PLUGIN_URL; ?>';
</script>
<?php
}

/////////////////////////////////////////////////////////attach script
add_action('wp_enqueue_scripts', 'nfb_include_js_flipbook',2002);
function nfb_include_js_flipbook(){
  
   
   //get ID for page,post etc
   $my_id = get_the_ID();
   //get post
   $post = get_post($my_id);
   //get content
   $content = $post->post_content; 
   
   

   
   if(  stripos( $content, '['.NFB_SHORTCODE )!==false || preg_match('/load_book_lightbox\(/', do_shortcode( $content) ) ){ 
  //if(   is_page_template('template-flipbook.php'  ) ||  stripos( $content, '[NFB_SHORTCODE' )!==false ){   
       

	//GET CATEGORY FLIPBOOK ///
	
	//get cat from template 
	if (  is_page_template('template-flipbook.php'  ) ){
		
		$cat=get_post_meta($my_id,'category_for_templatebook',true);
		$full_area="true";
	
	///other pages/post  ( get cat from content )			
	}else{
		
		 $full_area="false";
		
    	 //get category (from shortcode)
    	 $pattern = get_shortcode_regex();
   		 if (   preg_match_all( '/'. $pattern .'/s', $content, $matches )
        	&& array_key_exists( 2, $matches )
        	&& in_array( NFB_SHORTCODE, $matches[2] ) )
    		{				
				////get index for shortcode NFB_SHORTCODE
				$index=0; 
				foreach( $matches[2] as $item){
				    if( $item==NFB_SHORTCODE){
					    break;
					}
					$index++;	
				}
				////end get index for shortcode NFB_SHORTCODE
     			$cat=$matches[3][$index];
				$cat= str_replace("cat=","",$cat);
				$cat= str_replace("'","",$cat);
				$cat= str_replace("'","",$cat);
			}
			
			///add css and js
	nfb_add_css_and_js($cat,$full_area);
	}
	
	//echo '<pre>';
	//print_r($matches);
	//echo '</pre>';
	
	// END - GET CATEGORY FLIPBOOK ///
	
    
	
        
   }
   
  
}


/////////////////////////////////////////////////////attach script in panel admin
function nfb_admin_scripts() {
//on_load
wp_deregister_script('on_load');	
wp_register_script('on_load',NFB_PLUGIN_URL."js/on_load.js", false);
wp_enqueue_script('on_load');

wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('my-upload');
wp_enqueue_media(); //new media uploader

}
 
function nfb_admin_styles() {
global $typenow;
if ($typenow==NFB_FLIPBOOK_POST_TYPE) {
wp_enqueue_style('fb5',NFB_PLUGIN_URL."css/admin.css");   	
}
wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'nfb_admin_scripts');
add_action('admin_enqueue_scripts', 'nfb_admin_styles');




//post-thumbnails
add_theme_support('post-thumbnails');
//add_image_size('admin_column',9999,100);       //in admin - column preview
add_image_size('j5_thumbpage',9999,228);       //width thumb in front



///editor wyswyg styles
/*
function fb5_plugin_mce_css( $mce_css ) {
	    if ( ! empty( $mce_css ) )
		  $mce_css .= ',';		  
		  if( isset( $_REQUEST['tag_ID']) ) {
		  	$config= get_option(fb5_FLIPBOOK_BOOK_TAX.'__'.$_REQUEST['tag_ID']);
		  	$width=$config['page_width']-50;
		  }else{
			 global $post;  
			$terms = get_the_terms($post->ID,NFB_FLIPBOOK_BOOK_TAX );  
			$term_id=$terms[0]->term_id;
			$config= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id);
			$width=$config['page_width']-50;  
		  }

        global $current_screen;	
		
		if ( NFB_FLIPBOOK_POST_TYPE === $current_screen -> post_type ){
				$mce_css = plugins_url( "css/editor.css", __FILE__ );			
		}	

	   return $mce_css;
}
add_filter( 'mce_css', 'fb5_plugin_mce_css' );
/*/



/*
 Copyright 2013 Tom McFarlin (tom@tommcfarlin.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

if( ! defined( 'NFB_PAGE_TEMPLATE_PLUGIN' ) ) {
	define( 'NFB_PAGE_TEMPLATE_PLUGIN', '0.1' );
} // end if

/**
 * @package Page Template Example
 * @version 0.1
 * @since 	0.1
 */
class nfb_Page_Template_Plugin {

	/*--------------------------------------------*
	 * Attributes
	 *--------------------------------------------*/

	/** A reference to an instance of this class. **/
	private static $instance;

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Returns an instance of this class. This is the Singleton design pattern.
	 * 
	 * @return OBJECT 	A reference to an instance of this class.
	 */
	public static function getInstance() {

		if( null == self::$instance ) {
			self::$instance = new nfb_Page_Template_Plugin();
		} // end if

		return self::$instance;

	} // end getInstance

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 *
	 * @version		1.0
     * @since 		1.0
	 */
	private function __construct() {

		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		register_activation_hook( __FILE__, array( $this, 'register_project_template' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deregister_project_template' ) );
		
	} // end constructor

	/*--------------------------------------------*
	 * Localization
	 *--------------------------------------------*/

	/**
	 * Loads the plugin text domain for translation
	 *
	 * @version		1.0
     * @since 		1.0
	 */
	public function plugin_textdomain() {
		load_plugin_textdomain( 'pte', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	} // end plugin_textdomain

	/*--------------------------------------------*
	 * Activation and Deactivation Hooks
	 *--------------------------------------------*/

	/**
	 * Copies the template from the `views/templates` directory to the root of the active theme
	 * directory so that it can be applied to pages.
	 *
	 * @verison	1.0
	 * @since	1.0
	 */
	public function register_project_template() {

		// Get the template source and destination for copying from the plugin to the theme directory
		$template_destination = $this->get_template_destination();
		$template_source = $this->get_template_source();

		// Now actually copy the template file from the plugin to the destination
		$this->copy_page_template( $template_source, $template_destination );

	} // end register_project_template
	
	/** 
	 * Removes the template from the theme directory that was added during theme activation.
	 *
	 * @version	1.0
	 * since	1.0
	 */
	public function deregister_project_template() {
		
		// Get the path to the theme
		$theme_dir = get_template_directory();
		$template_path = $theme_dir . '/template-flipbook.php';
		
		// If the template file is in the theme path, delete it.
		if( file_exists( $template_path ) ) {
			unlink( $template_path );
		} // end if
		
	} // end deregister_project_template

	/*--------------------------------------------*
	 * Helper Methods
	 *--------------------------------------------*/

	/**
	 * @return string The destination to the plugin directory relative to the currently active theme
	 */
	private function get_template_destination() {
		return get_template_directory() . '/template-flipbook.php';
	} // end get_template_destination

	/**
	 * @return string The path to the template file relative to the plugin.
	 */
	private function get_template_source() {
		return dirname( __FILE__ ) . '/templates/template-flipbook.php';
	} // end get_template_source

	/**
	 * Copies the contents of the template from the source file in the plugin
	 * to the destination in the current theme directory.
	 * 
	 * This works by first creating an empty file, reading the contents of the template file
	 * then writing it into the empty file in the theme directory.
	 *
	 * Note that this version is for demonstration purposes only and does not include proper
	 * exception handling for when file operations fail.
	 * 
	 * @param  string $template_source      The path on which the template resides.
	 * @param  string $template_destination The path to which the template should be written.
	 */
	private function copy_page_template( $template_source, $template_destination ) {

		// After that, check to see if the template already exists. If so don't copy it; otherwise, copy if
		if( ! file_exists( $template_destination ) ) {
			
			// Create an empty version of the file
			touch( $template_destination );
			
			// Read the source file starting from the beginning of the file
			if( null != ( $template_handle = @fopen( $template_source, 'r' ) ) ) {
			
				// Now read the contents of the file into a string. Read up to the length of the source file
				if( null != ( $template_content = fread( $template_handle, filesize( $template_source ) ) ) ) {
				
					// Relinquish the resource
					fclose( $template_handle );
					
				} // end if
				
			} // end if
						
			// Now open the file for reading and writing
			if( null != ( $template_handle = @fopen( $template_destination, 'r+' ) ) ) {
			
				// Attempt to write the contents of the string
				if( null != fwrite( $template_handle, $template_content, strlen( $template_content ) ) ) {
				
					// Relinquish the resource
					fclose( $template_handle );
					
				} // end if

			} // end if
			
		} // end if

	} // end copy_page_template

} // end class

$GLOBALS['ptb'] = nfb_Page_Template_Plugin::getInstance();






?>