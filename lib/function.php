<?php 


///////////////GET DEFAULT DATA DOR CATEGORY BOOK

function nfb_add_default_data_for_category($option_name_){
	
///length all terms in taxonomy
$terms = get_terms(NFB_FLIPBOOK_BOOK_TAX,'hide_empty=0');
$count = count($terms);
   	
	
$default_data=array(
	
//GENERAL
'page_width'=>'550',
'page_height'=>'800',
'bcg_type'=>'file',
'gotopage_width'=>'30',
'logo_redirect'=>'http://codecanyon.net/user/flashmaniac?ref=flashmaniac',
'email_form'=>'your_email@domain.com',
'back_button'=>'http://codecanyon.net/user/flashmaniac/portfolio?ref=flashmaniac',
'zoom_double_click'=>'1',
'zoom_step'=>'0.06',
'viewport'=>'true',
'toolbar_visible'=>'true',
'tooltip_visible'=>'true',
'icon_download_visible'=>'false',
'icon_zoom_in'=>'true',
'icon_zoom_out'=>'true',
'icon_zoom_auto'=>'true',
'icon_zoom_original'=>'true',
'icon_allpages'=>'true',
'icon_home'=>'true',
'icon_page_manager'=>'true',
'icon_form'=>'false',
'icon_fullscreen'=>'true',
'deeplinking_enabled'=>'true',
'lazy_loading_pages'=>'false',
'lazy_loading_thumbs'=>'false',
'double_click_enabled'=>'true',
'arrows_visible'=>'true',
'preloader_visible'=>'true',
'rtl'=>'false',
'tool_download'=>'pdf file or zip',
'tool_zoom_in'=>'zoom in',
'tool_zoom_out'=>'zoom out',
'tool_zoom_auto'=>'zoom auto',
'tool_zoom_original'=>'zoom original ( scale 1:1 )',
'tool_list_page'=>'show all pages',
'tool_home'=>'home page',
'tool_message'=>'send message',
'tool_fullscreen'=>'full / normal screen',
'title_contact'=>'Contact Form',
'form_name'=>'name...',
'form_email'=>'email...',
'form_message'=>'message...',
'button_send'=>'SEND MESSAGE',
'info_after_sending'=>"<h1>Thanks for your email</h1>
<p>Lorem ipsum dolor sit amet, vel ad sint fugit, velit nostro pertinax ex qui, no ceteros civibus explicari est. Eleifend electram ea mea, omittam reprehendunt nam at. Putant argumentum cum ex. At soluta principes dissentias nam, elit voluptatum vel ex.</p>",


'desc_book'=>"<h3><span class='circle'>1</span>How to read a book ?</h3>
<p>Nulla congue pulvinar pharetra.  Nullam <a href='setPage(2)'>setPage(2) </a>sed malesuada arcu. Duis eleifend nunc laoreet odio dapibus ac convallis sapien ornare. Nullam a est id diam elementum rhoncus.</p>

&nbsp;
<h3><span class='circle'>2</span>Short description</h3>
<p>In a augue sed neque ullamcorper euismod non vel nibh. Quisque nec risus massa, bibendum interdum ante. <a href=\"youtube('48I0IHmsuOE','560','315')\">Video</a> venenatis, eros ac suscipit porttitor, dolor nulla pellentesque velit, laoreet cursus libero enim sed odio. Cum sociis natoque penatibus.</p>

&nbsp;
<h3><span class='circle'>3</span>Start reading!</h3>
<p>Nulla congue pulvinar pharetra. Cras sed malesuada arcu. Duis eleifend nunc laoreet odio dapibus ac convallis sapien ornare. Nullam a est id diam elementum rhoncus.</p>

&nbsp",






'go_to_page'=>'Page',
'go'=>'Go',
'loading'=>'loading...',
'label_back_button'=>'< BACK ',
'sep_deeplinking'=>'-',
'tools_bcg_bar'=>'#FF0000',
'opacity_bcg_bar'=>'0',
'tooltip_bcg_color'=>'#1086D9',
'tooltip_text_color'=>'#FFFFFF',
'color_label_gotopage'=>'#558AEC',
'color_label_go'=>'#FFFFFF',
'color_bcg_go'=>'#1086D9',
'color_bcg_go2'=>'#1086D9',
'input_color_bcg'=>'#071D3F',
'input_color_border'=>'#061733',
'color_bcg_page'=>'#FFFFFF',
'color_number_page'=>'#666666',
'color_title_page'=>'#666666',
'listthumbs_bcg'=>'#0C2345',
'listthumbs_shadow'=>'#39A3F0',
'form_bcg'=>'#14346C',
'form_color_title'=>'#FFFFFF',
'form_color_btn_bcg'=>'#1086D9',
'form_color_btn_text'=>'#FFFFFF',
'form_color_input'=>'#2A519A',
'form_color_close_text'=>'#FFFFFF',
'form_color_close_bcg'=>'#14346C',
'form_color_shadow'=>'#39A3F0',
'form_color_after_sending_p'=>'#FFFFFF',
'form_color_after_sending_h'=>'#FFFFFF',
'loader_color_bcg'=>'#1086D9',
'page_color_p'=>'#77797F',
'page_color_a'=>'#1086D9',
'page_color_h1'=>'#77797F',
'page_color_h2'=>'#77797F',
'page_color_h3'=>'#77797F',
'page_color_h4'=>'#77797F',
'page_color_h5'=>'#77797F',
'page_color_h6'=>'#77797F',
'page_color_li'=>'#77797F',
'page_color_alist'=>'#77797F',
'about_color_p'=>'#2A519A',
'about_color_h1'=>'#1086D9',
'about_color_h2'=>'#1086D9',
'about_color_h3'=>'#1086D9',
'about_color_h4'=>'#1086D9',
'about_color_h5'=>'#1086D9',
'about_color_h6'=>'#1086D9',
'about_color_a'=>'#FFFFFF',
'btn_close_lightbox_color'=>'#FFFFFF',
'backbtn_color_text'=>'#FFFFFF',
'backbtn_color_bcg'=>'#1086D9',
'bcg_color'=>'#000000',
'bcg_opacity'=>'1',
'overlay_color'=>'#000000',
'overlay_opacity'=>'0.4',

'bcg'=>NFB_BOOK_URL.'img/bg.png',
'logo'=>NFB_BOOK_URL.'img/logo.png',
'arrows_gif'=>NFB_BOOK_URL.'img/arrow-navpage.png',
'tool_download_zip'=>NFB_BOOK_URL.'img/file.pdf',
'icons_url'=>NFB_BOOK_URL.'img/icons.png',


'page_size_paragraph'=>'14',
'page_font_paragraph'=>'Arial',
'page_size_li'=>'14',
'page_font_li'=>'Arial',
'page_size_h1'=>'28',
'page_font_h1'=>'Arial',
'page_size_h2'=>'26',
'page_font_h2'=>'Arial',
'page_size_h3'=>'22',
'page_font_h3'=>'Arial',
'page_size_h4'=>'22',
'page_font_h4'=>'Arial',
'page_size_h5'=>'20',
'page_font_h5'=>'Arial',
'page_size_h6'=>'18',
'page_font_h6'=>'Arial',
'about_size_paragraph'=>'12',
'about_font_paragraph'=>'Arial',
'about_size_h1'=>'26',
'about_font_h1'=>'Arial',
'about_size_h2'=>'24',
'about_font_h2'=>'Arial',
'about_size_h3'=>'22',
'about_font_h3'=>'Arial',
'about_size_h4'=>'20',
'about_font_h4'=>'Arial',
'about_size_h5'=>'18',
'about_font_h5'=>'Arial',
'about_size_h6'=>'16',
'about_font_h6'=>'Arial',
'pdf_max_width'=>'',
'pdf_max_height'=>'',
'pdf_resolution'=>'150',
'REVERSE_BOOK'=>'false',
'LOAD_ALL_PAGES'=>'false',
'TOOLS_BAR_VISIBLE'=>'false',
'form_color_input_bcg'=>'#092557',
'menu_bcg_color'=>'#0B2A63',
'menu_sep_color'=>'#092659',
'menu_item_over_color'=>'#0A275C',
'menu_border_top_color'=>'#092659',
'about_color_bcg_number'=>'#0B2A63',
'about_color_text_number'=>'#244686',
'radius_page'=>'12'



);

add_option($option_name_,$default_data);

}


///////////////GET DEFAULT DATA FOR GLOBAL SETTINGS

function nfb_add_default_data_for_global_settings(){
		
	$default_data=array(
	     //global settings
		''=>''
	);

	add_option('nfb_global',$default_data);
}

///////////////////////////////////////get all post flipbook

function nfb_get_all_posts(){
		$args = array(
			'post_type' => NFB_FLIPBOOK_POST_TYPE,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'showposts' => -1
		);
		$posts = query_posts($args);
		wp_reset_query();
		return $posts;
}

///////////////////////////////////////get all post from category

function nfb_get_posts_from_category($cat_,$order_='ASC'){
	  $args = array(
			'post_type' => NFB_FLIPBOOK_POST_TYPE,
			'orderby' => 'menu_order',
			'order' => $order_,
			'showposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => NFB_FLIPBOOK_BOOK_TAX,
					'field' => 'slug',
					'terms' => $cat_
				)
			)
			
		);
        $my_query = new WP_Query($args );
		wp_reset_query();
		return $my_query;
}

///////////////////////////////////////get all post from category ID

function nfb_get_posts_from_category_id($id_,$order_='ASC'){
	  $args = array(
			'post_type' => NFB_FLIPBOOK_POST_TYPE,
			'orderby' => 'menu_order',
			'order' => $order_,
			'showposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => NFB_FLIPBOOK_BOOK_TAX,
					'field' => 'term_id',
					'terms' => $id_
				)
			)
			
		);
        $my_query = new WP_Query($args );
		wp_reset_query();
		//wp_reset_postdata()
		return $my_query;
}

/////////remove post if post not have term (uncategorized)
function nfb_remove_post_not_term(){
			$list=nfb_get_all_posts();
			foreach($list as $key=>$value){
			   $id_post=$value->ID;
			   $post_have_term=has_term('',NFB_FLIPBOOK_BOOK_TAX, $id_post );
	           if(!$post_have_term){
					  wp_delete_post($id_post);
			   }
			}
}


///get pages from category  ( use in "xml/book.php" )
function nfb_get_pages_from_category($slug_){
		$args = array(
			'post_type' => 'any',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'showposts' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => NFB_FLIPBOOK_BOOK_TAX,
					'field' => 'slug',
					'terms' => $slug_
				)
			)
			
		);
		$posts = query_posts($args);
		wp_reset_query(); 
		return $posts;
}

//get image id attachment for url
function nfb_get_attachment_id_from_url( $image_src = '' ) {
 	    global $wpdb;
		$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
		$id = $wpdb->get_var($query);
		return $id;
}	


///get settings for category book
function nfb_get_settings_category($slug_){
	$obj=get_term_by( 'slug',$slug_,NFB_FLIPBOOK_BOOK_TAX );
	$term_id=$obj->term_id;
	$config= get_option(NFB_FLIPBOOK_BOOK_TAX.'__'.$term_id); ///type array
    return $config;
}

//get category book
function nfb_get_category($id_page_){
	 $current_cat = get_the_terms($id_page_,NFB_FLIPBOOK_BOOK_TAX);
	 if($current_cat){
		 return $current_cat[0];
	 }
}

////convert hex to rgb
function nfb_hex_to_rgb($hex) {
   $hex = str_replace("#", "", $hex);
   $r = hexdec(substr($hex,0,2));
   $g = hexdec(substr($hex,2,2));
   $b = hexdec(substr($hex,4,2));
   $rgb = array($r, $g, $b);
   return $rgb; 
}

//create page ( html code )
function nfb_create_page($page_number,$content_,$post,$class_='',$config_,$current_page_number_,$list_pages_count_){
 		$permalink=get_permalink($post->ID);
		$imagepage=get_post_meta($post->ID,'imagepage',true);
		$thumbpage=get_post_meta($post->ID,'thumbpage',true);
		$titlePage=get_post_meta($post->ID,'titlePage',true);
	    $visibleNumber=  get_post_meta($post->ID,'visibleNumber',true) == 'false' ? 'false' : 'true';
		$content=$content_;//$content_;//get_post_field('post_content', $post->ID);
		//align number page
        if( $page_number % 2 == 0   ){
			$align_number='fb5-left';	
		}else{
			$align_number='fb5-right';
		}
		if($config_['rtl']=='true'){
			if( $page_number % 2 > 0   ){
				$align_number='fb5-left';	
			}else{
				$align_number='fb5-right';
			}
		}
		////display number page
		if($visibleNumber=='true'){
			$display_page_number=$page_number;
		}else{
			$display_page_number='';
		}
		
		//if load all pages	
		if($config_['lazy_loading_pages']=='false' || !isset($config_['lazy_loading_pages'])  ){
			$bcg_imagepage=$imagepage; 
		}
		
		///must load current page
		if($current_page_number_==$page_number){
			$bcg_imagepage=$imagepage; 
		}
		if($current_page_number_!=$list_pages_count_&&$current_page_number_!=1){
			if( $current_page_number_ & 2 == 0 ){
				if( ($current_page_number_+1)==$page_number){
				  $bcg_imagepage=$imagepage; 
				}
			}else{
				if( ($current_page_number_-1)==$page_number){
				  $bcg_imagepage=$imagepage; 
				}			
			}
		}
		
        ?>  
        
      
                     
                     
        <!-- generate HTML CODE -->          
        <div class="<?php echo $class_ ?>" data-background-image="<?php echo $imagepage ?>" style="background-image:url(<?php echo $bcg_imagepage ?>)">
               
             <!-- container page book --> 
             <div class="fb5-cont-page-book">
               
                 <!-- description for page from WYSWIG --> 
                <div class="fb5-page-book">
                 <?php echo ($content); ?>                
                </div> 
                          
                <!-- number page and title for page -->                
				<div class="fb5-meta <?php echo $align_number?>">
                     <?php
					    if ( $align_number == 'fb5-left'){ 
					 ?> <!-- left page -->
						<span class="fb5-num"><?php echo $display_page_number ?></span>
						<span class="fb5-description"><?php echo $titlePage ?></span>
                    <?php
						} else {
					?>	<!-- right page -->
                  		<span class="fb5-description"><?php echo $titlePage ?></span>
                    	<span class="fb5-num"><?php echo $display_page_number ?></span>
                    <?php
						} 
					?>
				</div><!-- END number page and title for page -->  
                
                
              </div> <!-- end container page book --> 
                
		</div>
        <!-- end generate HTML CODE -->
        <?php
} 
       
	   
///li for deeplinking
function nfb_create_li($count_,$title_){
?><li data-page="<?php echo ($count_+1) ?>" data-address="<?php echo $title_ ?>"></li><?php 
}


//custom style css
function nfb_custom_style($config,$global_setting){
?>	
   <style type="text/css">
	
	 	
	    /* tools bar*/
		#fb5 .fb5-menu li a {
		    background: url(<?php echo $config['icons_url'] ?>);
		}
		
		
		#fb5-ajax .fb5-bcg-book{				
			opacity:<?php echo $config['bcg_opacity'] ?>;
			<?php  if( $config['bcg_type'] == 'color' ){  ?>
			          background-color:<?php echo $config['bcg_color'] ?>;
			<?php  }else{ ?>			
					  background-image:url(<?php echo $config['bcg'] ?>);
			<?php  }?>
		}
		
		#fb5-ajax.fb5-lightbox #fb5-close-lightbox{
			color:<?php echo $config['btn_close_lightbox_color'] ?>;			
		}
		
		#fb5 #fb5-footer .fb5-bcg-tools { 
		  background-color: <?php echo $config['tools_bcg_bar'] ?>;
		  opacity: <?php echo $config['opacity_bcg_bar'] ?>;
		  display:none;
		}
		
		#fb5 .fb5-tooltip{
			 background:<?php echo $config['tooltip_bcg_color'] ?> !important; 
			 color:<?php echo $config['tooltip_text_color'] ?>;
		}
		#fb5 .fb5-tooltip b { border-top: 10px solid <?php echo $config['tooltip_bcg_color'] ?> }
		
		
		#fb5 .fb5-menu li.fb5-goto #fb5-label-page-number {
    		color: <?php echo $config['color_label_gotopage'] ?>;
		}
		#fb5 .fb5-menu li.fb5-goto button {
   		    color: <?php echo $config['color_label_go'] ?>;
			background: linear-gradient(to bottom, <?php echo $config['color_bcg_go'] ?> 0px, <?php echo $config['color_bcg_go2'] ?> 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
   		}
		#fb5 .fb5-menu li.fb5-goto input[type="text"] {
   			 background: none repeat scroll 0 0 <?php echo $config['input_color_bcg'] ?> ;
			 border: 1px solid <?php echo $config['input_color_border'] ?>;
		}
		
		
		/* menu /*/
		
		#fb5 #fb5-center.fb5-menu {
              background-color: <?php echo $config['menu_bcg_color'] ?>;
		}
		
		#fb5 .fb5-menu#fb5-center li {
			border-right:1px solid <?php echo $config['menu_sep_color'] ?>;			
		}
		
		#fb5 .fb5-menu#fb5-center li:hover {
			background:<?php echo $config['menu_item_over_color'] ?>;	
		}
		
		#fb5 .fb5-menu#fb5-center {
            box-shadow:0 -1px 0 <?php echo $config['menu_border_top_color'] ?>;
		}
		
		
		
		
		/* book /*/
		
		#fb5 #fb5-book .turn-page {
	       background-color:<?php echo $config['color_bcg_page'] ?>;
        }
		#fb5 .fb5-meta .fb5-num {
		    color: <?php echo $config['color_number_page'] ?>;
		}
		#fb5 .fb5-meta .fb5-description {
    		color: <?php echo $config['color_title_page'] ?>;
		}
		
		
		
		/* corner radius book /*/
		#fb5 .turn-page.odd{	 
   
            <?php if( $config['rtl'] =='false' ) { ?>
			
			border-top-left-radius: <?php echo $config['radius_page'] ?>px;
			border-bottom-left-radius: <?php echo $config['radius_page'] ?>px;
			 
			border-top-right-radius: 0px;
			border-bottom-right-radius: 0px;
			
			<?php } else{  ?>
			
			border-top-right-radius: <?php echo $config['radius_page'] ?>px;
			border-bottom-right-radius: <?php echo $config['radius_page'] ?>px;
			 
			border-top-left-radius: 0px;
			border-bottom-left-radius: 0px;
			
			
			<?php } ?>
			 
		}
								
		#fb5 .turn-page.even{	
			
			<?php if( $config['rtl'] =='false' ) { ?>
			
			border-top-right-radius: <?php echo $config['radius_page'] ?>px;
			border-bottom-right-radius: <?php echo $config['radius_page'] ?>px;
			 
			border-top-left-radius: 0px;
			border-bottom-left-radius: 0px;
			
			<?php } else{  ?>
			
			border-top-left-radius: <?php echo $config['radius_page'] ?>px;
			border-bottom-left-radius: <?php echo $config['radius_page'] ?>px;
			 
			border-top-right-radius: 0px;
			border-bottom-right-radius: 0px;			
			
			<?php } ?>
			
		}


		/* list thumbs /*/
		#fb5 #fb5-all-pages .fb5-container-pages {
		    background: none repeat scroll 0 0 <?php echo $config['listthumbs_bcg'] ?>;
			<?php
			$color_shadow=nfb_hex_to_rgb( $config['listthumbs_shadow'] ); 
			?>
			box-shadow: 0 0 40px rgba(<?php echo $color_shadow[0]?>,<?php echo $color_shadow[1]?>, <?php echo $color_shadow[2]?>, 0.5);
		}
		
		/* form /*/
		#fb5 #fb5-contact form {
   						 
			<?php $color_overlay=nfb_hex_to_rgb( $config['form_bcg'] ); 	?>
            	background:rgba(<?php echo $color_overlay[0]; ?>,<?php echo $color_overlay[1] ?>,<?php echo $color_overlay[2] ?>,.85);
			 
			 
			 <?php $color_shadow=nfb_hex_to_rgb( $config['form_color_shadow'] ); ?>
			 box-shadow: 0 0 60px rgba(<?php echo $color_shadow[0]?>,<?php echo $color_shadow[1]?>,<?php echo $color_shadow[2]?>, 0.1);
		}
		#fb5 #fb5-contact form h3 {
		    color: <?php echo $config['form_color_title'] ?> !important;
		}
		
		
		#fb5 #fb5-contact button {
			    background: none repeat scroll 0 0 <?php echo $config['form_color_btn_bcg'] ?>;
				color: <?php echo $config['form_color_btn_text'] ?>;
		}
		#fb5 #fb5-contact form input,#fb5 #fb5-contact form textarea {
           color: <?php echo $config['form_color_input'] ?>;
		   background:<?php echo $config['form_color_input_bcg'] ?>;
		}
		#fb5 #fb5-contact .fb5-close {
		  color: <?php echo $config['form_color_close_text'] ?>;	
          background: none repeat scroll 0 0 <?php echo $config['form_color_close_bcg'] ?>;
		}
		
		#fb5 #fb5-contact .fb5-thanks p{
		  color:<?php echo $config['form_color_after_sending_p'] ?> !important;			
		}
		#fb5 #fb5-contact .fb5-thanks h1{
		  color:<?php echo $config['form_color_after_sending_h'] ?> !important;			
		}
		
		
		
		/* preloader /*/
		#fb5 .fb5-preloader .wBall .wInnerBall{
            background:<?php echo $config['loader_color_bcg'] ?>;
		}
	
		
		/* arrow gif /*/
		#fb5 .fb5-nav-arrow {
   			 background: url("<?php echo $config['arrows_gif'] ?>") repeat scroll 0 0 rgba(0, 0, 0, 0);
		}
		
		
		
		/* formatt page for flipbook  /*/
		#fb5 .fb5-page-book p {
		   color:<?php echo $config['page_color_p'] ?>;
		   font-family:<?php echo $config['page_font_paragraph'] ?>;
		   font-size:<?php echo $config['page_size_paragraph'] ?>px;
	    }
		#fb5 .fb5-page-book a {
		   color:<?php echo $config['page_color_a'] ?>;
		 }
		#fb5 .fb5-page-book h1 {
	   	   color:<?php echo $config['page_color_h1'] ?> !important;
		   font-family:<?php echo $config['page_font_h1'] ?> !important;
		   font-size:<?php echo $config['page_size_h1'] ?>px !important;
	    }
		#fb5 .fb5-page-book h2 {
	   	   color:<?php echo $config['page_color_h2'] ?> !important;
		   font-family:<?php echo $config['page_font_h2'] ?> !important;
		   font-size:<?php echo $config['page_size_h2'] ?>px !important;
	    }
		#fb5 .fb5-page-book h3 {
	   	   color:<?php echo $config['page_color_h3'] ?> !important;
		   font-family:<?php echo $config['page_font_h3'] ?> !important;
		   font-size:<?php echo $config['page_size_h3'] ?>px !important;
	    }
		#fb5 .fb5-page-book h4 {
	   	   color:<?php echo $config['page_color_h4'] ?> !important;
		   font-family:<?php echo $config['page_font_h4'] ?> !important;
		   font-size:<?php echo $config['page_size_h4'] ?>px !important;
	    }
		#fb5 .fb5-page-book h5 {
	   	   color:<?php echo $config['page_color_h5'] ?> !important;
		   font-family:<?php echo $config['page_font_h5'] ?> !important;
		   font-size:<?php echo $config['page_size_h5'] ?>px !important;
	    }
		#fb5 .fb5-page-book h6 {
	   	   color:<?php echo $config['page_color_h6'] ?> !important;
		   font-family:<?php echo $config['page_font_h6'] ?> !important;
		   font-size:<?php echo $config['page_size_h6'] ?>px !important;
	    }
		#fb5 .fb5-page-book li {
           color:<?php echo $config['page_color_li'] ?>;	
		   font-family:<?php echo $config['page_font_li'] ?>;
		   font-size:<?php echo $config['page_size_li'] ?>px;		
		}
		#fb5 .fb5-page-book ul li a,#fb5 .fb5-page-book ol li a {
	        color:<?php echo $config['page_color_alist'] ?>;
		}

        
		/*  about style  /*/
		#fb5 #fb5-about p,#fb5 #fb5-about li {
		   color: <?php echo $config['about_color_p'] ?>;
		   font-family:<?php echo $config['about_font_paragraph'] ?>;
		   font-size:<?php echo $config['about_size_paragraph'] ?>px;
	    }  
		#fb5 #fb5-about a {
		  color:<?php echo $config['about_color_a'] ?>	
		}
		#fb5 #fb5-about h1 {
		   color: <?php echo $config['about_color_h1'] ?>;
		   font-family:<?php echo $config['about_font_h1'] ?>;
		   font-size:<?php echo $config['about_size_h1'] ?>px;
	    }  
		#fb5 #fb5-about h2 {
		   color: <?php echo $config['about_color_h2'] ?>;
		   font-family:<?php echo $config['about_font_h2'] ?>;
		   font-size:<?php echo $config['about_size_h2'] ?>px;
	    }  
		#fb5 #fb5-about h3 {
		   color: <?php echo $config['about_color_h3'] ?> !important;
		   font-family:<?php echo $config['about_font_h3'] ?> !important;
		   font-size:<?php echo $config['about_size_h3'] ?>px !important;
	    }  
		#fb5 #fb5-about h4 {
		   color: <?php echo $config['about_color_h4'] ?>;
		   font-family:<?php echo $config['about_font_h4'] ?>;
	    }  
		#fb5 #fb5-about h5 {
		   color: <?php echo $config['about_color_h5'] ?>;
		   font-family:<?php echo $config['about_font_h5'] ?>;
		   font-size:<?php echo $config['about_size_h5'] ?>px;
	    }  
		#fb5 #fb5-about h6 {
		   color: <?php echo $config['about_color_h6'] ?>;
		   font-family:<?php echo $config['about_font_h6'] ?>;
		   font-size:<?php echo $config['about_size_h6'] ?>px;
	    }  
		/* back  button  /*/
		#fb5 #fb5-button-back {
    		background-color: <?php echo $config['backbtn_color_bcg'] ?>;
   			color: <?php echo $config['backbtn_color_text'] ?>;
		}
		#fb5 #fb5-button-back:hover{
			color:<?php echo $config['backbtn_color_bcg'] ?>;  
			background-color:<?php echo $config['backbtn_color_text'] ?>
 		}
		
		#fb5 #fb5-about .circle {
			background-color: <?php echo $config['about_color_bcg_number'] ?>;
			box-shadow: 1px 1px 0 1px rgba(0, 0, 0, 0.2);
			color: <?php echo $config['about_color_text_number'] ?>;
		}
		
		
		
		
		/*  Other style   /*/
		#fb5 .fb5-overlay {
			    <?php $color_overlay=nfb_hex_to_rgb( $config['overlay_color'] ); 	?>
            	background:rgba(<?php echo $color_overlay[0]; ?>,<?php echo $color_overlay[1] ?>,<?php echo $color_overlay[2] ?>,<?php echo $config['overlay_opacity'] ?>);
				
				
        }
		
		
		 
       /* include custom css /*/
	   <?php echo $global_setting['custom_css'] ?>
 
	
	</style>
<?php    	
}


//////add to library

function nfb_add_to_library($file_){
$url = $file_;
$post_id = 0;
$desc = basename($url);
$image = media_sideload_image($url,$post_id, $desc);
return $image;	
}









//////short

add_action( 'wp_ajax_short', 'nfb_short' );
add_action( 'wp_ajax_nopriv_short', 'nfb_short' );


function nfb_short() {
	

//variable from jquery
$is_as_template=$_POST['is_as_template'];
$cat=$_POST['cat'];
$data_address=$_POST['data_address']; //from deeplinking in browser


///$cat_list=$cat;                              								 ///all list book - string
//$cat_list_array=explode(',',$cat_list);										 ///all list book - array
//$cat=$cat_list_array[0]; 

///echo "cat ====== ".$cat;
                 								 
//foreach( $cat_list_array as $key=>$value ){
	//if($value==$address){
		///$cat=$value;
		//break;
	//}	
//}
	
//ob_start();
//get config	
$config=nfb_get_settings_category($cat);
$global_setting=get_option('nfb_global');
//get all items for category

$list_pages=nfb_get_posts_from_category($cat);
if( $config['rtl']=='true' ){
  $list_pages_rtl=nfb_get_posts_from_category($cat,"DESC");	
}





?>	
 
    
   
     
    <!-- add custom css style --> 
    <?php nfb_custom_style($config,$global_setting);?> 

         
    <!-- BEGIN STRUCTURE HTML FLIPBOOK -->      
    <div id="fb5" class="fb5" data-current="<?php echo $cat; ?>">
      
    
    <!-- preloader -->
    <?php if(  $config['preloader_visible'] == "true"){?>
        <div class="fb5-preloader">
        <div class="wBall" id="wBall_1">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_2">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_3">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_4">
        <div class="wInnerBall">
        </div>
        </div>
        <div class="wBall" id="wBall_5">
        <div class="wInnerBall">
        </div>
        </div>
        </div>
    <?php } ?>
  
  
    <!-- back button -->
    <?php if($is_as_template=="true"){?>
    <a id="fb5-button-back" href="<?php echo $config['back_button']?>"><?php echo $config['label_back_button']?></a>
    <?php } ?>
      
      
            
  
	<!-- BEGIN PAGE -->
	<div id="fb5-container-book">
 
  	   <!-- BEGIN deep linking -->  
       <section id="fb5-deeplinking">
          <ul>
          <?php     
		        $current_page_number=1;
		        $sep=$config['sep_deeplinking'];
                $all_pages = $list_pages;
				$count=0; //// from 0 form start to end ++
				$nr_page=0;
        		if ( $all_pages->have_posts() ) { 
        		  while ( $all_pages->have_posts() ) { 
         			 $all_pages->the_post();
					 $_post=$all_pages->post;
					 $double_page=get_post_meta($_post->ID,'double_page',true);
					 //title
					 $title=$all_pages->posts[$count]->post_title;
					 $title_next=$all_pages->posts[$count+1]->post_title;;
					 $title_prev=$all_pages->posts[$count-1]->post_title;;
                     
					 if( ($nr_page+1)%2==0 ){
                     	$title_view=$title.$sep.$title_next;
					 }else{
						$title_view=$title_prev.$sep.$title; 
					 }
					 
					 if( $config['rtl']=='true' ) {
						 if( ($nr_page+1)%2==0 ){
							$title_view=$title_next.$sep.$title;
						 }else{
							$title_view=$title.$sep.$title_prev; 
						 }
					 }
						 
					 
					 ///correct if the same string ( example the same string for page 2 and 3 )
					 if($title==$title_next){
						$title_view=$title; 
					 }
					 if( $title==$title_prev ){
						$title_view=$title; 
					 }
					 
					 ////correct for first and old child
					 if($count==0){
						$title_view=$title; 
					 }
					 if( !strlen($title_next) ){
						$title_view=$title; 
					 }
						
					 //for double page	
					 if( $double_page=="true" ) {
						nfb_create_li($nr_page++,$title);						 
						nfb_create_li($nr_page++,$title);						 
					 }else{
						nfb_create_li($nr_page++,$title_view);							 
					 }
					 
					 //add current page number
					 if($title_view==$data_address||$title==$data_address){
						 $current_page_number=$nr_page;						 
					 }
									 
	
					 $count++;
			 
				  }
				   wp_reset_postdata();
				}
     			?>
          </ul>
        </section>
    	<!-- END deep linking -->  
    
		
		<!-- BEGIN ABOUT -->
        <section id="fb5-about">
		<?php echo do_shortcode($config['desc_book']) ?>
        </section>
		<!-- END ABOUT -->


		<!-- BEGIN BOOK -->
		<div id="fb5-book">
        
        <?php
        /////////get all items from category flipbook
		$page_number= $config['rtl']=='true' ? $nr_page+1 : 0;
		$page_number_change= $config['rtl']=='true' ? -1 : 1;
        $my_query = $list_pages_rtl ? $list_pages_rtl : $list_pages;
		  
		
		  
		//get a  
		
        if ( $my_query->have_posts() ) { 
        while ( $my_query->have_posts() ) { 
           $my_query->the_post();
		   $_post=$my_query->post;
           //////get content
		   ob_start();
		   the_content();
           $cont = ob_get_clean();
		   //check double page 
		   $double_page=get_post_meta($_post->ID,'double_page',true);
		   if($double_page=='true'){
	      	 nfb_create_page($page_number+=$page_number_change,$cont,$_post,'fb5-double fb5-first',$config,$current_page_number,$nr_page);
			 nfb_create_page($page_number+=$page_number_change,$cont,$_post,'fb5-double fb5-second',$config,$current_page_number,$nr_page);			
           }else{
			 nfb_create_page($page_number+=$page_number_change,$cont,$_post,'',$config,$current_page_number,$nr_page);	  
		   }
         }
		  wp_reset_postdata();
        }
       	  
        ?>  
		</div>
        <!-- END BOOK -->
        
     
        
        
        <!-- arrows -->
        <?php if ( $config['arrows_visible']== 'true' ) { ?>
			<a class="fb5-nav-arrow prev"></a>
			<a class="fb5-nav-arrow next"></a>
        <?php }?>

	</div>
	<!-- END PAGE -->


	<!-- BEGIN FOOTER -->
	<div id="fb5-footer">
    
	    <div class="fb5-bcg-tools"></div>
         
		
		
		<div id="fb5-center" class="fb5-menu">
			<ul>
            
                <!-- icon download -->
                <?php if( $config['icon_download_visible']=='true' ){ ?>
				<li>
					<a href="<?php echo $config['tool_download_zip'] ?>" class="fb5-download" title="<?php echo $config['tool_download'] ?>"></a>
				</li>
                <?php } ?>
			
            
                <!-- icon_home -->
                <?php if( $config['icon_home']=='true' ){ ?>
				<li>
					<a class="fb5-home" title="<?php echo $config['tool_home'] ?>"></a>
				</li>
                <?php } ?>
                
                
                
                <!-- icon_zoom_in -->
                <?php if( $config['icon_zoom_in']=='true' ){ ?>          
            	<li>
					<a class="fb5-zoom-in" title="<?php echo $config['tool_zoom_in'] ?>"></a>
				</li>
                <?php } ?>
                
                
                <!-- icon_zoom_out -->
                <?php if( $config['icon_zoom_out']=='true' ){ ?> 
				<li>
					<a class="fb5-zoom-out" title="<?php echo $config['tool_zoom_out'] ?>"></a>
				</li>
                <?php } ?>
                
                
                <!-- icon_zoom_auto -->
                <?php if( $config['icon_zoom_auto']=='true' ){ ?>
				<li>
					<a class="fb5-zoom-auto" title="<?php echo $config['tool_zoom_auto'] ?>"></a>
				</li>
                <?php } ?>
                
                
                <!-- icon_zoom_original -->
                <?php if( $config['icon_zoom_original']=='true' ){ ?>
				<li>
					<a class="fb5-zoom-original" title="<?php echo $config['tool_zoom_original'] ?>"></a>
				</li>
                 <?php } ?>
                
                
                <!-- icon_allpages -->
                <?php if( $config['icon_allpages']=='true' ){ ?>
				<li>
					<a class="fb5-show-all" title="<?php echo $config['tool_list_page'] ?>"></a>
				</li>
                <?php } ?>                              
                            
                
                
                 <!-- icon contact form -->
                <?php if( $config['icon_form']=='true' ){ ?> 
				<li>
					<a class="contact" title="<?php echo $config['tool_message'] ?>"></a>
				</li>
                <?php } ?>
                
                
                 <!-- icon fullscreen -->
                <?php if( $config['icon_fullscreen']=='true' ){ ?> 
                <li>
					<a class="fb5-fullscreen" title="<?php echo $config['tool_fullscreen'] ?>"></a>
				</li>
                <?php } ?>
				
			</ul>
		</div>
		
		<div id="fb5-right" class="fb5-menu">
			<ul>
            
                
                
                
                 <!-- icon page manager -->
                <?php if( $config['icon_page_manager']=='true' ){ ?> 
				<li class="fb5-goto">
					<label id="fb5-label-page-number" for="fb5-page-number"><?php echo $config['go_to_page'] ?></label>
					<input type="text" id="fb5-page-number" />
					<button type="button"><?php echo $config['go'] ?></button>
				</li>
                 <?php } ?>
                 
                 
                 
                
                
                
               
                             
                
                
			</ul>
		</div>
        
        
	
	</div>
	<!-- END FOOTER -->


    <!-- BEGIN CONTACT FORM -->
    <?php if( $config['icon_form']=='true' ){ ?>
    <div class="fb5-overlay" id="fb5-contact">

	 <form>
		<a class="fb5-close">X</a>

		<fieldset>
			<h3><?php echo $config['title_contact'] ?></h3>

			<p>
				<input type="text" value="<?php echo $config['form_name'] ?>" id="fb5-form-name" class="req" />
			</p>

			<p>
				<input type="text" value="<?php echo $config['form_email'] ?>" id="fb5-form-email" class="req" />
			</p>

			<p>
				<textarea id="fb5-form-message" class="req"><?php echo $config['form_message'] ?></textarea>
			</p>

			<p>
				<button type="submit"><?php echo $config['button_send'] ?></button>
			</p>
		</fieldset>
		
		<fieldset class="fb5-thanks">
			<?php echo stripslashes( $config['info_after_sending'] ) ?>
		</fieldset>
	 </form>

   </div>
   <?php } ?>
   <!-- END CONTACT FORM -->
   
   
    

	<!-- BEGIN ALL PAGES -->
     <?php if( $config['icon_allpages']=='true' ){ ?>
	<div class="fb5-overlay" id="fb5-all-pages">

	  <section class="fb5-container-pages">

		<div id="fb5-menu-holder">

			<ul id="fb5-slider">
            
            <?php      
                $all_pages = $list_pages;
				$redirect_page=0;
        		if ( $all_pages->have_posts() ) { 
        		  while ( $all_pages->have_posts() ) { 
         			 $all_pages->the_post();
					 $_post=$all_pages->post;
					 //get image url
					 $thumbpage=get_post_meta($_post->ID,'thumbpage',true);
					 if( strlen($thumbpage) ){
						$image=$thumbpage;  
					 }else{
						$image=NFB_PLUGIN_URL."img/empty.png"; 
					 }
					 //check double page 
		  			 $double_page=get_post_meta($_post->ID,'double_page',true);
					 if($double_page=="true"){
						$redirect_page+=2; 
					 }else{
						$redirect_page+=1; 
					 }
		   			 ?>
                     
                     <!-- BEGIN GENERATE HTML CODE -->
                     <?php
                     if($config['lazy_loading_thumbs']=="false" ||  !isset($config['lazy_loading_thumbs']) ){
						 $src_thumbs="src=$image";
					 }else{
						 $src_thumbs='';
					 }                      
					 ?>	
                     
                     <li class="<?php echo $redirect_page  ?>">
					   <img data-src="<?php echo $image ?>" alt="" <?php echo $src_thumbs ?> />
				     </li>
                     <!-- END GENERATE HTML CODE -->
                     <?php
         		  }
				  wp_reset_postdata();
        	    }
            ?>        

			</ul>
		
        </div>

	</section>

   </div>
   <?php } ?>
  <!-- END ALL PAGES -->
  
  
  
  
  <!-- BEGIN CLOSE LIGHTBOX  -->
  
  <div id="fb5-close-lightbox">
     <i class="fa fa-times pull-right"></i>
  </div>
 
  
  <!-- END CLOSE LIGHTBOX -->
  
  
    
  
  <!-- begin config -->
  <section id="fb5-config" style="display:none">
    <ul>
		<?php	
			foreach( $config as $key=>$value ){	
			  echo "<li key=".$key.">".$value."</li>";
			}	
        ?>
    </ul> 
  </section>   
  <!-- end config -->
    


</div>
<!-- END STRUCTURE HTML FLIPBOOK -->
	
	<?php
	die();
}






///////add css and script in HEAD

function nfb_add_css_and_js($cat,$is_as_template){
	
  
   //css
   wp_enqueue_style('fb5',NFB_BOOK_URL."css/style.css");
    
   
   //fonts
   wp_deregister_style('nfb_font');
   wp_register_style('nfb_font','http://fonts.googleapis.com/css?family=Play:400,700');
   wp_enqueue_style('nfb_font');
    	 		 
   
   //font awesome
   wp_enqueue_style( 'nfb_font_awesome',NFB_BOOK_URL."css/font-awesome.min.css");
		 
   
   //jquery
   //http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js
   //wp_deregister_script('jquery2');
   //wp_register_script('jquery2',NFB_BOOK_URL."js/jquery.js");
   wp_enqueue_script('jquery');
   
   
   //jquery noConflict
   wp_deregister_script('jq_no_conflict');
   wp_register_script('jq_no_conflict',NFB_BOOK_URL."js/jquery_no_conflict.js");
   wp_enqueue_script('jq_no_conflict');

   
   //turnjs
   /*
   $global_setting=get_option('nfb_global');
   $link_turnjs=$global_setting['library_turnjs'];
   if( strlen ($link_turnjs) > 3 ){
    	wp_enqueue_script( 'turnjs',$link_turnjs,array('jquery'));
   }else{
	    ?>
       <script>
	      alert('No turnjs library. Go to the admin panel and menu "Diamond Book / Settings".There is the field "Link to library turnjs".');
	   </script>
      <?php 
   }/*/
   wp_enqueue_script( 'turnjs',NFB_BOOK_URL."js/turn.js",array('jquery'));
   
   ///wait
   wp_enqueue_script( 'cdnjs',NFB_BOOK_URL."js/wait.js",array('jquery'));
   
   
   //full screen
   wp_enqueue_script( 'nfb_fullscreen',NFB_BOOK_URL."js/jquery.fullscreen.js",array('jquery'));
   
   //addres
   wp_enqueue_script( 'nfb_address',NFB_BOOK_URL."js/jquery.address-1.6.min.js",array('jquery'));
   
   
   //onload
   wp_enqueue_script( 'nfb_onload',NFB_BOOK_URL."js/onload.js",array('jquery'));	
   wp_localize_script( 'nfb_onload', 'ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'test' => 1234 ) );
	
	
	
}


?>