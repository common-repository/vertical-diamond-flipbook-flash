<?php 


//* SHOW FLIP BOOK   /*/
function nfb_flipbook_v5($atts, $content = null){
	extract( shortcode_atts( array(
	'cat' => '',
	'is_as_template'=>'false',
	'fullbrowser'=>'false'
	
	), $atts));

ob_start(); 

//config
$config=nfb_get_settings_category($cat);

//add attribute 'data-plugin_url' only for template
if($is_as_template=="true"){
$data_plugin_url='data-plugin_url="'.NFB_PLUGIN_URL.'"';
}

//add attribute 'data-template' only for template
if($is_as_template=="true"){
$data_template='data-template="'.$is_as_template.'"';
}

//ajax url
if($is_as_template=="true"){
$ajax_url='ajax_url="'.admin_url( 'admin-ajax.php' ).'"';
}



///data for backgroud book
/*
$toolbar_visible=$config['toolbar_visible'];
if( $toolbar_visible == "true"){
  $toolsHeight='60';	
}else{
  $toolsHeight='0'	;
}
if( preg_match('/,/',$cat)==false ){
 if( $config['bcg_type']=='color' ){
	 $bcg=$config['bcg_color'];
 }else{
	 $bcg=$config['bcg'];
 }
 	
 $data_bcg="data-bcg=".$config['page_width'].",".$config['page_height'].",".$toolsHeight.",".$bcg.",".$config['bcg_opacity']."";
}
/*/

/////full browser
if( $fullbrowser=="true" ){
	$class="fb5-fullbrowser";	
}


?>



<div id='fb5-ajax' class="<?php echo $class ?>" data-cat="<?php echo $cat ?>" <?php echo $data_template ?> <?php echo $data_plugin_url ?>  <?php echo $ajax_url ?>>
 			
    <!-- background for book -->  
    <div class="fb5-bcg-book"></div>
    
    <!-- load book from ajax here -->
</div>




<?php
if( $is_as_template=='false'){
	return ob_get_clean();	
}else{
	return ob_get_flush();	
}
}

add_shortcode(NFB_SHORTCODE,'nfb_flipbook_v5');	

//////format for shortcode
function nfb_my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[nfb_raw\].*?\[/nfb_raw\])}is';
	$pattern_contents = '{\[nfb_raw\](.*?)\[/nfb_raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= $piece;//wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}

//remove_filter('the_content', 'wpautop');
//remove_filter('the_content', 'wptexturize');
add_filter('nfb_raw_filter', 'nfb_my_formatter', 99);

//remove p and br from shortcode
function nfb_clear_autop($content){
    $content = str_ireplace('<p>', '', $content);
    $content = str_ireplace('</p>', '', $content);
    $content = str_ireplace('<br />', '', $content);
    return $content;
}
add_filter('nfb_out_filter', 'nfb_clear_autop');


///home template
function nfb_home_template($atts, $content = null){
	extract( shortcode_atts( array(
	        'color_line'=>'#dadada',
			'logo_src' => ''
		
	), $atts));
	
	?>
    <style>
    #fb5 #fb5-cover {
    	border-left: 5px solid <?php echo $color_line ?>;
	}
    </style>
    <?php

	$html=do_shortcode("[nfb_raw]<div id='fb5-cover'>
				<ul>".($content)."</ul>
		  <img id='fb5-logo-cover' src='$logo_src'>	
		  </div>[/nfb_raw]");
			
	$html=apply_filters('nfb_out_filter',$html);		
	return apply_filters('nfb_raw_filter',$html);	
	
}

add_shortcode('home','nfb_home_template');	

//item for home
function nfb_home_item($atts, $content = null){
	extract( shortcode_atts( array(
	'img_src' => '',
	'redirect'=>''
		
			
	), $atts));
	
	
	if( strlen($redirect) ){
	
	    $html="<li><a href=$redirect><img src='$img_src'></a></li>";
			
	}else{
		$html="<li><img src='$img_src'></li>";
	}
			
	return $html;	
	
}

add_shortcode('item','nfb_home_item');	



?>