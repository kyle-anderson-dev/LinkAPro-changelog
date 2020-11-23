// JavaScript Document
jQuery(document).ready(function() {
    'use strict';
	
	var ratingflag = 1;
	var rating = '';
	var feedbookingid;
	var $jobqa = [];
	var $qa = [];
	var bootboxdialog;
	var owlflag = 0;
	var $owl;
	
	/*jQuery('body').on('click', '.finishjobqa', function(){
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
		bootboxdialog.modal('hide');
	});*/
	
	/*jQuery('body').on('change', '#job_category', function(){
			var catid = jQuery(this).val();											  
			jQuery('.loading-area').show();												

			var qualificationid = jQuery(this).attr('data-id');
	
			var data = {
				  "action": "load_jobqa_form",
				  "catid": catid
				};
	
		  var formdata = jQuery.param(data);
	
		  jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: formdata,
			dataType: "json",
			success:function (data, textStatus) {
			jQuery('#jobqaform').html(data['html']).end();
			jQuery('.jobqaans').bootstrapToggle(true);
			jQuery('#finishjobouter').hide();
			
		    $owl = jQuery(".owl-carousel-jobqa").owlCarousel({
				items:1,									   
				loop:false,
				margin:0,
				dots: false,
				nav:true,
				rewindNav: true,
				navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
			})
			/*if(owlflag == 1)
			{
			$owl.trigger('resized.owl.carousel');	
			}
			owlflag = 1;
			
			
			
			jQuery('.owl-carousel-jobqa').on('changed.owl.carousel', function(e) {
			  if (e.item.index+1 == e.item.count) {
				jQuery('#finishjobouter').show();
			  }
			});
			// Show the dialog
			bootboxdialog = bootbox
				.dialog({
					title: 'Job QA',
					message: jQuery('#jobqaform'),
					show: false
				})
				.on('shown.bs.modal', function() {
					jQuery('.loading-area').hide();
					jQuery('#jobqaform')
					.show();
				})
				.on('hide.bs.modal', function(e) {
					jQuery('#jobqaform').hide().appendTo('body');
				})
				.modal('show');
			},
			error:function (data, textStatus) {
				jQuery('.loading-area').hide();
			}
	
			});
	});*/
	
	jQuery('body').on('click', '.viewjobqa', function(){
												  
			jQuery('.loading-area').show();												

			var jobid = jQuery(this).data('id');
	
			var data = {
				  "action": "viewjobqa",
				  "jobid": jobid
				};
	
		  var formdata = jQuery.param(data);
	
		  jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: formdata,
			dataType: "json",
			success:function (data, textStatus) {
			//jQuery('#viewjobqa').html(data['html']).end();
			
		    
			// Show the dialog
			bootboxdialog = bootbox
				.dialog({
					title: 'Job QA',
					message: data['html'],
					show: false
				})
				.on('shown.bs.modal', function() {
					jQuery('.loading-area').hide();
					/*jQuery('#viewjobqa')
					.show();*/
				})
				.on('hide.bs.modal', function(e) {
					//jQuery('#viewjobqa').hide().appendTo('body');
				})
				.modal('show');
			},
			error:function (data, textStatus) {
				jQuery('.loading-area').hide();
			}
	
			});
	});
	
	
	/*Pay for contact details*/
	jQuery('body').on('click', '.payforcontact', function(){
			var providerid = jQuery(this).data('providerid');
			var walletamount = jQuery(this).data('walletamount');
			var jobid = jQuery(this).data('jobid');
			var contactcost = jQuery(this).data('contactcost');
			
			bootbox.dialog({
                title: "Pay To View Contact Details",
                message: '<div class="row">  ' +
                    '<div class="col-md-12"> ' +
					'<div class="pix-wallet-amount"><strong>Available Credit:</strong> <span>'+walletamount+'</span></div> ' +
					'<div class="pix-pay-amount"><strong>Pay Credit:</strong> <span>'+contactcost+'</span></div> ' +
					'<div class="pix-pay-button"><a href="javascript:;" class="btn btn-success paycontactlink" data-providerid="'+providerid+'" data-walletamount="'+walletamount+'" data-contactcost="'+contactcost+'" data-jobid="'+jobid+'">Pay</a></div> ' +
                    '</div>  </div>',
                buttons: {
                    success: {
                        label: "Cancel",
                        className: "btn-danger",
                        callback: function () {
                        }
                    }
                }
            })
			.on('shown.bs.modal',function () {
                
            });
	});
	
	 jQuery('body').on('click', '.paycontactlink', function(){
			var providerid = jQuery(this).data('providerid');
			var walletamount = jQuery(this).data('walletamount');
			var jobid = jQuery(this).data('jobid');
			var contactcost = jQuery(this).data('contactcost');
			
			if(walletamount < contactcost)
			{
				jQuery( "<div class='alert alert-danger'>Wallet amount must be greater than "+currencysymbol+contactcost+"</div>" ).insertBefore( ".sf-job-info-section" );
				bootbox.hideAll();
				return false;
			}
			
			var data = {
			  "action": "pay_for_conatct",
			  "providerid": providerid,
			  "jobid": jobid,
			  "walletamount": walletamount,
			  "contactcost": contactcost
			};
			
			var formdata = jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery(".alert-success,.alert-danger").remove();
							jQuery('.loading-area').show();
						},
						
						data: formdata,

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( ".sf-job-info-section" );	
								jQuery('#pix-contact-info').html(data['contactdetails']);
								jQuery('#pix-purchased-contacts').html(data['totalpurchased']);
								jQuery('.payforcontact').remove();
								jQuery('.jobavlcredits').remove();
								jQuery('.jobclosed').remove();
								jQuery('.pixjobapplybtn').show();
								bootbox.hideAll();
							}
						},
						error:function (data, textStatus) {
							jQuery('.loading-area').hide();
						}

					});
			
	 }); 
	
	jQuery('.jobattachment-update')
        .bootstrapValidator({
            message: param.not_valid,
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {}
        })
		.on('error.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false); // disable submit buttons on errors
	    })
		.on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false); // disable submit buttons on valid
        })
        .on('success.form.bv', function(form) {
            form.preventDefault();
			
			// Get the form instance
            var $form = jQuery(form.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
			var data = {
			  "action": "save_job_attachment",
			};
			
			var formdata = jQuery($form).serialize() + "&" + jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery(".alert-success,.alert-danger").remove();
							jQuery('.loading-area').show();
						},
						
						data: formdata,

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							$form.find('button[type="submit"]').prop('disabled', false);
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( "form.jobattachment-update" );
							}else if(data['status'] == 'error'){
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( "form.jobattachment-update" );
							}
							
						}

					});
			
        });
	
	/*Select Action*/
	 jQuery('body').on('change', '.jobOptionSelect', function(){
	 var option = jQuery(this).val();
	 var bid = jQuery(this).attr('data-bid');
	 if(option != ""){
	 jQuery('.loading-area').show();															
	 }
	if(option == 'addfeedback'){
		feedbookingid = bid;
	 
		 var data = {
				  "action": "get_ratingbox",
				  "feedbookingid": feedbookingid,
				};
				
		  var formdata = jQuery.param(data);
		  
		  jQuery.ajax({
	
							type: 'POST',
	
							url: ajaxurl,
	
							data: formdata,
							
							success:function (data, textStatus) {
								jQuery('#customrating').html(data);
								
								jQuery(".add-custom-rating").rating({
									stars: 5,
									starCaptions: function(val) {
										return ' ';
									},
									starCaptionClasses: function(val) {
										if (val <= 1) {
											return 'aon-icon-angry';
										} else if (val <= 2){
											return 'aon-icon-cry';
										} else if (val <= 3){
											return 'aon-icon-sad';
										} else if (val <= 4){
											return 'aon-icon-happy';
										} else if (val <= 5){
											return 'aon-icon-awesome';
										}
									},
									clearCaptionClass: '',
									clearButton: '',
									clearCaption: '',
									hoverOnClear: false
								});
							}
	
						});
		
		// Show the dialog
		bootbox
			.dialog({
				title: param.add_feedback,
				message: jQuery('#addFeedback'),
				show: false // We will show it manually later
			})
			.on('shown.bs.modal', function() {
				jQuery('.loading-area').hide();
				jQuery('#addFeedback')
					.show()                             // Show the login form
					.bootstrapValidator('resetForm'); // Reset form
			})
			.on('hide.bs.modal', function(e) {
				// Bootbox will remove the modal (including the body which contains the login form)
				// after hiding the modal
				// Therefor, we need to backup the form
				jQuery('#addFeedback').hide().appendTo('body');
			})
			.modal('show');	
	 
	 }
	else if(option == 'viewfeedback'){
		feedbookingid = bid;
	 
	 var data = {
			  "action": "show_feedback",
			  "feedbookingid": feedbookingid,
			};
			
	  var formdata = jQuery.param(data);
	  
	  jQuery.ajax({

						type: 'POST',

						url: ajaxurl,

						data: formdata,
						
						dataType: "json",

						success:function (data, textStatus) {
							// Populate the form fields with the data returned from server
							if(data['ratingtype'] == 'custom'){
								jQuery('#viewFeedback')
								.find('#showcomment').html(data['comment']).end();
								
								jQuery('#displaycustomrating').html(data['customrating']);
								jQuery('.display-ratings').rating();
								jQuery('.sf-show-rating').show();
							}else{
							jQuery('#viewFeedback')
								.find('#show-comment-rating').rating('update', data['rating']).end()
								.find('#showcomment').html(data['comment']).end();
								
							jQuery("#show-comment-rating, #show-booking-rating").rating({
								showClear:false, 
				                disabled:true,																	  
								starCaptions: function(val) {
									if (val < 3) {
										return val;
									} else {
										return 'high';
									}
								},
								starCaptionClasses: function(val) {
									if (val < 3) {
										return 'label label-danger';
									} else {
										return 'label label-success';
									}
								},
								hoverOnClear: false
							});	
							}

							// Show the dialog
							bootbox
								.dialog({
									title: param.feedback,
									message: jQuery('#viewFeedback'),
									show: false // We will show it manually later
								})
								.on('shown.bs.modal', function() {
									jQuery('.loading-area').hide();
									jQuery('#viewFeedback')
										.show()                             // Show the login form
										.bootstrapValidator('resetForm'); // Reset form
								})
								.on('hide.bs.modal', function(e) {
									// Bootbox will remove the modal (including the body which contains the login form)
									// after hiding the modal
									// Therefor, we need to backup the form
									jQuery('#viewFeedback').hide().appendTo('body');
								})
								.modal('show');
							
						}

					});
	  
	 
	 }
	else if(option == 'completebooking'){
	jQuery('.loading-area').hide();	
	var bid = jQuery(this).attr('data-bid');														  
	bootbox.confirm(param.complete_booking_and_pay, function(result) {
		  if(result){
			  var data = {
			  "action": "complete_booking",
			  "bookingid": bid,
			};
			
			var data = jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						data: data,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery('.loading-area').show();
							jQuery('.alert').remove();
						},

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( ".sf-table-outer" );	
								window.location.reload();
							}else if(data['status'] == 'error'){
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( ".sf-table-outer" );
							}
						}

					});
			  }
		}); 
	}
	else if(option == 'completebookingandpay'){
	jQuery('.loading-area').hide();	
	var bid = jQuery(this).attr('data-bid');														  
	var paykey = jQuery(this).data('paykey');
	var providerid = jQuery(this).data('providerid');
	
	bootbox.confirm(param.complete_booking_and_pay, function(result) {
		  if(result){
			  var data = {
			  "action": "complete_booking_and_pay",
			  "bookingid": bid,
			  "providerid": providerid, 
			  "paykey": paykey 
			};
			
			var data = jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						data: data,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery('.alert').remove();
							jQuery('.loading-area').show();
						},

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( ".sf-table-outer" );	
							}else if(data['status'] == 'error'){
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( ".sf-table-outer" );
							}
						}

					});
			  }
		}); 
	}
	else if(option == 'completebookingandpayviastripe'){
	jQuery('.loading-area').hide();	
	var bid = jQuery(this).attr('data-bid');														  
	var amount = jQuery(this).data('amount');
	var providerid = jQuery(this).data('providerid');
	
	bootbox.confirm(param.complete_booking_and_pay, function(result) {
		  if(result){
			  var data = {
			  "action": "complete_booking_and_pay_via_stripe",
			  "bookingid": bid,
			  "providerid": providerid, 
			  "amount": amount 
			};
			
			var data = jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						data: data,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery('.alert').remove();
							jQuery('.loading-area').show();
						},

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( ".sf-table-outer" );	
							}else if(data['status'] == 'error'){
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( ".sf-table-outer" );
							}
						}

					});
			  }
		}); 
	}
	else if(option == 'recommendedproviders'){
	jQuery('.loading-area').hide();	
	var recommendedprovidersurl = jQuery(this).data('recommendedproviders');
	
	window.location.href = recommendedprovidersurl;
	return false;
	
	}
	});
	 
	 /*Save Feeback*/				  
	jQuery('.add-feedback')
        .bootstrapValidator({
            message: param.not_valid,
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
				'comment-rating': {
					validators: {
						notEmpty: {
							message: param.rating
						},
						greaterThan: {
							value: 0,
							message: param.rating
						},
					}
				},
				comment: {
					validators: {
						notEmpty: {
							message: param.comment
						}
					}
				},
            }
        })
		.on('error.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false); // disable submit buttons on errors
	    })
		.on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false); // disable submit buttons on valid
        })
        .on('success.form.bv', function(form) {
            // Prevent form submission
			if(jQuery("#comment-rating").val()==0){
				ratingflag = 1;
				jQuery('.rating_bx small').first().show(); 
				jQuery('.rating_bx').addClass('has-error').removeClass('has-success'); 
				jQuery('form.add-feedback').find('input[type="submit"]').prop('disabled', false);
				}else{
				ratingflag = 0;
				jQuery('.rating_bx small').first().hide(); 
				jQuery('.rating_bx').removeClass('has-error').addClass('has-success'); 
				jQuery('form.add-feedback').find('input[type="submit"]').prop('disabled', false);
				}
			
			
			
			if(ratingflag==1){form.preventDefault();return false;}
			form.preventDefault();
			
            // Get the form instance
            var $form = jQuery(form.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
			
			rating = jQuery("#comment-rating").val();
			
			var data = {
			  "action": "add_feedback",
			  "booking_id": feedbookingid,
			  "rating":rating,
			  "user_id": user_id
			};
			
			var formdata = jQuery($form).serialize() + "&" + jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery(".alert").remove();
							jQuery('.loading-area').show();
						},
						
						data: formdata,

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							
							if(data['status'] == 'success'){
								jQuery("#comment").val('');
								/*Close the popup window*/
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( ".sf-table-outer" );	
								$form.parents('.bootbox').modal('hide');
								window.location.reload();
								
							}else if(data['status'] == 'error'){
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( "form.add-feedback" );
							}
							
							
						
						}

					});
			
        });
	
	jQuery('body').on('click', '.provider_description', function(){
	
	var providerid = jQuery(this).data('providerid');
	var jobid = jQuery(this).data('jobid');

	var data = {
	   action: 'get_quote_description',
	   providerid: providerid, 
	   jobid: jobid 
	};
	
	jQuery.ajax({
	
		type: 'POST',

		url: ajaxurl,

		data: data,
		
		beforeSend: function() {
			jQuery('.loading-area').show();
		},

		success:function (data, textStatus) {
			jQuery('.loading-area').hide();
			bootbox.alert(data);
		}

	});
	
	});
	
	/*Job Apply Form*/
	jQuery('.applyforjob')
	.bootstrapValidator({
		message: 'This value is not valid',
		feedbackIcons: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			description: {
				validators: {
					notEmpty: {}
				}
			},
		}
	})
	.on('error.field.bv', function(e, data) {
		data.bv.disableSubmitButtons(false); // disable submit buttons on errors
	})
	.on('status.field.bv', function(e, data) {
		data.bv.disableSubmitButtons(false); // disable submit buttons on valid
	})
	.on('success.form.bv', function(form) {
			// Prevent form submission
			form.preventDefault();

			// Get the form instance
			var $form = jQuery(form.target);
			// Get the BootstrapValidator instance
			var bv = $form.data('bootstrapValidator');
			
			var data = {
			  "action": "applyjobform"
			};
			
			var formdata = jQuery($form).serialize() + "&" + jQuery.param(data);
			
			jQuery.ajax({

						type: 'POST',

						url: ajaxurl,
						
						dataType: "json",
						
						beforeSend: function() {
							jQuery(".alert").remove();
							jQuery('.loading-area').show();
						},
						
						data: formdata,

						success:function (data, textStatus) {
							jQuery('.loading-area').hide();
							jQuery('form.applyforjob').find('input[type="submit"]').prop('disabled', false);	
							if(data['status'] == 'success'){
								jQuery( "<div class='alert alert-success'>"+data['suc_message']+"</div>" ).insertBefore( "form.applyforjob" );	
								jQuery("#applybtn").html('<a href="javascript:;" class="btn btn-primary">'+param.applied+'</a>');
								jQuery('#job-apply-form').modal('hide');
							}else{
								jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( "form.applyforjob" );
							}
						
						}

					});
	});
	
	/*Show Applicants*/
	jQuery('body').on('click', '.show_applicants', function(){
		var jobid = jQuery(this).data('jobid');	
		jQuery('#job-manager-job-dashboard').hide();
		jQuery('#job-manager-job-applicants').show();
		
		var data = {
			  "action": "applicants_listing",
			  "jobid": jobid
			};
			
		var formdata = jQuery.param(data);
		
		jQuery.ajax({

		type: 'POST',

		url: ajaxurl,
		
		dataType: "json",
		
		beforeSend: function() {
			jQuery(".alert").remove();
			jQuery('.loading-area').show();
		},
		
		data: formdata,

		success:function (data, textStatus) {
			jQuery('.loading-area').hide();
			jQuery('form.applyforjob').find('input[type="submit"]').prop('disabled', false);	
			if(data['status'] == 'success'){
				jQuery('#applicants-listing').html(data['applicants']);
				jQuery('[data-toggle="tooltip"]').tooltip();
			}else{
				jQuery( "<div class='alert alert-danger'>"+data['err_message']+"</div>" ).insertBefore( ".applicants-listing" );
			}
		
		}
	});

	});
	
	/*Hire provider if booking is off*/
	jQuery('body').on('click', '.hire_if_booking_off', function(){
		var jobid = jQuery(this).data('jobid');
		var providerid = jQuery(this).data('providerid');
		
		bootbox.confirm(param.hire_if_booking_off_msg, function(result) {
	    if(result){

		var data = {
			  "action": "hire_if_booking_off",
			  "jobid": jobid,
			  "providerid": providerid
			};
			
		var formdata = jQuery.param(data);
		
		jQuery.ajax({

		type: 'POST',

		url: ajaxurl,
		
		dataType: "json",
		
		beforeSend: function() {
			jQuery(".alert").remove();
			jQuery('.loading-area').show();
		},
		
		data: formdata,

		success:function (data, textStatus) {
			jQuery('.loading-area').hide();
			if(data['status'] == 'success'){
				//bootbox.alert(data['suc_message']);
				bootbox.confirm({
					message: data['suc_message'],
					buttons: {
						confirm: {
							label: 'Continue',
							className: 'btn-success'
						},
						cancel: {
							label: 'Remain on Same Page',
							className: 'btn-info'
						}
					},
					callback: function (result) {
						if(result){
							window.location.href = data['link'];
						}else{
							jQuery('.hire_if_booking_off').remove();
							jQuery( "<a href='javascript:;' class='btn btn-primary'>Hired <i class='fa fa-user'></i></a>" ).insertAfter( "#proid-"+providerid+" .mark-fullview" );
						}
					}
				});
			}
		
		}
	});
		
		}
		}); 

	});
	
	/*Show Applicants*/
	jQuery('body').on('click', '.gotodashboard', function(){
		jQuery('#job-manager-job-dashboard').show();
		jQuery('#job-manager-job-applicants').hide();
	});
	
});