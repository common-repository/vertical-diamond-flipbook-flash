jQuery(document).ready(function($) {

 

/*----FOR SELECT FILE ---/*/
add_upload_button('#upload_bcg',"#bcg");
add_upload_button('#upload_logo',"#logo");
add_upload_button('#upload_icons',"#icons");
add_upload_button('#tool_download_zip_button',"#input_download_zip");
add_upload_button('#upload_thumb_carousel',"#thumb_carousel");
add_upload_button('#upload_DESC_BOOK',"#DESC_BOOK");
add_upload_button('#upload_imagepage',"#imagepage");
add_upload_button('#upload_thumbpage',"#thumbpage");
add_upload_button('#upload_preloader_gif',"#preloader_gif");
add_upload_button('#upload_arrows_gif',"#arrows_gif");
add_upload_button('#upload_library_turnjs',"#library_turnjs");

///////////add upload button
function add_upload_button(button,input) {
		jQuery(button).click(function() {
			tb_show('FlipBook upload image', 'media-upload.php?type=file&TB_iframe=true');				
   			add_src_to_input(input);					
			return false;
		});
	}	
	
//button media for flipbook
jQuery('#add_media').click(function() {
   window.original_send_to_editor = window.send_to_editor;	
   window.send_to_editor = function() {
		tb_remove();
		window.send_to_editor = window.original_send_to_editor;
	};
			
});	

//////////add image src to unput
function add_src_to_input(input) {
   window.original_send_to_editor = window.send_to_editor;	
   window.send_to_editor = function(html) {
		imgurl = jQuery(html).attr('href');
		jQuery(input).val(imgurl);
		tb_remove();
		window.send_to_editor = window.original_send_to_editor;
	};
}








setTimeout( function(){
/*----CHANGE TEMPLATE ---/*/
var temp_book=$('#template_q5_flipbook')
temp_book.css('display','none');
$('#page_template,.components-base-control.editor-page-attributes__template select').change(function() {
        
		if ( $(this).val() == 'template-flipbook.php' ) {
     			 temp_book.show();
    	} else {
       			 temp_book.hide();
    	}
		
    }).change(); 
},1000)
	
	
	
	










});


