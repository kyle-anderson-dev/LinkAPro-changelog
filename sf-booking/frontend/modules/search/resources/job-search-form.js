/*****************************************************************************

*

*	copyright(c) - sedatelab.com - SedateTheme

*	More Info: http://sedatelab.com/

*	Coder: SedateLab Team

*	Email: sedatelab@gmail.com

*

******************************************************************************/



// When the browser is ready...

jQuery(function() {
if ( jQuery( "#pixjob-qaform" ).length ) {				
var owlflag = 0;
var $owl;
var $jobqa = [];
var $qa = [];

jQuery('body').on('click', '.finishjobqa', function(){
		var i = 0;
		jQuery("#jobqa-main .jobqa-item-box").each( function() {														
			var $qa = [];
			var question = jQuery(this).find('.jobqa-question').html();
			var answere = jQuery(this).find('.jobqaans').prop("checked");
			//alert(answere);
			if(answere == true)
			{
				var ans = 'yes';
			}else
			{
				var ans = 'no';
			}
			$qa[0] = question;
			$qa[1] = ans;
			$jobqa[i] = $qa;
			//alert(JSON.stringify($jobqa, null, 4));
			i++;
		});						
		
		var $jobqaobj = JSON.stringify($jobqa);
		//alert(JSON.stringify($jobqaobj, null, 4));
		jQuery('input[name="jobqastring"]').val($jobqaobj);
		//bootboxdialog.modal('hide');
	});

jQuery('.jobqaans').bootstrapToggle(true);
jQuery('#finishjobouter').hide();

$owl = jQuery(".slider-jobqas").owlCarousel({
	items:1,									   
	loop:false,
	margin:0,
	dots: false,
	nav:true,
	rewindNav: true,
	navText: ['<i class="fa fa-chevron-left"></i>PREV', 'NEXT<i class="fa fa-chevron-right"></i>'],
});




/*if(owlflag == 1)
{
$owl.trigger('resized.owl.carousel');	
}*/
owlflag = 1;


jQuery('.owl-carousel-jobqa').on('changed.owl.carousel', function(e) {
  //alert(e.item.index+1);alert(e.item.count);
  if (e.item.index+1 == e.item.count) { 
	jQuery('#finishjobouter').show(); 
  }
});				
}

if ( jQuery( "#catautocomplete" ).length ) {
	jQuery( 'body' ).on( 'click', '.aon-cat-clean', function ()
	{
		jQuery( "#catautocomplete" ).val('');
		jQuery( this ).hide();
	} );
	
	jQuery( "#catautocomplete" ).autocomplete({
	  maxShowItems: 6,
	  minLength: 0,
	  source: function( request, response ) {
        var searchParam  = request.term;
		var data = {
			action    : 'load_jobcategory_data',
			string    : searchParam
		};
		
		var formdata = jQuery.param(data);
		
		jQuery.ajax({
			type : "post",
			dataType : "json",
			url : ajaxurl,
			data : formdata,
			success: function(result) {
				section_toggle_loading('hide');
				
				response(jQuery.map(result.data.catlist, function (item) {
					 return {
						 label: item.label,
						 value: item.value
					 };
					 
				 }));
				//categoriesAutoDropdown();
				jQuery( ".aon-cat-clean" ).show();
			},
			error: function(response) {
				 
			}
	  });
    },  
	//source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ]
	}).focus(function(){     
		jQuery(this).autocomplete("search", jQuery(this).val());
	});
	}
	
	function section_toggle_loading(status)
	{
		if(status == 'show')
		{
			jQuery('.section-loading-area').show();
		}else if(status == 'hide')
		{
			jQuery('.section-loading-area').hide();	
		}
	}
});

	
