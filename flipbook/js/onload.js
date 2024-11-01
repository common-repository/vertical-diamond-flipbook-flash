(function($){

////CONFIGURATION
var WIDTH_BOOK           			//WIDTH BOOK
var HEIGHT_BOOK						//HEIGHT BOOK
var BOOK_SLUG;						//SLUG FOR BOOK
var WINDOW_WIDTH;                   //WIDTH AREA [px]
var WINDOW_HEIGHT;                  //HEIGHT AREA [px]
var ZOOM_STEP 		        		//STEPS SIZE FOR ZOOM
var ZOOM_DOUBLE_CLICK_ENABLED;		//ENABLED DOUBLE CLICK FOR ZOOM
var ZOOM_DOUBLE_CLICK;    			//ZOOM FOR DOUBLE CLICK
var GOTOPAGE_WIDTH;					//WIDTH FOR INPUT FIELD
var IS_AS_TEMPLATE               	//IF THIS TEMPLATE 
var TOOL_TIP_VISIBLE                //TOOLTIP VISIBLE
var SWF_ADDRESS                     //SWF ADDRESS
var TOOLS_VISIBLE                   //TOOLBAR VISIBLE
var RTL                             //RIGHT TO LEFT



/* =  event ready 
--------------------------*/
$(document).ready(function(e) {	   



    if(  $('#fb5-ajax').attr('data-cat')  == undefined ){ ///as lightbox	
	   
	    Ajax_v5.start_book_lightbox();
		
	}else{ //as shortcodes
		
		if( $('#fb5-ajax').hasClass('fb5-fullbrowser')  ){
			$("#fb5-ajax").detach().appendTo('body')
		}
		
		Ajax_v5.start_book_shortcode();
		
		
	}
    

    
	///redirect from load_book_lightbox ( change attributes href to onClick )
	$('a[href]').each(function(index, element) {
			var el=$(element);
            var href=el.attr('href');						
			if ( href.indexOf("load_book_lightbox") >= 0 ) {
				   el.attr('onClick',href);
				   el.removeAttr('href');
				   el.css('cursor','pointer');			   
		    }
    });
		
	
	
	if( general.browser_firefox() ) {
		console.log('book:version jquery = '+$.fn.jquery);	
	}
});


/* =  Ajax load 
--------------------------*/
var Ajax_v5 = {

     all_books_slug:"",	 
	 
	 speed_bcg:function(books_){
		 
		    if( $('#fb5-ajax').attr('data-template') == "true"){				
				Ajax_v5.init_from_shortcode( $('#fb5-ajax').attr('data-cat')  );									
				return;					
			}
			
		    var _cur_book=Ajax_v5.auto_select_book( books_  );				
			var width=fb5_books[_cur_book].w//data_bcg[0]
			var height=fb5_books[_cur_book].h//data_bcg[1]
			var tools_height=fb5_books[_cur_book].toolsHeight//data_bcg[2];
			var bcg=fb5_books[_cur_book].bcg//data_bcg[3];
			var opacity=fb5_books[_cur_book].opacity
			var bcg_div=$('#fb5-ajax .fb5-bcg-book');			
			bcg_div.css('opacity',opacity);             
			if (  bcg.match(/\..{3}$/) !=null  ){
					bcg_div.css('background-image','url("'+bcg+'")');
			}else{
					bcg_div.css('background-color',bcg);				    	
			}
			$('#fb5-ajax').waitForImages({
										   waitForAll: true,
										   finished: function() {
											   
											    if(  $('#fb5-ajax').attr('data-cat')  == undefined ){ ///as lightbox										
											         Ajax_v5.init_book(books_)
												}else{
													 Ajax_v5.init_from_shortcode( $('#fb5-ajax').attr('data-cat')  );
												}
											   										  
										   }
			});
			Book_v5.book_area(width,height,tools_height);
		 
		 
	 },
	 
	 start_book_shortcode:function(){
		 
		 var books=$('#fb5-ajax').attr('data-cat')
		 Ajax_v5.speed_bcg( books  );	 
		 
	 },
	 
	 
	 start_book_lightbox:function(){		 

				///lightbox from deeplinking
				var cur_book=$.address.pathNames()[0]
				if(cur_book!=undefined&&cur_book!='book_close'){
								 
							///search function load_book_lightbox in body document
							var string=$('body').html();
							var regex = /load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/g;
							var array=string.match(regex);
							
								
							$.each(array, function( index, value ) {
								var regex=/load_book_lightbox\(\'(.+?)\'(,(.+?))?\)/;
								var books=value.match(regex)[1];												
								if( books.indexOf(cur_book) >=0 ){						
									Ajax_v5.init_from_function(books)												
									return false;				
								}			
							});
						
				
				}else{   //autostart lightbox
					
						var string=$('body').html();
						var regex = /load_book_lightbox\(\'(.+?)\',(true)\)/;
						var results=string.match( regex )
						if( results != null ){
							Ajax_v5.init_from_function(results[1])
						}
					
				}

	 },

     init_from_shortcode:function(books_){              
			  
			  if(books_!=undefined){
			  	this.init_book( books_ ); 
			  }
	 },	
	  
	 init_from_function:function(books_){
 
		 $("body").append("<div id='fb5-ajax' class='fb5-fullbrowser fb5-lightbox'><div class='fb5-bcg-book'></div></div>")
		 Ajax_v5.speed_bcg( books_ );
		 $('body,html').addClass('remove_scroll');
	 },
	 
	 auto_select_book:function(books_){		 		   		   
		   		 
		   var categories=books_.split(",");  //array
		   var address=$.address.pathNames()[0]
			  
			  //set category
			  var cat=categories[0];
			  $.each(categories, function(index, value) { 
					 if(value==address){
						 cat=value;
					 }
			  });
			  
		   return cat;	  
	 },
	 
	 init_book:function(books_){
		   
		   this.all_books_slug=books_;		   		   
		   		 
		   var categories=books_.split(",");  //array
		   var address=$.address.pathNames()[0]
			  
			  //set category
			  var cat=categories[0];
			  $.each(categories, function(index, value) { 
					 if(value==address){
						 cat=value;
					 }
			  });
			  
		    
		   //set background				  
	  
	
	
	 this.load_book( cat );	  
		 
	 },

	 load_book:function(cat_){		 
		         
				 if( general.browser_firefox() ) {
				 	console.log("book:ajax load cat="+cat_); 
				 }
				
				 var cat=cat_;
				 var is_as_template=$('#fb5-ajax').attr('data-template');	
				 if( is_as_template == "true" ){
					 var url=$('#fb5-ajax').attr('ajax_url');
				 }else{
				     var url=fb5_plugin_url+"lib/short.php";
					 url=ajax_object.ajax_url;
				 }
				 
				 
				// console.log("test = "+ajax_object.ajax_url);
									 
				 ////get number
				 var data_address=$.address.pathNames()[1];
	
				 $.ajax({                                      
					  url:url,
					  fb5:true,
					  type: "POST", 
					  data: {action:'short',is_as_template:is_as_template,cat:cat,data_address:data_address,all_books_slug:Ajax_v5.all_books_slug},              
					  success: function(rows)         
					  {			
					  	
							   $('#fb5-ajax').append(rows).waitForImages({
									   waitForAll: true,
									   finished: function() {
										  if( general.browser_firefox() ) { 
										  	console.log('book:load all images in ajax');
										  }
										  Book_v5.load()
										   
										   
									   }
								});
				      },
					  error: function() { alert("error load book"); }
				      });
		}


	
}

/* =  event ajaxSuccess 
--------------------------*/
$(document).ajaxSuccess( function(event, xhr, settings){
      
	   if(  settings.fb5==true ){
			   Book_v5.ready();  
			  
	   }

});


/* =  event ajaxComplete 
--------------------------*/
$(document).ajaxComplete(function(event, xhr, settings){
	
	 if(  settings.fb5==true ){
		 //Book_v5.load();
	 }
	 
})


/* =  show Book
--------------------------*/
  load_book_lightbox=function(books_){
		Ajax_v5.init_from_function(books_);
  }
  

/* =  show Book
--------------------------*/  
  
  function clean(obj) {
		var it;
		while(obj.children().length) {
		it = obj.children(":eq(0)").unbind().removeData().remove();
		clean(it);
		}
		
		$(document).unbind('mousemove');
		$(document).unbind('touchmove');
		
		$(document).unbind('mouseup');
		$(document).unbind('touchend');
}

 
/* =  set Page
--------------------------*/
     
  setPage=function(nr_) {
      
      if( SWF_ADDRESS == "true" ){ 
          var results= $("#fb5-deeplinking ul li[data-page="+nr_+"]");
		  var address = results.attr('data-address');
	  	  setAddress( $('#fb5').attr('data-current')+"/"+address);	
      }else{
           $('#fb5-book').turn('page',nr_);      
      }
       
 };
 

/* =  set Address
--------------------------*/

 setAddress=function(address_) {
       
	   $.address.value( address_ );
  };


/* =  show lightbox with video 
--------------------------*/

  youtube=function(id_,w_,h_) {

	 var w=w_;
	 var h=h_;
	 var id=id_;
	 
	$('body').prepend('<div id="v5_lightbox"><div class="bcg"></div><iframe class="youtube-player" width='+w+' height='+h+' src="http://www.youtube.com/embed/'+id+'?html5=1" frameborder="0" allowfullscreen></iframe></div>');
  
    $(window).trigger('orientationchange');
	  	
	$("#v5_lightbox").click(function(){
		$(this).children().hide();
		$(this).remove();
        
        Book_v5.zoomAuto();
	})
	
	$("#v5_lightbox").css('display','block');
	
 };
 
 
/* =  prototype 
--------------------------*/
Number.prototype.rtl=function()
{
return (Book_v5.getLength()+1)-this.valueOf();
}


/* =  local general function 
--------------------------*/
var general={

browser_firefox:function(){	
	if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
	  return true;	
	}else{
	  return false;	
	}
}

}


/* =  FlipBook v5
--------------------------*/
var Book_v5 = {

	toolsHeight:0,   //tools height
    zoom:1,           //zoom
    page_padding:0.1,
    paddingL:0.02,
    paddingR:0.02,
    paddingT:0.02,
    paddingB:0.02,
	width_slider:0,
    currentPage:0,
    


    ready: function(){
	   if( general.browser_firefox() ) {	
       		console.log('book:ready');    
	   }
	   
	  
	   //lightbox
	   if(  $('#fb5-ajax').attr('data-cat')  == undefined ){
	   		
			//$('#fb5-ajax').addClass('fb5-lightbox');
			//$('#fb5-ajax').addClass('fb5-fullbrowser');
			
				 
			$('#fb5-close-lightbox').bind('click',function(e){	
			
			    setTimeout(function(){
					$('body,html').removeClass('remove_scroll');			
				},100);
				
				if(  $('#fb5-ajax').hasClass('fullScreen')  ){
					
					Navigation_v5.full_screen();
					//return false;
				}
				
				setTimeout( function(){				
				$(this).remove();			//remove button close	
				clean( $('#fb5')  );  		//clean book html				
				$('#fb5-ajax').remove();    //remove container book
				window.location.hash="#book_close";  //remove hash				
				Book_v5.load_one_thumbs=null;
				},1);
				
			})
	   
	   }
	   
	  
	   
	  
       //Configuration
       WIDTH_BOOK=Number(  Book_v5.getConfig('page_width')   )*2;  	 
       HEIGHT_BOOK=Number(  Book_v5.getConfig('page_height')  );
       ZOOM_STEP=Number(    Book_v5.getConfig('zoom_step')   );
       ZOOM_DOUBLE_CLICK_ENABLED=(  Book_v5.getConfig('double_click_enabled')  );           
       ZOOM_DOUBLE_CLICK=Number(  Book_v5.getConfig('zoom_double_click')  )
       GOTOPAGE_WIDTH=Number(   Book_v5.getConfig('gotopage_width')   );
       TOOL_TIP_VISIBLE=(  Book_v5.getConfig('tooltip_visible') );
       SWF_ADDRESS=(  Book_v5.getConfig('deeplinking_enabled')  );
	   RTL=Book_v5.getConfig('rtl');
	   
	   //add class 'even' and 'odd' using jQuery
	   if( RTL == "false" ){		   
		   $("#fb5-book > div:odd").addClass("odd");
		   $("#fb5-book > div:even").addClass("even");
	   }else{
		   $("#fb5-book > div:odd").addClass("even");
		   $("#fb5-book > div:even").addClass("odd");		   
	   }
	   
       IS_AS_TEMPLATE= $('#fb5-ajax').attr('data-template') == "true" ? true : false;
       TOOLS_VISIBLE=(  Book_v5.getConfig('toolbar_visible') );
       if( TOOLS_VISIBLE == "true" ){
			 Book_v5.toolsHeight=80;
	   }else{
			 Book_v5.toolsHeight=0;
		}
		
		///about show
		$('#fb5-about').css('display','block');		
			      

       //event resize
       $(window).bind('orientationchange resize', function(event){
            Book_v5.book_area();
            Book_v5.zoomAuto();
            Book_v5.book_position();
            Book_v5.dragdrop_init();        
            Book_v5.resize_page()     
            Book_v5.center($('#v5_lightbox'));           
            Book_v5.center_icon();
            Book_v5.center_icon();
            Book_v5.media_queries()
		});
		////end  
		
		   
         
        WINDOW_WIDTH=$('#fb5').width();
        WINDOW_HEIGHT=$('#fb5').height();
        
        Book_v5.resize_input_text()
    	Book_v5.book_area();
    	$("#fb5").css('opacity','1');
    	
            
        
        /* SCALE PAGE IN FLIPBOOK  /*/
        //size default for class .fb5-cont-page-book
        $("#fb5 .fb5-cont-page-book").css('width',(WIDTH_BOOK/2)+'px');
        $("#fb5 .fb5-cont-page-book").css('height',HEIGHT_BOOK+'px');
        $("#fb5 .fb5-cont-page-book").css({'transform-origin':'0 0','-ms-transform-origin':'0 0','-webkit-transform-origin':'0 0'});
        //size default for class .page_book
        var paddingL=WIDTH_BOOK*this.paddingL;
        var paddingR=WIDTH_BOOK*this.paddingR;
        var paddingT=WIDTH_BOOK*this.paddingT;
        var paddingB=WIDTH_BOOK*this.paddingB;
        $("#fb5 .fb5-page-book").css('width',(WIDTH_BOOK/2-(paddingL+paddingR))+'px');
        $("#fb5 .fb5-page-book").css('height',(HEIGHT_BOOK-(paddingT+paddingB))+'px');
        
        /* SCALE ABOUT near FLIPBOOK  /*/
        $("#fb5 #fb5-about").css('width',(WIDTH_BOOK/2)+'px');
        $("#fb5 #fb5-about").css('height',HEIGHT_BOOK+'px');
		if(RTL=='true'){
			$("#fb5 #fb5-about").css('right','0px');
			$("#fb5 #fb5-about").css({'transform-origin':'right 0','-ms-transform-origin':'right 0','-webkit-transform-origin':'right 0'});
		}else{
        	$("#fb5 #fb5-about").css({'transform-origin':'0 0','-ms-transform-origin':'0 0','-webkit-transform-origin':'0 0'});
		}
		
        //run key
        this.key_down();    

        //show and hide full screen icon
        if(!$.support.fullscreen){
        	$('li a.fb5-fullscreen').parent(this).remove();
        }
		
		///redirect from youtube and setPage ( change attributes href to onClick )
		$('#fb5 a[href]').each(function(index, element) {
			var el=$(element);
            var href=el.attr('href');						
			if ( href.indexOf("youtube") >= 0 || href.indexOf("setPage") >= 0 ) {
				   el.attr('onClick',href);
				   el.removeAttr('href');			   
		    }
        });
		
		
		/////add remove scrollbar
	   //if( $('#fb5-ajax').hasClass('fb5-fullbrowser') ){
	    	//$('body,html').addClass('remove_scroll');
	   //}
             
    },
        
    load: function(){
		if( general.browser_firefox() ) {
        	console.log('book:load');
		}
		
        //preloader hide
        $('#fb5 .fb5-preloader').css('display','none');
        
   		$.address.strict(false)
		$.address.autoUpdate(true)
	
		$('#fb5-container-book').show();
		
		Book_v5.init();
	
		Book_v5.zoomAuto();
		
		Book_v5.book_position();
	
		Book_v5.dragdrop_init();

		Navigation_v5.init();

		Book_v5.resize_page();   
        
        if( TOOLS_VISIBLE == "true" ){
        	$("#fb5 #fb5-footer").css('opacity','1');
        }
        
         //center icon
        Book_v5.center_icon();
        Book_v5.center_icon();
        Book_v5.media_queries()
		
	   
			 
    },
		
	getConfig:function(attr_){		
		return $('#fb5-config li[key='+attr_+']').html();	
		
	},
	
	getLength:function(){		
		return $('#fb5-deeplinking ul li').length;		
	},
    
    center_icon:function(){
    
        //icon tools position
        var icon=$('#fb5-center');
        var all_width=$('#fb5').width();
        var left_w=$('#fb5-logo').width();
        var center_w=$('#fb5-center').width();
        var right_w=$('#fb5-right').width();
                
        var posX=all_width/2-center_w/2;
        icon.css('left',posX+'px');
        
        
        
        
    },
    
    media_queries:function (){
            
       //center
       var position_center=$('#fb5-center').position();
	   var xMax_center=position_center.left+$('#fb5-center').width();
       var xMin_center=position_center.left
       //right
       var position_right=$('#fb5-right').position();
       var xMin_right=position_right.left;
       //left
       var position_left=$('#fb5-logo').position();
       var xMax_left=position_left.left+$('#fb5-logo').width();
          
	   var source=$('#fb5 #fb5-logo,#fb5 #fb5-right');	  
		      
       if( xMax_center > xMin_right || xMax_left > xMin_center  ){
         source.css('visibility','hidden');
		 source.css('opacity','0');
		
       }else{
         source.css('visibility','visible');
		 source.css('opacity','1');
       }


    }, 
    
    autoMarginB:function(){
      return Math.round(  $('#fb5').height()*0.02 )
    },
    
    autoMarginT:function(){
        return Math.round( $('#fb5').height()*0.02 )    
    },
    
     autoMarginL:function(){
      return Math.round( $('#fb5').width()*0.02 )    
    },
    
     autoMarginR:function(){
       return Math.round(  $('#fb5').width()*0.02 )   
    },
	
	change_address:function(){
		
						var th=this;
						if( general.browser_firefox() ) {
							console.log("book:change address")
						}
						//$('h1.entry-title').append(' /change ')
					    ///for slug
					    var slug=$.address.pathNames()[0];
					    if(th.tmp_slug!=undefined&&slug!=th.tmp_slug){
			   			 
					      
						 //setAddress('book5-1'); 
						 //setTimeout(function(){
						   //window.location.reload();
						 //},1);
						 
						 if( general.browser_firefox() ) {
						 	console.log("book:change book")
						 }
						 //$('h1.entry-title').append(' /change book ')
						 
						 //$("#fb5").remove();
						 // Ajax_v5.ready()
						 return;
					   }
					   
					   th.tmp_slug=slug;
					
					   //normal
                       var address=$.address.pathNames()[$.address.pathNames().length-1];
                       var results=$('#fb5-deeplinking ul li[data-address='+address+']');
                       var nrPage=results.attr('data-page')
					   if(RTL=='true'){
				           var nrPage =  ( Book_v5.getLength()+1 ) -results.attr('data-page');						
				       }
					   //error nr page
					   if(!nrPage){
						   if(RTL=='true'){
						      nrPage=Book_v5.getLength();
					       }else{ 
                              nrPage=1;   
						   }
                       }
				
                       $('#fb5-book').turn('page',nrPage);
                       Book_v5.resize_page();
		
	},	
	
	getCurrentPages:function(page){
		
							if(page%2==0){
								var page_left=page
								var page_right=page+1
							}else{
								var page_right=page
								var page_left=page-1							
							}
							/////if current page is page oldf
							if(page_left==Book_v5.getLength()){
							   page_right=null	
							}
							////if current page is page first 
							if(page_right==1){
							   page_left=null	
							}
							
							return {left:page_left,right:page_right}									
	  	
		
	},
    
    init: function() {
		
		var th=this;
		//this.on_start = true;
		
		
	    if( SWF_ADDRESS=="true" ){
        
                /* =  jQuery Addresss INIT
                --------------------------*/
                var current_address=$.address.pathNames()[$.address.pathNames().length-1];
                BOOK_SLUG=$.address.pathNames()[0];
                var results=$('#fb5-deeplinking ul li[data-address='+current_address+']');
                var nrPage =   results.attr('data-page');
				if(RTL=='true'){
				 var nrPage =   ( Book_v5.getLength()+1 ) -results.attr('data-page');						
				}
               
			    //error nr page
			    if(!nrPage){
					if(RTL=='true'){
						 nrPage=Book_v5.getLength();
					 }else{ 
                         nrPage=1;   
					 }
                }
			
       
                /* =  jQuery Addresss CHANGE
                --------------------------*/
				if(Book_v5.one_init_swf_address==null){ 
					$.address.change(function(event) {
						   th.change_address()     
					})
				}
				Book_v5.one_init_swf_address=1
			   
			   
       }
	 
		
		$('#fb5-book').turn({
			display: 'double',
			duration: 600,
			acceleration: true,
			elevation:50,
			page:nrPage,
			when: {
				first: function(e, page) {
					$('.fb5-nav-arrow.prev').hide();
				},
				
				turned: function(e, page) {
					
					if (page > 1) {
						$('.fb5-nav-arrow.prev').fadeIn();
						//$('#fb5-about').hide();
					}
					
					if( (page==1&&RTL=='false') || ( page==$(this).turn('pages')&&RTL=='true') ){	
						$('#fb5-about').css('z-index',11);
					}						
					
					if ( page < $(this).turn('pages') ) {
						$('.fb5-nav-arrow.next').fadeIn();
					}
                                       
					Book_v5.resize_page();
                    if(SWF_ADDRESS=="true"){
                       if(RTL=='true'){
						 setPage( new Number(page).rtl() )   
					   }else{
						 setPage(page);   
					   }
					       
					   th.tmp_slug=$.address.pathNames()[0]             
                    }
										
					
					//add image required ( lazy loading )
					if(  Book_v5.getConfig('lazy_loading_pages')=="true"  ){
						    
							//create array with list number pages for left and right side
							var array_right=[];
							var array_left=[];
							
							//get list requided number pages
							var range = $(this).turn('range', page);
							var _pages=[]
							for (i = range[0]; i<=range[1]; i++){ 
								 _pages.push(i)												 	
							}							
							
							////get curent page 'page_left' and 'page_right'
						    var page_left=Book_v5.getCurrentPages(page).left;
							var page_right=Book_v5.getCurrentPages(page).right;								
													
							//create array pages for right side
							if(page_right!=null){
								var index_right=$.inArray(page_right,_pages);
								var array_right=_pages.slice(index_right);
							}
							//createarray pages for left side
							if(page_left!=null){
								var index_left=$.inArray(page_left,_pages)+1;
								var array_left=_pages.slice(0,index_left).reverse();
							}
							//contact array pages ( right+left )
							var pages_new=[];
							var first_left=array_left.shift();
							if(first_left!=undefined){
								array_right.unshift(first_left);
							}
							
							//combine two arrays
							if( RTL == "true" ){
							  pages_new=array_left.concat(array_right);
							}else{
							  pages_new=array_right.concat(array_left); 	
							}
															
							//run lazy loading with array required pages						
							Book_v5.lazy_loading( pages_new );
					}					
					
				},
				
				turning: function(e, page) {
							
					$('#fb5-about').css('z-index',5);
                    
				},
				
				last: function(e, page) {
					$('.fb5-nav-arrow.next').hide();
				}	
			}
		});
		Book_v5.arrows();
		
	},
	
	lazy_loading: function(pages_){	
	
		
			
		 
				$.each(pages_, function(index, value) {

				var element=$( '.turn-page.p'+(value) );                		
	
				//if( $(element).css('background-image')=='none'  ){		                                  
				var src=element.attr('data-background-image');
					
				if( src!=undefined ){	
										
						$('<img>').attr('src', src).load(function(){	
							 element.css('background-image', 'url("'+src+'")');
						});	
						
				
				
						//for Firefox  ( not load background image if display:none )
						var el=element.parent()
						if( el.css('display')=='none'  ){					
							
							el.css('opacity','0');
							el.css('display','block')
												
							setTimeout(function(){
							el.css('display','none');
							el.css('opacity','1');
							},1);
						}
						//remove temp attributes
				        element.removeAttr( 'data-background-image' )
				}
				////PDF.js
				
			});
				
				
		/* old method	
		$('.turn-page').each(function(index, element) { 
		
		       			   		
			    //if( $(element).css('background-image')=='none'  ){		                                  
				var src=$(element).attr('data-background-image');								
			    $('<img>').attr('src', src).load(function(){	
					 $(element).css('background-image', 'url("'+src+'")');
        		});				

				//for Firefox  ( not load background image if display:none )
				var el=$(element).parent()
				if( el.css('display')=='none'  ){					
					
					el.css('opacity','0');
					el.css('display','block')
									    
					setTimeout(function(){
					el.css('display','none');
					el.css('opacity','1');
					},1);
				}
									
        });		
		/*/
		
	},
	
	corner_change:function(boolean_){
		//$('#fb5-book').turn("disable",boolean_);		
	},
        
	center: function (lightbox_) {
	
			var iframe=$('iframe',lightbox_);
			var old_w=iframe.attr("width");
			var old_h=iframe.attr("height");
    		iframe.css("position","absolute");
	
			var stage_w=$(window).width();
            var stage_h=$(window).height();
            var delta_w=stage_w-old_w;
            var delta_h=stage_h-old_h
            
            if(delta_w<delta_h){
                var new_w=$(window).width()-200;
                var new_h=(new_w*old_h)/old_w
            }else{
                var new_h=$(window).height()-200;
                var new_w=(old_w*new_h)/old_h
            }
            iframe.attr("width", new_w);
            iframe.attr("height",new_h);
            
            var height=iframe.height();
            var width=iframe.width();
            iframe.css("top", ( $(window).height()/2 - height/2+"px"));
            iframe.css("left", ( $(window).width()/2 -width/2+"px"  ));
	},    
        
    key_down: function(){
        $(window).bind('keydown', function(e){
		if (e.keyCode==37)
			//$('#fb5-book').turn('previous');
            Book_v5.prevPage();
		else if (e.keyCode==39)
			//$('#fb5-book').turn('next');
            Book_v5.nextPage();

		});	
    },

    resize_input_text: function (){
		var input=$('#fb5-page-number');
		var btn=$('div#fb5-right button');
		input.css('width',GOTOPAGE_WIDTH);
		//input.css('padding-right',btn.width()+2);
		input.css('padding-right',0);
	}, 

    isiPhone: function (){
       return ( (navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPad") != -1)  );
    },

	arrows: function() {
		$('.fb5-nav-arrow.prev').click(function() {
			//$('#fb5-book').turn('previous');
            Book_v5.prevPage();
            Book_v5.resize_page()
		});
		$('.fb5-nav-arrow.next').click(function() {
			//$('#fb5-book').turn('next');
            Book_v5.nextPage();
            Book_v5.resize_page()
		});
	},
    
    nextPage:function(){
      
      var current=$('#fb5-book').turn('page');
      if( current%2==0){
		 var page=current+2
      }else{
         var page=current+1 
      }      

      if(RTL=='true'){
		setPage( new Number(page).rtl() )   
	  }else{
		setPage(page);   
	  }
  
    
    },
    
    prevPage:function(){
    
      var current=$('#fb5-book').turn('page');
      if(current==1) {return;}
      if( current%2==0){
         var page=current-1;
      }else{
         var page=current-2;
      }
	  
	  if(RTL=='true'){
		setPage( new Number(page).rtl() )   
	  }else{
		setPage(page);   
	  }
	  
    
    },
	
	setAutoWidthSlider:function(){
		
		var summary = 0;
		$('#fb5-slider li').each(function() {
			li_width = $(this).outerWidth();
			summary += li_width;
		})	
		$('#fb5-slider').css('width', summary);
		this.width_slider=summary;
		return this.width_slider
		
	},

	all_pages: function() {
        
		//remove corner
		Book_v5.corner_change(true);     
		
		//start load images
		if(!this.load_one_thumbs){
			
				$('#fb5-all-pages li img').each(function(index, element) { 
								
						var el=$(element);                            
						var src=el.attr('data-src');		
										
						if( el.attr('src')==undefined  ){
						
								setTimeout( function(){
															
										$('<img>').attr('src',src).load(function(){	
											el.css('opacity',0).animate({'opacity':1});
											el.attr('src',src);
											Book_v5.setAutoWidthSlider()
										});				
								
								},index*200)				
						}
				});	
		this.load_one_thumbs=1;
		}
		
			 
        ///height thumbs
        var cont_thumbs=$('#fb5-all-pages .fb5-container-pages');
        var area_height=$('#fb5').height()-this.toolsHeight;
        var height_container=area_height*80/100;
        if(height_container>225){
          height_container=225;
        }
        cont_thumbs.css('height',height_container+'px');
        //position thumbs
        var _top=( (area_height/2) -  ( (cont_thumbs.outerHeight())/2   )  )
        cont_thumbs.css('top',_top+'px');
     
		
		var self = this;
		Book_v5.setAutoWidthSlider();	
		
				
	
		$("#fb5-menu-holder").mousemove(function(e) {
		
		///////////////////////////////////////////
	                     	
			if ( $(this).width() < $("#fb5-slider").width() ) {
	     		var distance = e.pageX - $(this).offset().left;
				var percentage = distance / $(this).width();
				var targetX = -Math.round(($("#fb5-slider").width() - $(this).width()) * percentage);
	    		$('#fb5-slider').animate({left: [targetX+"px",'easeOutCubic']  }, { queue:false, duration: 200 });
			}
		});

        //////////////////////SWIPE
        if(self.events_thumbs!=1){
        $('#fb5-all-pages .fb5-container-pages').bind("touchstart", function(e) {
               
			  
			   
               $('#fb5-slider').stop();
               
               //time
               self.time_start=new Date().getTime();
               self.time_move_old=self.time_start;
               
               //road
			   self.x_start = e.originalEvent.targetTouches[0].pageX;
			   self.x_move=undefined;
               self.x_move_old=self.x_start;
			   
			   //remove default action
		       e.preventDefault(e); 
			   
		});
        
        
				
        $('#fb5-all-pages .fb5-container-pages').bind("touchmove", function(e) {
		       		
   			   	
                //current round and time
                self.x_move = e.originalEvent.targetTouches[0].pageX;  
                self.time_move=new Date().getTime();
                                        
                //time - delta
                self.delta_t=new Date().getTime()-self.time_move_old;
                self.time_move_old=new Date().getTime();                
                                        
                //round- delta
                self.delta_s=self.x_move-self.x_move_old;
                self.x_move_old=self.x_move;
                    
                //set position thumbs
                self.current_x=parseInt( $('#fb5-slider').css('left') ); 
                var new_position=self.current_x+self.delta_s;
                if(new_position>0){ new_position=0 }   
                var minX=-Book_v5.width_slider+WINDOW_WIDTH;
                if(new_position<minX ){new_position=minX}
                $('#fb5-slider').css({left:new_position});
              
                //remove default action
                e.preventDefault(e);       
                
                         
		 });
         
         $('#fb5-all-pages .fb5-container-pages li').bind("touchend", function(e) {   
              			   			   
               //calculation speed                 
               var v=self.delta_s/self.delta_t;
               var s= ( WINDOW_WIDTH*0.25 )*v; 
               var t=Math.abs(s/v);
            
               //set position thumbs
               var new_position=self.current_x+s
               if(new_position>0){new_position=0}   
               var minX=-Book_v5.width_slider+WINDOW_WIDTH;
               if(new_position<minX ){new_position=minX } 
             
               if( Math.abs( self.delta_s ) > 5){
                 
				 
          		 $('#fb5-slider').animate({ left:[new_position+"px","easeOutCubic"]  },t); 
				    
				              
               }			    
			   				
			   //redirect to page	     
			   if( self.x_move==undefined ){
			         var page_index = $(this).attr('class');
			         var tmp = parseInt(page_index);		
			         setPage(tmp)
					 setTimeout(function(){					   
					    close_overlay();
				     },200);
			    }
						   
              //e.preventDefault(e);
 
		});		
        //////////////////////end SWIPE
        self.events_thumbs=1;
        }        
		
        
		////redirect to click thumbs ( not work in IPhone )
		if ( !Book_v5.isiPhone() ) {
			$('#fb5-slider li').bind('click',function() {
				self.x_start=null;
				self.x_move=null;
				$('#fb5-slider').stop();
				var page_index = $(this).attr('class');
				var tmp = parseInt(page_index);
				
				close_overlay();				
				
				setTimeout(function(){					  
					setPage(tmp); 
				},200);
	
			})
		}

		$(document).on('click',function(e) {
			var target = $(e.target);
			if ( target.hasClass('fb5-overlay') ) close_overlay();
		});
        
       
	
	},

	book_grab: function() {
		$('#fb5-container-book').css('cursor', '-webkit-grab');
		$('#fb5-container-book').css('cursor', '-moz-grab');
	},

	book_grabbing: function() {
		$('#fb5-container-book').css('cursor', '-webkit-grabbing');
		$('#fb5-container-book').css('cursor', '-moz-grabbing');
	},
    
    book_area: function(w_,h_,tools_){
		
		var width_book=$('#fb5-ajax').width();
		
		if( w_ ){
		   	WIDTH_BOOK=Number(w_)*2;
		}
		
		if( h_ ){
		   	HEIGHT_BOOK=Number(h_);
		}
		
		if( tools_ ){
		   	this.toolsHeight=Number(tools_);
		}
		
        var width_book=$('#fb5-ajax').width();
                
        ///if(IS_AS_TEMPLATE==true){
           // var height=$(window).height()+"px";
        //}else{
            //var height=(width_book*HEIGHT_BOOK/WIDTH_BOOK)+this.toolsHeight+"px";
        ///}
        
        if( $('#fb5-ajax').attr('data-template')=="true" || $('#fb5-ajax').hasClass('fb5-fullbrowser') || $('#fb5-ajax').hasClass('fullScreen')  ){
           //var height=$(window).height()+"px";
		   $('#fb5-ajax').removeAttr('style');
        }else{           
            var height=(width_book*HEIGHT_BOOK/WIDTH_BOOK)+this.toolsHeight+"px";  
		    $("#fb5-ajax").css('height',height); 
		}    
          
       
		
	},
    
    ///current width book
    widthBook:  function(){
         return $('#fb5-container-book').width();   
    },
    
    //current height book
    heightBook: function(){
         return $('#fb5-container-book').height();    
    },

	book_position: function() {
    
  
		var book_height	= this.heightBook();
		var book_width	= this.widthBook();
		
		var half_height	= (  (book_height/2)+this.toolsHeight/2   );
		var half_width	= (  book_width/2 );
        
        var x=$('#fb5').width()/2-half_width;
        var y=$('#fb5').height()/2-half_height+this.toolsHeight;
		$('#fb5-container-book').css({ left: x, top:y });
		
		/*footer position/*/
		var new_y=book_height+this.autoMarginT()+this.autoMarginB();
		//$("#fb5-footer").css({top:new_y+'px'});
		//$("#fb5").css('height',new_y+this.toolsHeight);
        
	},
    
    touchstart_book:function(e){
    
       this.book_x = e.originalEvent.touches[0].pageX;
       this.book_y = e.originalEvent.touches[0].pageY;
         
    },
    
    touchmove_book:function(e){
    
        //delta x
        this.book_x_delta=e.originalEvent.touches[0].pageX-this.book_x;
        this.book_x=e.originalEvent.touches[0].pageX;
        
        //delta y
        this.book_y_delta=e.originalEvent.touches[0].pageY-this.book_y;
        this.book_y=e.originalEvent.touches[0].pageY;
        
                
        var current_x= parseInt(  $('#fb5-container-book').css('left')  )
        var current_y= parseInt(  $('#fb5-container-book').css('top')  )
        
        var x=current_x+this.book_x_delta;
        var y=current_y+this.book_y_delta;
        $('#fb5-container-book').css( {left:x,top:y } ); 
        
        e.preventDefault();
        
        
        
        //var t=e.originalEvent.changedTouches[0].pageX
        
        //alert("move");
    
    },
    touchend_book:function(e){
    
    
        
           
    },    

	drag: function(e) {
		
		var el = $(this);
		var dragged = el.addClass('draggable');

		$('#fb5-container-book').unbind('mousemove');
		$('#fb5-container-book').bind('mousemove', Book_v5.book_grabbing);
        

        var d_h = dragged.outerHeight();
        var d_w = dragged.outerWidth();
        var pos_y = dragged.offset().top + d_h - e.pageY;
        var pos_x = dragged.offset().left + d_w - e.pageX;
        
		dragged.parents().unbind("mousemove");
        dragged.parents().bind("mousemove", function(e) {
            $('.draggable').offset({
                top:e.pageY + pos_y - d_h,
                left:e.pageX + pos_x - d_w
            });
        });
        e.preventDefault();
	},
	
	drop: function() {
		Book_v5.book_grab();
		$('#fb5-container-book').bind('mousemove', Book_v5.book_grab);
		$('#fb5-container-book').removeClass('draggable');
	},
    
    checkScrollBook: function () {
      
      var vertical=$('#fb5-book').height() > $("#fb5").height() - this.toolsHeight;
	  var horizontal=$('#fb5-book').width() > $("#fb5").width() - (this.arrow_width*2);
      
 	
	  if ( vertical || horizontal ) {
		higherThanWindow = true;
      } else {
		higherThanWindow = false;
	  }
	   return higherThanWindow;
    },

	dragdrop_init: function() {
		this.checkScrollBook();

		if ( higherThanWindow == false ) {
            //mobile
            $('#fb5-container-book').unbind('touchstart', Book_v5.touchstart_book);
            $('#fb5-container-book').unbind('touchmove', Book_v5.touchmove_book);
            $('#fb5-container-book').unbind('touchend', Book_v5.touchend_book);    
            
        
			$('#fb5-container-book').unbind('mousedown', Book_v5.drag);
			$('#fb5-container-book').unbind('mouseup', Book_v5.drop);
			$('#fb5-container-book').unbind('mousemove', Book_v5.book_grab);
			$('#fb5-container-book').unbind('mousemove', Book_v5.book_grabbing);
			$('#fb5-container-book').css('cursor', 'default');
		} else {
            //mobile
            $('#fb5-container-book').bind('touchstart', Book_v5.touchstart_book);
            $('#fb5-container-book').bind('touchmove', Book_v5.touchmove_book);
            $('#fb5-container-book').bind('touchend', Book_v5.touchend_book);
            
			$('#fb5-container-book').bind('mousedown', Book_v5.drag);
			$('#fb5-container-book').bind('mouseup', Book_v5.drop);
			$('#fb5-container-book').bind('mousemove', Book_v5.book_grab);
            Book_v5.book_grab();
		}
		Book_v5.resize_page();
	},
	
	scaleStart: function() {
		//if ( this.on_start == true ) {
			this.checkScrollBook();			
			//this.on_start = false;
		//}
	},
    
    setSize:function(w_,h_){
    
       $('#fb5-container-book').css({ width:w_, height:h_ });
	   $('#fb5-book').turn('size',w_,h_);
    
    },
    
    zoomTo:function(zoom_){
       
       this.zoom=zoom_;
         
       var new_width=(WIDTH_BOOK*this.zoom);
       var new_height=(HEIGHT_BOOK*this.zoom);
       
      
       this.setSize(new_width,new_height);
       this.scale_arrows()
       
       this.book_position();
       Book_v5.dragdrop_init();
       Book_v5.resize_page()
      
       
    },
    
    zoomOriginal:function(){
    
        this.zoomTo(1);
             
    },   
   
    scale_arrows:function(){
       
       var HEIGHT_ARROW=106;
       var WIDTH_ARROW=31;
       
       var height_arrow=this.heightBook()*0.45;
       if( height_arrow > HEIGHT_ARROW ){
         height_arrow=HEIGHT_ARROW;
       }
        
       
       var width_arrow= (height_arrow*WIDTH_ARROW)/HEIGHT_ARROW;
      
       this.zoom_arrows=height_arrow/HEIGHT_ARROW;   
         
           				$('.fb5-nav-arrow').css({'transform':'scale('+this.zoom_arrows+')','-ms-transform':'scale('+this.zoom_arrows+')','-webkit-transform':'scale('+this.zoom_arrows+')'});    
    },
    
	zoomAuto: function() {
				
		Book_v5.scaleStart();	
        
          
        ////resize one 
        var zoom=this.getAutoZoomBook(0);   
        this.zoomTo( zoom  ) 
          
		////resize two (with arrow)
        this.scale_arrows();
        var arrow_width=$('.fb5-nav-arrow').width()*this.zoom_arrows; 
        this.arrow_width=arrow_width;
        var zoom=this.getAutoZoomBook(arrow_width*2);
        //calculate optimal zoom
        zoom=Math.round(zoom * 100) / 100
        var percent=zoom*100;
        if(percent%2!=0){
          zoom=zoom-0.01;
        }
   		this.zoomTo( zoom   )

		Book_v5.resize_page()
      
	},
         
    getAutoZoomBook: function(arrow_width_){
       
        var book_width=this.widthBook();
		var book_height=this.heightBook();
		var screen_width	=  $("#fb5").width()-  ( this.autoMarginL()+this.autoMarginR() + (arrow_width_) );
		var screen_height	= $("#fb5").height()-this.toolsHeight-( this.autoMarginT()+this.autoMarginB()  )
 
		
		if(screen_width>WIDTH_BOOK){
		  screen_width=WIDTH_BOOK	
		}
		
		if(screen_height>HEIGHT_BOOK){
		  screen_height=HEIGHT_BOOK	
		}
		
		
		var scaleW=screen_width/book_width;
		var scaleH=screen_height/book_height;
		
		var scale=Math.min(scaleW,scaleH)	
		var new_width		= book_width*scale;
		var new_height		= book_height*scale;
        var auto_zoom= new_width/WIDTH_BOOK
        return auto_zoom;
    
    },

	zoomIn: function() {
       var zoom=this.zoom;  
       
        
       this.zoomTo(zoom+ZOOM_STEP  );
	},
	
	zoomOut: function() {
	   this.zoomTo( this.zoom-ZOOM_STEP );
	},
    
    resize_page: function (){
		
         /* RESIZE PAGE IN FLIPBOOK  /*/
         //resize class .fb5-page-book
         var page_width=this.widthBook()/2;
         var width_current_page=(page_width)
         var width_orginal_page=  ( WIDTH_BOOK/2 )     
         var zoom= (width_current_page / width_orginal_page);
         $('.fb5-cont-page-book').css({'transform':'scale('+zoom+')','-ms-transform':'scale('+zoom+')','-webkit-transform':'scale('+zoom+')'});
         ///center class .fb5-page-book
         var paddingL=(this.widthBook()*this.paddingL)/zoom;
         var paddingT=(this.widthBook()*this.paddingT)/zoom;
         $('.fb5-page-book').css({'left':paddingL+'px','top':paddingT+'px'});
            
         /* RESIZE ABOUT IN FLIPBOOK  /*/
         $('#fb5-about').css({'transform':'scale('+zoom+')','-ms-transform':'scale('+zoom+')','-webkit-transform':'scale('+zoom+')'});
         //padding top
         var padding_top=(this.heightBook()*0.05);
         $('#fb5-about').css('top',padding_top+'px');
         //height
         var height=(this.heightBook()-( padding_top*2) )/zoom;
         $('#fb5-about').css('height',height+'px');
         //width
         var width=(  (this.widthBook()/2)-( this.widthBook()*0.05  ) )/zoom;
         $('#fb5-about').css('width',width+'px');
		 
		 
		 //CENTER VERTICAL FOR HOME PAGE
		 //var posY=$('.fb5-page-book').height()/2 - $('#fb5 #fb5-cover ul').innerHeight()/2;
		 //$('#fb5 #fb5-cover ul').css('top',posY+'px');
		 
		 
	},
    
    resize_font:  function($size_original_,path_){
		var w=this.widthBook();
		var size= ($size_original_*w)/WIDTH_BOOK;
		var new_size=Math.round(parseInt(size))+"px";
		///$(path_).css('font-size',new_size);
		///$(path_).css('line-height',new_size);
        $(path_).css('font-size',$size_original_+"px");
		$(path_).css('line-height',$size_original_+"px");
	}
}


/* =  Navigation
--------------------------*/

var Navigation_v5 = {
	
	tooltip: function() {
    
    
		$('.fb5-menu li').filter(':not(.fb5-goto)').each(function() {
			var description = $('a', this).attr('title');
			var tooltip = '<span class="fb5-tooltip">'+description+'<b></b></span>';
			$('a', this).removeAttr("title");
			$(this).append(tooltip);
		});
		
		$('.fb5-menu li').mousemove(function(e) {
                        
            var tooltip=$('.fb5-tooltip', this);
			var offset = $(this).offset(); 
            var relY = e.pageY - offset.top;
            var x2= e.pageX-$('#fb5').offset().left+tooltip.width()  
            var width_area=$('#fb5').width()
            
            if( (x2+10)>width_area){
                var orient="right";
            }else{
            	var orient="left";
            }
            
            if(orient=="left"){
     			var relX = e.pageX - offset.left;
                $('#fb5 .fb5-tooltip b').css('left','6px')
            }else{
                var relX = e.pageX - offset.left-tooltip.width()-5;
                $('#fb5 .fb5-tooltip b').css('left',(tooltip.width()+6)+'px') 
            }			            
            
            //$('.fb5-tooltip', this).html( x2+" > "+width_area  );
			$('.fb5-tooltip', this).css({ left: relX, top: relY-45 });
		})
		
		$('.fb5-menu li').hover(function() { 
			$('.fb5-tooltip').stop();
			$('.fb5-tooltip', this).fadeIn();
		}, function() {
			$('.fb5-tooltip').hide();
		});
		
		Book_v5.resize_page()

	},


    ///event mouse down in book 
	book_mouse_down: function(){
   			$('#fb5-about').css('z-index',5);
			//Book_v5.resize_page();
	},
	
	book_mouse_up: function(e){
		 var offset = $(this).offset();
		 var relativeX = (e.pageX - offset.left);
         if( relativeX > ( WIDTH_BOOK / 2 )  ){
			//$('#fb5-about').css('z-index',11); 
		 }
	    
	},
	
	full_screen:function(){
		
		  $('#fb5-ajax').fullScreen({
         
         'callback': function(isFullScreen){         
             //Book_v5.book_area();
             //Book_v5.zoomAuto();
             //Book_v5.center_icon();
		     //Book_v5.center_icon();
		     $(window).trigger('orientationchange');
         
             if(isFullScreen){
                			
             }else{
               
             }
        
          }
         });
		
		
	},
	
	
	init: function() {

		// Double Click
        if(ZOOM_DOUBLE_CLICK_ENABLED=="true"){
		$('#fb5-book').dblclick(function() {
			           
            if(Book_v5.checkScrollBook()==false){ //zoom
                 Book_v5.zoomTo(ZOOM_DOUBLE_CLICK)
            }else{
               Book_v5.zoomAuto();
               $('#fb5-container-book').css('cursor', 'default');
            }
		});
        }


    //full screen
    $('.fb5-fullscreen').on('click', function() {
		
     			
     $('.fb5-tooltip').hide();
   
     Navigation_v5.full_screen();
     
   
     e.preventDefault();
            
	  });
         
		 
		//download
		
		 
		 
		 $('.fb5-download').on('click', function(event) {
     	 
		 
		  
		 
		 
		  //$.address.update();
		 // event.preventDefault();
		  
		}); 

	    // Home 
	    $('.fb5-home').on('click', function() {     	  
		  setPage(1);
	      //setAddress('book5-1');		  
		});
	
		// Zoom Original
		$('.fb5-zoom-original').click(function() {
			

            Book_v5.zoomOriginal();
      
			
		});
	
		// Zoom Auto
		$('.fb5-zoom-auto').on('click', function() {
			Book_v5.zoomAuto();
		});

		// Zoom In
		$('.fb5-zoom-in').on('click', function() {
			
				Book_v5.zoomIn();
				
							
		});
	
		// Zoom Out
		$('.fb5-zoom-out').on('click', function() {
			
				Book_v5.zoomOut();
				
		});

		// All Pages
		$('.fb5-show-all').on('click', function() {
			$('#fb5-all-pages').
				addClass('active').
				css('opacity', 0).
				animate({ opacity: 1 }, 1000);
			Book_v5.all_pages();
			return false;
		})
		
		// Goto Page
		$('#fb5-page-number').keydown(function(e) {
			if (e.keyCode == 13) {
               setPage( $('#fb5-page-number').val() );
            }
		});
		
		$('.fb5-goto button').click(function(e) {
            setPage( $('#fb5-page-number').val() );
		});


	
		
		//change z-index in about
		$('#fb5-book').bind('mousedown',this.book_mouse_down);
		$('#fb5-book').bind('mouseup',this.book_mouse_up);
		if (Book_v5.isiPhone()) {//for IPhone		
		$('#fb5-book').bind('touchstart',this.book_mouse_down);
		$('#fb5-book').bind('touchend',this.book_mouse_up);
		}

		//show tooltip for icon
		if ( !Book_v5.isiPhone() && TOOL_TIP_VISIBLE=="true" ) {
			this.tooltip();
		}
	}
}

 
/* = CONTACT FORM
--------------------------*/

function clear_on_focus() {
	$('input[type="text"], input[type="password"], textarea').each( function() {
		var startValue = $(this).val();
		$.data(this, "startValue", startValue);	
        this.value=startValue;
	})

	$('input[type="text"], input[type="password"], textarea').focus(function() {
		var startValue = $.data(this, "startValue");		
		if ( this.value == startValue ) {
			this.value = '';
		}
	});
	$('input[type="text"], input[type="password"], textarea').blur(function() {
        var startValue = $.data(this, "startValue");
		if ( this.value == '' ) {
			this.value = startValue;
		}
	})
}


function close_overlay() {
	$('.fb5-overlay').removeClass('active');
	setTimeout(function(){
	Book_v5.corner_change(false);
	},1000);
}






/*
 * $ Easing v1.3 - http://gsgd.co.uk/sandbox/$/easing/
 *
 * Uses the built in easing capabilities added In $ 1.1
 * to offer multiple easing options
*/

$.easing["jswing"]=$.easing["swing"];$.extend($.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return $.easing[$.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b+c;return-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b+c;return d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b+c;return-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){if((b/=e/2)<1)return d/2*b*b*b*b*b+c;return d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return b==0?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){if(b==0)return c;if(b==e)return c+d;if((b/=e/2)<1)return d/2*Math.pow(2,10*(b-1))+c;return d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){if((b/=e/2)<1)return-d/2*(Math.sqrt(1-b*b)-1)+c;return d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e)==1)return c+d;if(!g)g=e*.3;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158;var g=0;var h=d;if(b==0)return c;if((b/=e/2)==2)return c+d;if(!g)g=e*.3*1.5;if(h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);if(b<1)return-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c;return h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)*.5+d+c},easeInBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;return d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){if(f==undefined)f=1.70158;if((b/=e/2)<1)return d/2*b*b*(((f*=1.525)+1)*b-f)+c;return d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-$.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){if((b/=e)<1/2.75){return d*7.5625*b*b+c}else if(b<2/2.75){return d*(7.5625*(b-=1.5/2.75)*b+.75)+c}else if(b<2.5/2.75){return d*(7.5625*(b-=2.25/2.75)*b+.9375)+c}else{return d*(7.5625*(b-=2.625/2.75)*b+.984375)+c}},easeInOutBounce:function(a,b,c,d,e){if(b<e/2)return $.easing.easeInBounce(a,b*2,0,d,e)*.5+c;return $.easing.easeOutBounce(a,b*2-e,0,d,e)*.5+d*.5+c}})



})(jQuery)



 
