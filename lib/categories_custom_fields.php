<?php 


///get default data
/*
$term_id=$_REQUEST['tag_ID'];
$def_config= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id);
foreach ( $def_config as $key=>$value ){
  echo "'".$key."'=>'".$value."',<br>"; 	
}
///end get default data
/*/




// Change redirect set in upload.php
function nfb_redirect_addres($location, $status) {
	
 
	 if( is_admin() && isset ($_REQUEST['taxonomy']) && $_REQUEST['tag_ID'] ){ 
    	 if($_REQUEST['taxonomy']==NFB_FLIPBOOK_BOOK_TAX){
		 	 $tab=get_option('nfb_tab');
			 $location = add_query_arg(array('tag_ID' => $_REQUEST['tag_ID'],'message'=>false,'action'=>'edit','tab'=> $tab ), $location);
	 	 }
	 }
   
    return $location;
}
add_filter('wp_redirect', 'nfb_redirect_addres',100, 2);



///save
add_action( 'edited_'.NFB_FLIPBOOK_BOOK_TAX, 'nfb_save_custom_category_fields');
function nfb_save_custom_category_fields($id){
	  	  
	 		  
	 
	 		  
	  $cat = get_term($id,NFB_FLIPBOOK_BOOK_TAX);
	  $slug=$cat->slug;  	
	
	  if ( isset( $_POST['books_atr'] ) ) {
   		$data_form= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$id); ///type array
		
		//add new data to $data_form
		foreach( $_POST['books_atr'] as $key=>$value ){
	  	    $data_form[$key] = ($value);			
		}

		///for check box manual add
		$current_tab=get_option('nfb_tab');
		if(!isset( $_POST['books_atr']['REVERSE_BOOK'] ) && $current_tab == 'general' ){
				$data_form['REVERSE_BOOK']='false';
		 }
		 if(!isset( $_POST['books_atr']['LOAD_ALL_PAGES'] ) && $current_tab == 'general' ){
				$data_form['LOAD_ALL_PAGES']='false';
		 }
		 if(!isset( $_POST['books_atr']['TOOLS_BAR_VISIBLE'] ) && $current_tab == 'translate' ){
				$data_form['TOOLS_BAR_VISIBLE']='false';
				$data_form['desc_book']= stripslashes ( wpautop( $_REQUEST['editor_desc_book'] ));
		 }
		 if( $data_form['rtl']=='true' ){
			 $data_form['deeplinking_enabled']='true'; 
		 }
		
		 
		//save
        update_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$id,$data_form);
	
    }
	
	
}

//read
add_action (NFB_FLIPBOOK_BOOK_TAX.'_edit_form_fields','nfb_custom_category_fields');
function nfb_setValue($value_,$default_=''){
	if($value_){
		return $value_;
	}else{
		return '';//$default_;
	}
}

//////////////////////////show custom fields in admin

function nfb_custom_category_fields( $tag ) {   
     $slug=$tag->slug;  //cat slug
	 $term_id = $tag->term_id;
	 $data_form= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id); ///type array

	 //tabs list
	 $list_tabs=array( 'general'=>'General','on_off'=>'On / Off','translate'=>'Translate','typography'=>'Typography');
	
	 

     if ( isset ( $_GET['tab'] ) ) {
		 $tab = $_GET['tab'];
	 }else{
		 $tab = 'general';
	 }
	 
	 update_option('nfb_tab',$tab);
	 
?>


<!-- TABS LIST -->
<tr class="form-field">
<td colspan="2">
<h2 class="nav-tab-wrapper" style="margin-bottom:30px">
<?php
     foreach ( $list_tabs as $key=>$value){
	 $select_tab = ( $tab == $key ) ? ' nav-tab-active' : ''; 
		 $new_url=add_query_arg( 'tab',$key);
		 echo "<a class='nav-tab$select_tab' href='$new_url'>$value</a>";
	 }
?>
</h2>
</td>
</tr>





<?php
 switch ( $tab ){
   case 'general' :
?>


<!-- GENERAL -->
<tr class="form-field"></tr>


<!-- page width -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="page_width">Page width</label></th>
        <td>
            <input type="text" name="books_atr[page_width]" id="books_atr[page_width]" size="3" style="width:50px;" value="<?php echo nfb_setValue($data_form['page_width'],'550') ?>"><br />
            <span class="description">page width for FlipBook</span>
        </td>
    </tr>
    
<!-- page height -->

    <tr class="form-field">
        <th scope="row" valign="top"><label for="page_height">Page height</label></th>
        <td>
            <input type="text" name="books_atr[page_height]" id="books_atr[page_height]" size="3" style="width:50px;" value="<?php echo nfb_setValue($data_form['page_height'],'715') ?>"><br />
            <span class="description">page height for FlipBook</span>
        </td>
    </tr>
    
    

    

    
    
       
   

  
    

    
      
       
       
    <!-- back buitton -->

    <tr class="form-field">
        <th scope="row" valign="top"><label for="back_button">Redirect for back button</label></th>
        <td>
            <input type="text" name="books_atr[back_button]" id="email_form" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['back_button'],'') ?>"><br />
            <span class="description">url address</span>
        </td>
    </tr>   
    
    
    
   
    
    <!-- zoom double click -->

    <tr class="form-field">
        <th scope="row" valign="top"><label for="zoom_double_click">Zoom for double click</label></th>
        <td>
            <input type="text" name="books_atr[zoom_double_click]" id="books_atr[zoom_double_click]" size="3" style="width:50px;" value="<?php echo nfb_setValue($data_form['zoom_double_click'],'715') ?>"><br />
            <span class="description">scale flipbook for double click ( if value=1 then original size ) </span>
        </td>
    </tr>  
    
    
     <!-- zoom step -->

    <tr class="form-field">
        <th scope="row" valign="top"><label for="zoom_step">Zoom step</label></th>
        <td>
            <input type="text" name="books_atr[zoom_step]" id="books_atr[zoom_step]" size="3" style="width:50px;" value="<?php echo nfb_setValue($data_form['zoom_step'],'715') ?>"><br />
            <span class="description">change the zoom when zoomIn and zoomOut ( only even numbers - recommended value is 0.06  )</span>
        </td>
    </tr>  
    
    
   <!-- radius for page -->

    <tr class="form-field">
        <th scope="row" valign="top"><label for="zoom_step">Radius page</label></th>
        <td>
            <input type="text" name="books_atr[radius_page]" id="books_atr[radius_page]" size="3" style="width:50px;" value="<?php echo nfb_setValue($data_form['radius_page'],'715') ?>"><br />
            <span class="description">radius for corner page</span>
        </td>
    </tr>  
    
    
  
    
    

    
    
    
    
    
   
 
 
 
  <?php
      break;
      case 'color' :
  ?>
  
  
  
    
    
   
    
 
 
  <?php
      break;
      case 'on_off' :
  ?>
  
  
   <!--ICONS -->
    <tr>
      <th scope="row" valign="top" colspan="2"><h3 class="nfb">Nawigation menu</h3></th>
   </tr>  
   
   
   <!-- toolbar --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="toolbar_visible">Toolbar visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[toolbar_visible]" id="books_atr[toolbar_visible]" value="true" <?php checked( $data_form['toolbar_visible'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[toolbar_visible]" id="books_atr[toolbar_visible]" value="false" <?php checked( $data_form['toolbar_visible'], 'false' ); ?>>  false 
        </td>
    </tr>    
    
   
   <!-- tool tip --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="tooltip_visible">Tooltip visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[tooltip_visible]" id="books_atr[tooltip_visible]" value="true" <?php checked( $data_form['tooltip_visible'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[tooltip_visible]" id="books_atr[tooltip_visible]" value="false" <?php checked( $data_form['tooltip_visible'], 'false' ); ?>>  false 
        </td>
    </tr>  
      
   

    
   
   <!-- icon zoom in --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_zoom_in">Icon ZoomIn visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_zoom_in]" id="books_atr[icon_zoom_in]" value="true" <?php checked( $data_form['icon_zoom_in'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_zoom_in]" id="books_atr[icon_zoom_in]" value="false" <?php checked( $data_form['icon_zoom_in'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    
   <!-- icon zoom out --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_zoom_out">Icon ZoomOut visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_zoom_out]" id="books_atr[icon_zoom_out]" value="true" <?php checked( $data_form['icon_zoom_out'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_zoom_out]" id="books_atr[icon_zoom_out]" value="false" <?php checked( $data_form['icon_zoom_out'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    <!-- icon zoom auto --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_zoom_auto">Icon ZoomAuto visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_zoom_auto]" id="books_atr[icon_zoom_auto]" value="true" <?php checked( $data_form['icon_zoom_auto'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_zoom_auto]" id="books_atr[icon_zoom_auto]" value="false" <?php checked( $data_form['icon_zoom_auto'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
     <!-- icon zoom original --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_zoom_original">Icon ZoomOriginal visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_zoom_original]" id="books_atr[icon_zoom_original]" value="true" <?php checked( $data_form['icon_zoom_original'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_zoom_original]" id="books_atr[icon_zoom_original]" value="false" <?php checked( $data_form['icon_zoom_original'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    <!-- icon zoom all pages --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_allpages">Icon AllPages visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_allpages]" id="books_atr[icon_allpages]" value="true" <?php checked( $data_form['icon_allpages'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_allpages]" id="books_atr[icon_allpages]" value="false" <?php checked( $data_form['icon_allpages'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    
   <!-- icon home --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_home">Icon Home visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_home]" id="books_atr[icon_home]" value="true" <?php checked( $data_form['icon_home'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_home]" id="books_atr[icon_home]" value="false" <?php checked( $data_form['icon_home'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    
  
    
    

    
    
  
    
    
   <!-- full screen visible --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="icon_fullscreen">Icon Full Screen visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[icon_fullscreen]" id="books_atr[icon_fullscreen]" value="true" <?php checked( $data_form['icon_fullscreen'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[icon_fullscreen]" id="books_atr[icon_fullscreen]" value="false" <?php checked( $data_form['icon_fullscreen'], 'false' ); ?>>  false 
        </td>
    </tr>  
    
    
   
          
          
     <!--Other on / off -->
    <tr>
      <th scope="row" valign="top" colspan="2"><h3 class="nfb">Other</h3></th>
   </tr>   
   
   
      
    
    
   
    <!-- title - deeplinking --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="deeplinking_enabled">Deep linking enabled</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[deeplinking_enabled]" id="books_atr[deeplinking_enabled]" value="true" <?php checked( $data_form['deeplinking_enabled'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[deeplinking_enabled]" id="books_atr[deeplinking_enabled]" value="false" <?php checked( $data_form['deeplinking_enabled'], 'false' ); ?>>  false 
        </td>
    </tr>     
      
   
    <!-- zoom double click enabled --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="double_click_enabled">Zoom double click enabled</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[double_click_enabled]" id="books_atr[double_click_enabled]" value="true" <?php checked( $data_form['double_click_enabled'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[double_click_enabled]" id="books_atr[double_click_enabled]" value="false" <?php checked( $data_form['double_click_enabled'], 'false' ); ?>>  false 
        </td>
    </tr>     
    
    <!-- Arrow visible --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="arrows_visible">Arrows visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[arrows_visible]" id="books_atr[arrows_visible]" value="true" <?php checked( $data_form['arrows_visible'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[arrows_visible]" id="books_atr[arrows_visible]" value="false" <?php checked( $data_form['arrows_visible'], 'false' ); ?>>  false 
        </td>
    </tr>   
    
     <!-- preloader visible --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="preloader_visible">Preloader visible</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[preloader_visible]" id="books_atr[preloader_visible]" value="true" <?php checked( $data_form['preloader_visible'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[preloader_visible]" id="books_atr[preloader_visible]" value="false" <?php checked( $data_form['preloader_visible'], 'false' ); ?>>  false 
        </td>
    </tr> 
    
     <!-- RTL --> 
   <tr class="form-field">
        <th scope="row" valign="top"><label for="rtl">Right To Left for book</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[rtl]" id="books_atr[rtl]" value="true" <?php checked( $data_form['rtl'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[rtl]" id="books_atr[rtl]" value="false" <?php checked( $data_form['rtl'], 'false' ); ?>>  false 
        </td>
    </tr> 
    
        <!-- viewport -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="viewport">Viewport for mobile devices</label></th>
        <td>
        <input style="width:20px;" type="radio" name="books_atr[viewport]" id="books_atr[viewport]" value="true" <?php checked( $data_form['viewport'], 'true' ); ?>>  true
    	<input style="width:20px;" type="radio" name="books_atr[viewport]" id="books_atr[viewport]" value="false" <?php checked( $data_form['viewport'], 'false' ); ?>>  false <br />
        <span class="description">viewport for mobile devices - only for template (not applicable shortcode)</span>
        </td>
    </tr>    
    
    
    
   
    
    
        
  <?php
      break;
      case 'translate' :
  ?>        
           
            

        
<tr>
  <th scope="row" valign="top" colspan="2"><h3 class="nfb">TolTip for Icon</h3></th>
</tr> 

<!-- tool download tooltip-->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_download">Icon Download</label></th>
        <td>
            <input type="text" name="books_atr[tool_download]" id="tool_download" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_download'],'DOWNLOAD ALL PAGES(.ZIP)') ?>"><br />
            <span class="description">Tool Tip for icon Download</span>
        </td>
    </tr>   
    
    
 
    
<!-- tool zoomIn -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_zoom_in">Icon ZoomIn</label></th>
        <td>
            <input type="text" name="books_atr[tool_zoom_in]" id="tool_zoom_in" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_zoom_in'],'ZOOM IN') ?>"><br />
            <span class="description">Tool Tip for icon ZoomIn</span>
        </td>
    </tr>         
 
<!-- tool zoomOut -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_zoom_out">Icon ZoomOut</label></th>
        <td>
            <input type="text" name="books_atr[tool_zoom_out]" id="tool_zoom_out" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_zoom_out'],'ZOOM OUT') ?>"><br />
            <span class="description">Tool Tip for icon ZoomOut</span>
        </td>
    </tr>            
     
<!-- tool zoomAuto -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_zoom_auto">Icon ZoomAuto</label></th>
        <td>
            <input type="text" name="books_atr[tool_zoom_auto]" id="tool_zoom_auto" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_zoom_auto'],'ZOOM AUTO') ?>"><br />
            <span class="description">Tool Tip for icon ZoomAuto</span>
        </td>
    </tr>       
    
<!-- tool zoomOriginal -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_zoom_original">Icon ZoomOriginal</label></th>
        <td>
            <input type="text" name="books_atr[tool_zoom_original]" id="tool_zoom_original" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_zoom_original'],'ZOOM ORIGINAL (SCALE 1:1)') ?>"><br />
            <span class="description">Tool Tip for icon ZoomAuto</span>
        </td>
    </tr>          
    
<!-- tool listPages -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_list_page">Icon List Page</label></th>
        <td>
            <input type="text" name="books_atr[tool_list_page]" id="tool_list_page" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_list_page'],'SHOW ALL PAGES') ?>"><br />
            <span class="description">Tool Tip for icon ListPage</span>
        </td>
    </tr>                    
    
<!-- tool Home -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_home">Icon Home</label></th>
        <td>
            <input type="text" name="books_atr[tool_home]" id="tool_home" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_home'],'SHOW HOME PAGE') ?>"><br />
            <span class="description">Tool Tip for icon Home</span>
        </td>
    </tr>    
    
 <!-- send message -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_message">Icon Send Message</label></th>
        <td>
            <input type="text" name="books_atr[tool_message]" id="tool_message" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_message'],'SHOW HOME PAGE') ?>"><br />
            <span class="description">Tool Tip for icon Message</span>
        </td>
    </tr>  
    
    
   <!-- icon fullscreen -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="tool_fullscreen">Icon Full Screen</label></th>
        <td>
            <input type="text" name="books_atr[tool_fullscreen]" id="tool_fullscreen" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['tool_fullscreen'],'SHOW HOME PAGE') ?>"><br />
            <span class="description">Tool Tip for icon FullScreen</span>
        </td>
    </tr>        
    
 
<!-- Form -->  
        
<tr>
  <th scope="row" valign="top" colspan="2"><h3 class="nfb">Form</h3></th>
</tr> 
 
   
   
    <!-- title form  -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="title_contact">Title Form</label></th>
        <td>
            <input type="text" name="books_atr[title_contact]" id="go" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['title_contact'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>  
    
      <!-- name -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="form_name">name</label></th>
        <td>
            <input type="text" name="books_atr[form_name]" id="form_name" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['form_name'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>   
    
          <!-- email-->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="form_email">e-mail</label></th>
        <td>
            <input type="text" name="books_atr[form_email]" id="form_email" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['form_email'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>
    
    
              <!-- message-->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="form_message">message</label></th>
        <td>
            <input type="text" name="books_atr[form_message]" id="form_message" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['form_message'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr> 
    
     <!-- button send-->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="button_send">button send</label></th>
        <td>
            <input type="text" name="books_atr[button_send]" id="button_send" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['button_send'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>   
    
     <!-- Message after sending -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="info_after_sending">Message after sending</label></th>
        <td>
            <textarea name="books_atr[info_after_sending]" id="info_after_sending" size="3" rows="5" style="width:400px;"><?php echo nfb_setValue(stripslashes($data_form['info_after_sending'])) ?></textarea><br />
            <span class="description">Possible format:<xmp><p></p> <h1></h1></xmp></span>
        </td>
    </tr>   
    
    
         
    
    
<tr>
  <th scope="row" valign="top" colspan="2"><h3 class="nfb">Left side of the book</h3></th>
</tr>     
    
   
    
    <!-- description on home page -->   
    <tr>
        <th scope="row" valign="top"><label for="desc_book">Description on the left side of the book</label></th>
        <td>
            <?php 
			
			 $content = $data_form['desc_book'];
			 $editor_id ='editor_desc_book';
			 wp_editor( $content, $editor_id,array('wpautop'=>true) );
			
			 ?>
             <br />
            <span class="description"></span>
        </td>
    </tr> 
 
 
 
<!-- page manager -->  
        
<tr>
  <th scope="row" valign="top" colspan="2"><h3 class="nfb">Page manager</h3></th>
</tr> 


    
    <!-- go to page  -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="go_to_page">GO TO PAGE</label></th>
        <td>
            <input type="text" name="books_atr[go_to_page]" id="go" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['go_to_page'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>  
    
    <!-- GO  -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="go">GO</label></th>
        <td>
            <input type="text" name="books_atr[go]" id="go_to_page" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['go'],'0xFFFFFF') ?>"><br />
            <span class="description"></span>
        </td>
    </tr> 
    
    
 <!-- other -->  

<tr>
  <th scope="row" valign="top" colspan="2"><h3 class="nfb">Other</h3></th>
</tr>

 <!-- back button   -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="label_back_button">back button</label></th>
        <td>
            <input type="text" name="books_atr[label_back_button]" id="go" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['label_back_button'],'') ?>"><br />
            <span class="description"></span>
        </td>
    </tr>
    
<!-- separator deep linking   -->
    <tr class="form-field">
        <th scope="row" valign="top"><label for="label_back_button">Separator deeplinking</label></th>
        <td>
            <input type="text" name="books_atr[sep_deeplinking]" id="go" size="3" style="width:400px;" value="<?php echo nfb_setValue($data_form['sep_deeplinking'],'') ?>"><br />
            <span class="description">separator for deeplinking</span>
        </td>
    </tr>
   
   
    



  <?php
      break;
      case 'image' :
  ?>        
      

  
<!-- tool download zip -->

    

   
    
    <!-- logo -->

 
  
    
    
  
    
    
  
    
    
         

  <?php
      break;
      case 'typography' :
  ?>        
  
  
   <tr>
    <th colspan="2" valign="top"><h3 class="nfb">WYSIWYG style ( page in flipbook )</h3></th>
    </tr>
  
  
  <!-- paragraph -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb" style="border-top:none">Paragraph < p ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_paragraph">Size</label></th>
        <td>
            <input name="books_atr[page_size_paragraph]" id="page_size_paragraph" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_paragraph'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for paragraph</span>
        </td>
    </tr>  
   <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_font_paragraph">Font</label></th>
        <td>
            <input name="books_atr[page_font_paragraph]" id="page_size_paragraph" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_paragraph'],'0x64c8d3') ?>"><br />
            <span class="description">font face for paragraph</span>
        </td>
    </tr>  
    
    
    
  <!-- list li -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">List < li ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_li">Size</label></th>
        <td>
            <input name="books_atr[page_size_li]" id="page_size_li" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_li'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for list </span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_font_li">Font</label></th>
        <td>
            <input name="books_atr[page_font_li]" id="page_font_li" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_li'],'0x64c8d3') ?>"><br />
            <span class="description">font face for list</span>
        </td>
    </tr>  
      
       
    
  <!-- Heading 1 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 1 < h1 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h1">Size</label></th>
        <td>
            <input name="books_atr[page_size_h1]" id="page_size_h1" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h1'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h1</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_fonth1">Font</label></th>
        <td>
            <input name="books_atr[page_font_h1]" id="page_font_h1" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h1'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h1</span>
        </td>
    </tr> 
    
    
    
  <!-- Heading 2 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 2 < h2 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h2">Size</label></th>
        <td>
            <input name="books_atr[page_size_h2]" id="page_size_h2" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h2'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h2</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_fonth2">Font</label></th>
        <td>
            <input name="books_atr[page_font_h2]" id="page_font_h2" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h2'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h2</span>
        </td>
    </tr> 
    
    
    
   <!-- Heading 3 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 3 < h3 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h3">Size</label></th>
        <td>
            <input name="books_atr[page_size_h3]" id="page_size_h2" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h3'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h3</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_fonth3">Font</label></th>
        <td>
            <input name="books_atr[page_font_h3]" id="page_font_h2" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h3'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h3</span>
        </td>
    </tr> 
   
   
   
   <!-- Heading 4 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 4 < h4 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h4">Size</label></th>
        <td>
            <input name="books_atr[page_size_h4]" id="page_size_h4" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h4'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h4</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_font_h4">Font</label></th>
        <td>
            <input name="books_atr[page_font_h4]" id="page_font_h2" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h4'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h4</span>
        </td>
    </tr> 
    
    
    
   <!-- Heading 5 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 5 < h5 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h5">Size</label></th>
        <td>
            <input name="books_atr[page_size_h5]" id="page_size_h5" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h5'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h5</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_font_h5">Font</label></th>
        <td>
            <input name="books_atr[page_font_h5]" id="page_font_h5" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h5'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h5s</span>
        </td>
    </tr> 
    
    
    
   <!-- Heading 6 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading 6 < h6 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_size_h6">Size</label></th>
        <td>
            <input name="books_atr[page_size_h6]" id="page_size_h6" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['page_size_h6'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h6</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="page_font_h6">Font</label></th>
        <td>
            <input name="books_atr[page_font_h6]" id="page_font_h6" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['page_font_h6'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h6</span>
        </td>
    </tr> 
    
    
    <!-- typography for about-->
     <tr>
    <th colspan="2" valign="top"><h3 class="nfb">WYSIWYG style ( the left side of the book )</h3></th>
    </tr>
    
    <!-- paragraph -->
   <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb" style="border-top:none">Paragraph < p ></h3></th>
   </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_paragraph">Size</label></th>
        <td>
            <input name="books_atr[about_size_paragraph]" id="about_size_paragraph" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_paragraph'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for paragraph</span>
        </td>
    </tr>  
   <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_font_paragraph">Font</label></th>
        <td>
            <input name="books_atr[about_font_paragraph]" id="about_font_paragraph" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_paragraph'],'0x64c8d3') ?>"><br />
            <span class="description">font face for paragraph</span>
        </td>
    </tr> 
    
    
    
  
    
    
     <!-- Heading 1 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading < h1 ></h3></th>
  </tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h1">Size</label></th>
        <td>
            <input name="books_atr[about_size_h1]" id="about_size_h1" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h1'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h1</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth1">Font</label></th>
        <td>
            <input name="books_atr[about_font_h1]" id="about_font_h1" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h1'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h1</span>
        </td>
    </tr>  
    
    
    
    
  <!-- Heading 2 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading  < h2 ></h3></th
  ></tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h2">Size</label></th>
        <td>
            <input name="books_atr[about_size_h2]" id="about_size_h2" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h2'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h2</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth2">Font</label></th>
        <td>
            <input name="books_atr[about_font_h2]" id="about_font_h2" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h2'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h2</span>
        </td>
    </tr> 
    
    
    
  <!-- Heading 3 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading  < h3 ></h3></th
  ></tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h3">Size</label></th>
        <td>
            <input name="books_atr[about_size_h3]" id="about_size_h3" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h3'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h3</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth3">Font</label></th>
        <td>
            <input name="books_atr[about_font_h3]" id="about_font_h3" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h3'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h3</span>
        </td>
    </tr>   
    
    
    
    <!-- Heading 4 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading  < h4 ></h3></th
  ></tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h4">Size</label></th>
        <td>
            <input name="books_atr[about_size_h4]" id="about_size_h4" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h4'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h3</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth4">Font</label></th>
        <td>
            <input name="books_atr[about_font_h4]" id="about_font_h4" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h4'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h4</span>
        </td>
    </tr>   
    
    
  <!-- Heading 5 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading  < h5 ></h3></th
  ></tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h5">Size</label></th>
        <td>
            <input name="books_atr[about_size_h5]" id="about_size_h5" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h5'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h5</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth5">Font</label></th>
        <td>
            <input name="books_atr[about_font_h5]" id="about_font_h4" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h5'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h5</span>
        </td>
    </tr>   
    
    
    <!-- Heading 6 -->
  <tr>
    <th scope="row" valign="top" colspan="2"><h4 class="nfb">Heading  < h6 ></h3></th
  ></tr>
  
   <!-- size -->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_size_h6">Size</label></th>
        <td>
            <input name="books_atr[about_size_h6]" id="about_size_h6" size="3" style="width:35px;" value="<?php echo nfb_setValue($data_form['about_size_h6'],'0x64c8d3') ?>"> px<br />
            <span class="description">font size for h5</span>
        </td>
    </tr>  
    
     <!-- font-->
   <tr class="form-field">
        <th scope="row" valign="top"><label for="about_fonth6">Font</label></th>
        <td>
            <input name="books_atr[about_font_h6]" id="about_font_h6" size="3" style="width:150px;" value="<?php echo nfb_setValue($data_form['about_font_h6'],'0x64c8d3') ?>"><br />
            <span class="description">font face for h6</span>
        </td>
    </tr>   
  
<?php

      break;
      case 'create_from_pdf' :
?>	  
   
 
   
    
    
    
    <?php

      break;
      case 'create_from_images' :
?>	

    
   
    
    
	  
	  
 
<?php
 }
 
 
 
    
       
 
 
 ?>
 

 
 <?php
 
 

}



///////////////////////////////////////////DEFAULT VALUE FOR get_option //////////////////////////////////

add_action('init', 'nfb_add_default_options');
function nfb_add_default_options() {
	  
	  $obj=get_term_by( 'slug','book1',NFB_FLIPBOOK_BOOK_TAX );
	  
	  //delete_option(NFB_FLIPBOOK_BOOK_TAX.'__3');

	  if(  $obj != false   ){
	 	///$term_id=$obj->term_id;
	  //	nfb_add_default_data_for_category(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id);
	  }

}


//////////////////////////////////////////////////////////////////////////////////////////////////////////

?>