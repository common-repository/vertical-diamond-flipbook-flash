<?php 

////////////////////////////CREATE STRUCTURE////////////////////////////////////////////////////////////////////////

add_action('init', 'nfb_create_structure_flipbook');
function nfb_create_structure_flipbook() {
			
	register_post_type(NFB_FLIPBOOK_POST_TYPE,
		array(
			'labels' => array(
			    'menu_name' => __( NFB_FLIPBOOK_BOOK_NAME , NFB_FLIPBOOK_POST_TYPE ),
				'name' => __( 'page for FlipBook' , NFB_FLIPBOOK_POST_TYPE ),
				'singular_name' => __( 'FlipBook' ,NFB_FLIPBOOK_POST_TYPE ),
				'all_items' => __( 'All Pages' ,NFB_FLIPBOOK_POST_TYPE ),
				'add_new_item' => __( 'Add New Page' ,NFB_FLIPBOOK_POST_TYPE ),
				'new_item' => __( 'Add New Page' ,NFB_FLIPBOOK_POST_TYPE ),
				'add_new' => __( 'Add New Page' ,NFB_FLIPBOOK_POST_TYPE ),
				'edit_item' => __( 'edit_item' ,NFB_FLIPBOOK_POST_TYPE )
				
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
		'prevent_duplicates' => true,
		'show_ui'=>true,
		'can_export' => true,
		'order'=>"DESC"
		)
	);
		

    //category	
	register_taxonomy(NFB_FLIPBOOK_BOOK_TAX, array(NFB_FLIPBOOK_POST_TYPE), array(
		'hierarchical'	=> true,
		'labels'		=> array(
		         'menu_name' => __( 'Books' , NFB_FLIPBOOK_POST_TYPE ),
		 		 'name' => _x('Books', 'taxonomy general name',NFB_FLIPBOOK_POST_TYPE),
				 'add_new_item' => __( 'Add New Book' ,NFB_FLIPBOOK_POST_TYPE ),
				 'edit_item' => __('Edit Book',NFB_FLIPBOOK_POST_TYPE),

		 ) ,
		'show_ui'		=> true,
 		'can_export' => true,
		'query_var'		=> true,
	));
	
	//flush_rewrite_rules(false);
}

/////////////////////////////////create custom column in list pages////////////////////////////////////////////////////////////////

	add_filter('manage_'.NFB_FLIPBOOK_POST_TYPE.'_posts_columns', 'nfb_flipbook_create_coumn',1);  
    add_action('manage_'.NFB_FLIPBOOK_POST_TYPE.'_posts_custom_column', 'nfb_flipbook_create_coumn_content', 10, 2);  
    function nfb_flipbook_create_coumn($defaults) {  
        $defaults=array();
		$defaults['cb'] = 'cb'; 
		$defaults['image_preview'] = 'Image';  
		//$defaults['atr'] = 'Text from WYSIWYG editor';  
		$defaults['deeplinking'] = 'Deep Linking';
		$defaults['menu_order'] = 'EDIT'; 
		
		//$defaults['title'] = 'Title';  
		
		$defaults['cat'] = 'Categories'; 
		
		//$defaults['date'] = 'Date';  
		
		return $defaults;  
    }  
	
	
	
   function nfb_flipbook_create_coumn_content($column_name, $post_ID) {  
   			global $post;
			
			//image page
			$imagepage_src=get_post_meta($post->ID,'imagepage',true);
				
			//image thumb		
			$thumbpage_src=get_post_meta($post->ID,'thumbpage',true);
		
					
			if( strlen( $thumbpage_src ) ){
					$image_src=$thumbpage_src;
			}else if( strlen ( $imagepage_src ) ){
					$image_src=$imagepage_src;
			}else{
				    $image_src=NFB_PLUGIN_URL."img/empty.png";
			}
			
					
        	if($column_name=='image_preview'){
		 	
			/////////INSERT IMAGE
			echo "<a href='post.php?post=$post_ID&action=edit'><img id='preview_img' style='max-height:100px' src='$image_src'></a>";
			
			//////center single image/swf
			if( get_post_meta( $post->ID, 'double_page', true ) != 'true' ){ 
				   
			      ?>
						<script type="text/javascript">
							/*jQuery(function(){             
                    			var preview=jQuery('#post-<?php echo $post_ID ?> .image_preview');
								preview.css('padding-left',jQuery('#preview_img').height()/2+"px");
                     		})
							/*/
						</script>
                        <?php
				 }
	
			
		 }
		 
		 
		////////////////////////////Deep linking
		if( $column_name=="deeplinking" ) {
			echo get_the_title($post_ID);			
		}
		 
		 
		/////////////////////////////attributes
								
			if($column_name=='atr'){	
			    $str_atr='';
			
			    $double_page=get_post_meta($post->ID,'double_page',true);
			    if ( $double_page=="true" ){
				   //$str_atr.="double page";					
				}else{
				   //$str_atr.="single page";
				}
				
				$str_atr.="<br>";
				
				$content_post = get_post($post->ID);
				$content = $content_post->post_content;
				
				if( strlen ($content) ){
				    $str_atr.="YES";	
				}else{
					$str_atr.="NO";
				}
			
			    echo "<strong>".$str_atr."</strong>";
			} 
		 
		 
			 
		//////////menu order
		if($column_name=='menu_order'){
			//echo "<a href='post.php?post=$post_ID&action=edit'>Page - ".$post->menu_order."</a>";
    		 /// echo "<a href='post.php?post=$post_ID&action=edit'>Edit Page - ".get_the_title($post_ID)."</a>";
    		 echo "<a href='post.php?post=$post_ID&action=edit'>Edit Page</a>";	 
		}
		if( $column_name == 'cat' ) {
		$_taxonomy = NFB_FLIPBOOK_BOOK_TAX;
		$terms = get_the_terms( $post->ID, $_taxonomy );
		if ( !empty( $terms ) ) {
			$out = array();
			foreach ( $terms as $c )
			$out[] = "<a href='edit.php?".NFB_FLIPBOOK_BOOK_TAX."=$c->slug&post_type=".NFB_FLIPBOOK_POST_TYPE."'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
			echo join( ', ', $out );
		}
		else {
			_e('Uncategorized','Uncategorized');
		}
	}
    }  
	
////////////////////////ORDER in list page/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function nfb_set_custom_post_types_admin_order($wp_query) {
		global $pagenow;
     	if (is_admin()) {
		    $post_type = $wp_query->query['post_type'];
 			 if ( $post_type == NFB_FLIPBOOK_POST_TYPE && $pagenow == "edit.php" ) {
     			  $wp_query->set('orderby','menu_order');
    			  $wp_query->set('order', 'ASC');
    		}
 		}
	}
	add_filter('pre_get_posts', 'nfb_set_custom_post_types_admin_order');
	


//////////////////////FILTRES category books

add_action( 'restrict_manage_posts', 'nfb_restrictmanageposts' );
function nfb_restrictmanageposts() {
    global $typenow;
    if ($typenow == NFB_FLIPBOOK_POST_TYPE) {
 	   $filters = array(NFB_FLIPBOOK_BOOK_TAX);
       foreach ($filters as $tax_id) {
            $tax_obj = get_taxonomy($tax_id);
            $tax_name = $tax_obj->labels->name;
            $terms = get_terms($tax_id,array('hide_empty'=>false));
            echo "<select name='$tax_id' id='$tax_id' class='postform'>";
            echo "<option value=''>All Categories</option>";
            foreach ($terms as $term) {
				 if( $_REQUEST[$tax_id] == $term->slug ) {
					     $selected="selected=selected";
				  }else{
					     $selected="";
				  }
				  //echo $selected;
                  echo '<option '.$selected.' value='.$term->slug.' >' . $term->name .'</option>';
            }
            echo "</select>";
        }
    }
}


////////remove filters from description Book
remove_filter('pre_term_description', 'wp_filter_kses');

////////////disable fields
function nfb_remove_post_type_support_for_pages() 
{
	remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'custom-fields' );
	remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'revisions' );
	remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'trackbacks' );
	remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'author' );
	remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'comments' );
    //remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'title' );
    //remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'editor' );
    remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'thumbnail' );
    //remove_post_type_support( 'flipbook', 'page-attributes' );
    remove_post_type_support( NFB_FLIPBOOK_POST_TYPE, 'excerpt' );
}
add_action( 'admin_init', 'nfb_remove_post_type_support_for_pages' );




/*       MANAGE MENU IN ADMIN
/////////////////////////////////////
/*/
add_action( 'admin_menu', 'nfb_manage_menu_in_admin' );
function nfb_manage_menu_in_admin(){
//remove_my_meta_boxen
remove_meta_box(NFB_FLIPBOOK_BOOK_TAX.'div',NFB_FLIPBOOK_POST_TYPE,'normal');
//add submenu Setting Global
add_submenu_page('edit.php?post_type='.NFB_FLIPBOOK_POST_TYPE, 'Settings', 'Settings', 'edit_posts', 'Settings', 'nfb_setting');
//add submenu in Custom Post on left
add_submenu_page('edit.php?post_type='.NFB_FLIPBOOK_POST_TYPE, 'Help Nature FlipBook', 'Help', 'edit_posts', 'nfb', 'nfb_show_help');

}

function nfb_show_help(){
?>

<div class='wrap'>
 
 
<h2>1) How do I add a Flipbook in my theme ? </h2>

<h3>The first method -  template ( recommended )</h3>
<p>Go to "Pages" and create a new page "Add New". Then choose it template "Nature FlipBook". Then choose it below METABOX FlipBook category.</p>
<img style="max-width:100%;height:auto" src="<?php echo NFB_PLUGIN_URL ?>img/screen1.jpg" /> <br />

<h3>The second method - shortcode</h3>
<p>Go to "Pages" and create a new page "Add New". Now copy and paste this code into the WYSIWYG editor:</p>
<code>
[nature_book cat='book5'] 
</code>
<p>cat - category flipbook ( slug name for flipbook )</p><br />
<img style="max-width:100%;height:auto" src="<?php echo NFB_PLUGIN_URL ?>img/screen2.jpg" /> <br /><br />

<p>You can also add Flipbook to post or any custom post. You need to add shortcode in the editor wysiwyg ( you can not add shortcode to type field Excerpt ). FlipBook can not appear<br />  in Excerpt in the list of posts or custom posts ( therefore is required field Excerpt - there you enter the text entry manually without flipbook shortcode )   </p>
          <p><strong>NOTE:</strong>  FlipBook can only be used once per page post or custom post. If you want to use the second Flipbook - you have to do it in another page / post / custom post. </p>

<br />

<h3>The third method - lightbox</h3>
 <p>Go to "Pages" and create a new page "Add New". Now, add a link to the text or photo into the WYSIWYG editor.</p>
 <ul>
 
    <li>1 - select the text or image</li>
    <li>2 - press the button "link" in the WYSIWYG Editor</li>
    <li>3 - enter code: <code>load_book_lightbox('book1')</code></li>

 </ul>
 <p>book1 - category flipbook ( slug name for flipbook )</p>
 <p>If you need to showed lightbox automatically, use this code:</p>
 <code>load_book_lightbox('book1',true)</code>
 <p>( differs only additional attribute "true" )</p>
 
 <p><strong>NOTE:</strong>  If you want to have a semi-transparent background you can do in the settings Book ( 'General' tab and the title 'Background' and field 'opacity') </p>
<img style="max-width:100%;height:auto" src="<?php echo NFB_PLUGIN_URL ?>img/screen3.jpg" />
<br />
 


<br /><br />
<br /><br />



<h2>2) Shortcodes </h2> 
<h3>Shortcode for first page in FlipBook</h3>
<xmp>
[home logo_src="" color_line=""]

[item redirect="setPage(2)" img_src=""]

[item redirect="http://google.com" img_src=""]

[item redirect="youtube('48I0IHmsuOE','560','315')" img_src=""]

[/home]

Attributes:
logo_src - url link to logo
redirect - redirect to the url, youtube video or redirect to another page
img_src -  url link to image
color_line - color vertical line

</xmp>
  

 
 
  
 </div>


<?php	
}






/*       START SETTING GLOBAL
/////////////////////////////////////
/*/



add_action('admin_init', 'nfb_add_settings_global' );
function nfb_add_settings_global(){
        register_setting(NFB_FLIPBOOK_BOOK_TAX,'nfb_global' );
		nfb_add_default_data_for_global_settings();
}



///////////////////////////////////////////////////////////////////////


function nfb_setting(){


//$img=nfb_add_to_library("http://imagic.hekko24.pl/folder_name/1.jpg");



?>		    
<div class="wrap">  

<form method="post" action="options.php">  
          
    <?php settings_fields(NFB_FLIPBOOK_BOOK_TAX); ?>
    <?php $options = get_option('nfb_global'); ?>

     
    <table class="form-table">  
        <h3 class="nfb">Global Settings</h3>
                  
        <!-- turnjs 
        <tr class="form-field">
        <th scope="row" valign="top"><label for="library_turnjs">Link to library turnjs</label></th>
        <td>
            <input type="text" name="nfb_global[library_turnjs]" id="library_turnjs" size="3" style="width:200px;" value="<?php /* echo $options['library_turnjs'] /*/ ?>">
            <input type="button" id="upload_library_turnjs" value="Browse" size="3" style="width:60px;" /><br />
            <img src="<?php /* echo nfb_setValue($data_form['library_turnjs']) /*/ ?>" alt=""/>
            <p class="description">You must add here the file "turn.js". This file is in a zip archive <a href="http://github.com/blasten/turn.js/archive/master.zip">here</a><br />( you need to add only the file "turn.js" - not the whole zip archive ). <br />More about the library "blasten / turn.js" you can read <a href="https://github.com/blasten/turn.js" target="_blank">here</a><br>
If the project will be commercial - you must purchase a license "<strong>3rd release</strong>" ( for more see <a href="http://www.turnjs.com/get">here</a> ) 
        </td>
      </tr> 
      -->
      
      
       <!-- custom css -->
        <tr class="form-field">
        <th scope="row" valign="top"><label for="library_turnjs">Custom CSS</label></th>
        <td>
            <textarea name="nfb_global[custom_css]" id="custom_css" size="3" rows="5" style="width:400px;"><?php echo stripslashes($options['custom_css']) ?></textarea><br />
          <p class="description">Advanced users can use custom css.</p> 
        </td>
      </tr> 
      

  
          
        
        
        
        
        
          
    </table>  
      
    <p class="submit">  
    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
    </p>  
     <input type="hidden" name="action" value="update" /> 
    
</form>  
</div>  

<?php	
}



/*       END SETTINGS GLOBAL
/////////////////////////////////////
/*/










/*       ADD META BOXES
/////////////////////////////////////
/*/

add_action( 'add_meta_boxes', 'nfb_add_custom_boxes' );
function nfb_add_custom_boxes(){
	
add_meta_box( 'box_flipbook_cat','<b>Please select Book</b>','nfb_flipbook_select_cat',NFB_FLIPBOOK_POST_TYPE, 'normal', 'high');
add_meta_box( 'box_flipbook_attr','<b>Page attributes</b>','nfb_flipbook_page_attributes',NFB_FLIPBOOK_POST_TYPE, 'normal', 'core');
add_meta_box( 'box_flipbook_upload','<b>Upload image</b>','nfb_flipbook_metabox',NFB_FLIPBOOK_POST_TYPE, 'normal', 'low');



}



/*       METABOX - SELECT CATEGORY
/////////////////////////////////////
/*/




function nfb_flipbook_select_cat (){
//lista categories	
$terms = get_terms(NFB_FLIPBOOK_BOOK_TAX,array('hide_empty'=>false));
if(!$terms){
  echo("<p style='color:red'><b>You have no FlipBook :)  First you need to create a FlipBook. Menu - 'Nature Book / Books'</b></p>");
}
//current categories
$current_cat = get_the_terms(get_the_ID(),NFB_FLIPBOOK_BOOK_TAX);
if($current_cat){
foreach ( $current_cat as $c=>$d ) {
	  $current_slug=$d->slug;
}
}

wp_nonce_field(  plugin_basename( __FILE__ ), 'flipbook_cat_noncename' );
?>
	  <p>  
        <label>List Books</label>  
        <select name="category_book" id="category_book"> 
    
        <?php 
		
		 foreach ( $terms as $key=>$value ){
			 $name=$value->name;
			 $id=$value->term_id;
			 $slug=$value->slug;
			 if($current_slug==$slug){
			 	$selected="selected='selected'";
			 }else{
				 $selected='';
			 }
			 
	        echo("<option value='$slug' $selected>$name</option>");
         }
          
           
        ?>   
        
        </select>  
    </p>  
     
	
    
<?php
	
}

 add_action( 'save_post', 'nfb_save_category_book' );
 function nfb_save_category_book($post_id){

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
	  
  if ( !isset( $_POST['flipbook_cat_noncename'] ) || !wp_verify_nonce( $_POST['flipbook_cat_noncename'], plugin_basename( __FILE__ ) ) ) {
      return;	  
  }
  
  
  if( !current_user_can( 'edit_post',$post_id ) ) return;  
  
  
  /////save
  if(  isset($_POST['category_book'])   ){
     wp_set_object_terms($post_id,$_POST['category_book'],NFB_FLIPBOOK_BOOK_TAX );
  }
  
 
 }
 
 

/*       METABOX - UPLOAD
/////////////////////////////////////
/*/

 add_action( 'save_post', 'nfb_save_upload' );
 function nfb_save_upload($post_id){

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
	  
  if ( !isset( $_POST['flipbook_cat_noncename'] ) || !wp_verify_nonce( $_POST['flipbook_cat_noncename'], plugin_basename( __FILE__ ) ) ) {
      return;	  
  }
    
  if( !current_user_can( 'edit_post',$post_id ) ) return;  
    
  /////save imagepage
   if( isset( $_POST['imagepage'] ) ) { 
        update_post_meta($post_id, 'imagepage', sanitize_text_field($_POST['imagepage']));  
   } 
   //save thumbpage
   if( isset( $_POST['thumbpage'] ) && strlen($_POST['thumbpage'])  ) { 
        update_post_meta($post_id, 'thumbpage', sanitize_text_field($_POST['thumbpage']));  
   } else{
	   
	   if( isset($_POST['imagepage']) ){
	     $image_id=nfb_get_attachment_id_from_url($_POST['imagepage']);
	     $thumbpage_att=wp_get_attachment_image_src( $image_id, 'j5_thumbpage' );
	     $thumbpage=$thumbpage_att[0];
	     update_post_meta($post_id, 'thumbpage',sanitize_text_field($thumbpage));  	   
	   }
   }
  
 
 } 

function nfb_flipbook_metabox($post) {
	
     //image as page	
	 $imagepage=get_post_meta($post->ID,'imagepage',true);
	 
	 //image as thumb
	 //$thumbpage=get_post_meta($post->ID,'thumbpage',true);
	 
	 //AUTOMATIC SHOW THUMB
	 //get thumb automatic 'j5_thumbpage'
	 //$image_id=nfb_get_attachment_id_from_url($imagepage);
	 //$thumbpage_att=wp_get_attachment_image_src( $image_id, 'j5_thumbpage' );
	 //$thumbpage=$thumbpage_att[0];
	 
	 //image as thumb
	 if( strlen ( get_post_meta($post->ID,'thumbpage',true) ) >0 ){
		  $thumbpage=get_post_meta($post->ID,'thumbpage',true);		 
	 }else{
		  //$thumbpage=$thumbpage_att[0];
	 }
	 ///end automatic thumb
	 
	 
	$slug=nfb_get_category( get_the_ID() )->slug;
	$config=nfb_get_settings_category($slug);
	
?>

<!-- image as page -->
     <div class="fb5-box-admin">
 	 <li>
            <label for="imagepage"><h4>Image for page ( default size -  width: 550 px , height: 800 px )</h4></label>
            <input type="text" name="imagepage" id="imagepage" size="3" style="width:200px;" value="<?php echo $imagepage ?>">
            <input type="button" id="upload_imagepage" value="Browse" size="3" style="width:60px;" /><br />
             <span class="description">Default size image for page you can change in "Nature Book / Books" - and then choose Book category. In each category there is a input field "Page width" and "Page height". If you choose Double Page = true - then the page width must be 2 * width.
If the page size is 550x800 then double page must have a dimension of 1100x800. <strong>After selecting the photo, press the button Publish/Update.</strong></span><br />
            <img style="max-width:100%;height:auto" src="<?php echo  $imagepage ?>" alt=""/><br />
     </li>  
     
     
   
   
   
<?php 

  // if( strlen($imagepage) > 0 ){
	   
?>	      
     
   <!-- image as thumb page -->
 	 <li>
            <label for="thumbpage"><h4>Image for thumbs list ( max height 228 px )</h4></label>
            
            <input type="text" name="thumbpage" id="thumbpage" size="3" style="width:200px;" value="<?php echo $thumbpage ?>">
            <input type="button" id="upload_thumbpage" value="Browse" size="3" style="width:60px;" /><br />
            <span class="description">Thumbs creates automatically if you add the picture above ( image for page ). You can also manually add the thumbs here. <strong>After selecting the photo, press the button Publish/Update.</strong></span><br />
			<img style="max-width:100%;height:auto" src="<?php echo $thumbpage  ?>" alt=""/>
            
          
			
			
     </li> 
     
     </div>      
     
 <?php 
  // }
?>   
     

<?php	



}


/*       METABOX - ATTRIBUTES
/////////////////////////////////////
/*/

function nfb_flipbook_page_attributes($post){
	
	 //title page
	 $title_page=get_post_meta($post->ID,'titlePage',true);
	 if( !$title_page ){
		 $title_page='';
	 }
	 
	 //double page
	 $double_page=get_post_meta($post->ID,'double_page',true);
	 if(!$double_page){
		$double_page= 'false';
	 }
	 	 	 
	 //visible number page
	 $visibleNumber=get_post_meta($post->ID,'visibleNumber',true);
	 if( ! $visibleNumber ){
		  $visibleNumber='true';
     };
	 
	 
	  // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'flipbook_noncename' );
	
?>	
     <div class="fb5-box-admin">
     <li>  
   		<label for="titlePage"><h4>Title Page</h4></label> 
     	<input type="text" size="30" style="width:300px" name="titlePage" id="titlePage" value="<?php echo $title_page ?>"><br />
        <span class="description">The title appears at the bottom of the page (at page number). If you wish to disable title - leave this field empty.</span>
     </li>      

	 <li>  
   		<label for="double_page"><h4>Double Page</h4></label> 
        <input type="radio" name="double_page" id="double_page" value="true" <?php checked( $double_page, 'true' ); ?>>  true
    	<input type="radio" name="double_page" id="double_page" value="false" <?php checked( $double_page, 'false' ); ?>>  false <br />
        <span class="description">If the page as a double page - then this page width = width * 2
Remember that you can not set a double page for the first and last pages.</span>
        
    	
     </li> 
     
         
      <li>  
         <label><h4>Visible Number Page</h4></label> 
   		 <input type="radio" name="visibleNumber" id="visibleNumber" value="true" <?php checked( $visibleNumber, 'true' ); ?>>  true 
   		 <input type="radio" name="visibleNumber" id="visibleNumber" value="false" <?php checked( $visibleNumber, 'false' ); ?>>  false<br />
         <span class="description">You disbaled and enabled page number - at the bottom of the page.</span>
     </li> 
     </div>

     
<?php 	
}
 
 add_action( 'save_post', 'nfb_save_page_attributes' );
 
 function nfb_save_page_attributes($post_id){
	 	 

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;


    if (  !isset($_POST['flipbook_noncename']) || !wp_verify_nonce( $_POST['flipbook_noncename'], plugin_basename( __FILE__ ) ) ) {
      return;
    }


    if( !current_user_can( 'edit_post',$post_id ) ) return;  

  
	//save title
	if( isset( $_POST['titlePage'] ) ) { 
        update_post_meta($post_id, 'titlePage', sanitize_text_field($_POST['titlePage']));  
	} 
	
	//save double page
	if( isset( $_POST['double_page'] ) ) { 
        update_post_meta($post_id, 'double_page', sanitize_text_field($_POST['double_page']));  
	} 
	
	//save smoothing
	if( isset( $_POST['smoothing'] ) ) { 
        update_post_meta($post_id, 'smoothing', sanitize_text_field($_POST['smoothing']));  
	} 
	
	//save visibleNumber
	if( isset( $_POST['visibleNumber'] ) ) { 
        update_post_meta($post_id, 'visibleNumber', sanitize_text_field($_POST['visibleNumber']));  
	} 
	
	//save visibleShadow
	if( isset( $_POST['visibleShadow'] ) ) { 
        update_post_meta($post_id, 'visibleShadow', sanitize_text_field($_POST['visibleShadow']));  
	} 
	
	
 }



/*   ADD DEFAULT DATA FOR NEW CATEGORY BOOK
///////////////////////////////////////////////////////////////////
/*/

add_action('create_'.NFB_FLIPBOOK_BOOK_TAX,'nfb_create_new_category');
function nfb_create_new_category($id_){
	//add default data
	nfb_add_default_data_for_category(NFB_FLIPBOOK_BOOK_TAX.'__'.$id_);
}
add_action('delete_'.NFB_FLIPBOOK_BOOK_TAX,'nfb_delete_new_category');
function nfb_delete_new_category($id){
	//delete 
	nfb_remove_post_not_term();
	delete_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$id);

}
add_action('edit_'.NFB_FLIPBOOK_BOOK_TAX,'nfb_update_new_category');
function nfb_update_new_category($id){
	//update
    
}

//////////////////////CHANGE ORDER IN POST DYNAMIC 

function nfb_filter_handler( $data , $postarr ) {
	
	$post_id = $postarr['ID'];
	$post_type = $postarr['post_type'];
	$title=$postarr['post_title'];
	
	if($post_type==NFB_FLIPBOOK_POST_TYPE){
	
		$all_posts=nfb_get_all_posts();
		foreach($all_posts as $key=>$value){
			$old=$value;
		}
        
		if(isset($old)){
			if($postarr['menu_order']==0){
			    	$data[ 'menu_order' ] = $old->menu_order+2;
			 }
		}else{
		    if($postarr['menu_order']==0){
			    	$data[ 'menu_order' ] = 1;
			 }	
		}
        //remove white spaces
        $data['post_title'] = preg_replace('/\s/','',$title); 
	}
    return $data;
}
add_filter( 'wp_insert_post_data' , 'nfb_filter_handler' , '99', 2 );


//////add button in window library//////////////////////////

add_filter('get_media_item_args', 'nfb_media_item_args');
function nfb_media_item_args($args) {    
    $args['send'] = true;
    return $args;
}

///////////order WYSWIG on the bottom

function nfb_admin_footer_hook(){
	global $post;
	if ( get_post_type($post) == NFB_FLIPBOOK_POST_TYPE) {
?>
	<script type="text/javascript">
		jQuery('#normal-sortables').insertBefore('#postdivrich');
		jQuery('#titlewrap').append('<p>Deep linking is required. This text appears in the browser address. Example: If you write for page 2 "title-page2" and for the page 3 "title-page3" - when will flip book on page 2-3 shows "title-page2-title-page3" (the titles are combined separator) <br>NOTE: If you enter for the page2 and page3 the same value - then is shown in only one title (titles will NOT be connected)</p>'); 
		//jQuery('#titlediv .inside').remove();
		
	</script>
    
    <style>
		#edit-slug-box{display:none;}
		#titlediv #title { margin-bottom:5px}
		#titlewrap p { margin-top:2px !important  }
    </style>
    
<?php
	}
}
add_action('admin_footer','nfb_admin_footer_hook');


////////////change default title

function nfb_change_title( $title ){
     $current = get_current_screen();
 
     if  ( $current->post_type==NFB_FLIPBOOK_POST_TYPE ) {
          $title = 'deep linking';
     }
 
     return $title;
}
 
add_filter( 'enter_title_here', 'nfb_change_title' );


////add duplicate button
function nfb_custom_rows_for_taxonomy($actions,$tag){
	 $current = get_current_screen();
     if  ( $current->taxonomy == NFB_FLIPBOOK_BOOK_TAX ) {	
			$actions['duplicate'] = "<a href='edit-tags.php?duplicate=".$tag->term_id."&taxonomy=jq_flipbook_v3_tax&post_type=jq_flipbook_v5&tag='>Duplicate</a>";
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['view'] );
			
	 } 
	 
	 return $actions;		 
	 
}
add_filter('tag_row_actions','nfb_custom_rows_for_taxonomy',10, 2);
	

//create duplicate book using php
function nfb_create_duplicate_post($id_,$term_){
	    //$id_ -  id duplicate post

		$post_title=get_post($id_)->post_title;
		$post_content=get_post($id_)->post_content;
						 
		$double_page=get_post_meta($id_,'double_page',true);
		$titlePage=get_post_meta($id_,'titlePage',true);
		$visibleNumber=get_post_meta($id_,'visibleNumber',true);
		$imagepage=get_post_meta($id_,'imagepage',true);
		$thumbpage=get_post_meta($id_,'thumbpage',true);
					
		$new_post = array(
				  'post_status'           => 'publish', 
				  'post_type'             => sNFB_FLIPBOOK_POST_TYPE,
				  'post_author'           => $user_ID,
				  'ping_status'           => get_option('default_ping_status'), 
				  'post_parent'           => 0,
				  'menu_order'            => 0,
				  'to_ping'               =>  '',
				  'pinged'                => '',
				  'post_password'         => '',
				  'guid'                  => '',
				  'post_content_filtered' => '',
				  'post_excerpt'          => '',
				  'import_id'             => 0,
				  'post_title'    => $post_title,
				  'post_content'  => $post_content
		);
		$new_post_id=wp_insert_post($new_post);
		wp_set_object_terms($new_post_id,$term_,NFB_FLIPBOOK_BOOK_TAX );
			 
		add_post_meta($new_post_id,'double_page',$double_page,true);
		add_post_meta($new_post_id,'titlePage',$titlePage,true);
		add_post_meta($new_post_id,'visibleNumber',$visibleNumber,true);
		add_post_meta($new_post_id,'imagepage',$imagepage,true);
		add_post_meta($new_post_id,'thumbpage',$thumbpage,true);
}

function nfb_create_duplicate_book(){
 
      if( $_REQUEST['taxonomy']=='jq_flipbook_v3_tax' && isset ( $_REQUEST['duplicate'] )&&  empty( $_REQUEST['action'] )  ){

			 //OLD TERM
			 $id_old=$_REQUEST['duplicate'];
			 $attr_term_old=get_term_by( 'id',$id_old,NFB_FLIPBOOK_BOOK_TAX );
			 $name_old=$attr_term_old->name;
			 $slug_old=$attr_term_old->slug;
			 $desc_old=$attr_term_old->description;
			 $settings_old=get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$id_old);
							 
			 
			 //LENGTH ALL TERMS
			 $all_terms = get_terms(NFB_FLIPBOOK_BOOK_TAX,"hide_empty=0&search=$slug_old");
			 $index_copy = count($all_terms);
			 if( $index_copy<=1 ){ $index_copy=''; }
			 
	
			 //CREATE DUPLICATE TERM
			 $obj=wp_insert_term(
				  $name_old.'- copy'.$index_copy,              // name term 
				  NFB_FLIPBOOK_BOOK_TAX, // the taxonomy
				  array(
					'description'=> $desc_old.' - copy'.$index_copy,
					'slug' => $slug_old.' - copy'.$index_copy,
					'parent'=> 'none'
				  )
				);
				
			 $id_new=$obj['term_id'];	//id new term
			 update_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$id_new,$settings_old);
			 
			 
			 //CREATE DUPLICATE POSTS
			 $posts_old=nfb_get_posts_from_category_id($id_old);
			 while ( $posts_old->have_posts() ) {
						 $posts_old->the_post();					 
						 $_post=$posts_old->post;
						 $_id=$_post->ID;		 
						 nfb_create_duplicate_post($_id,$id_new);
			 }
			 wp_reset_postdata();
    }
}


add_action('admin_head', 'nfb_create_duplicate_book');



	
function nfb_wpb_imagelink_setup() {

	    $image_set = get_option( 'image_default_link_type' );
        update_option('image_default_link_type', 'file');
}

add_action('admin_init', 'nfb_wpb_imagelink_setup', 10);	
	
	
	
	
	
	
	
	



?>