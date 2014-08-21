jQuery(function($) {


	// Page Layout - SETUP
	var page_layout = $("input:radio[name='_page_layout[]']:checked").val();
	if (typeof page_layout != 'undefined' && page_layout != 'default'){
		// Show Homepage Options
		$("input[name='_page_options[]']").parents(".ecf-field-container").hide();
		$("select[name=_projects_count]").parents(".ecf-field-container").show();
		$("select[name=_projects_sortby]").parents(".ecf-field-container").show();
		$("input[name=_projects_title]").parents(".ecf-field-container").show();
		$("input[name='_hide_featured_projects[]']").parents(".ecf-field-container").show();
	} else {
		// Show Default Options
		$("input[name='_page_options[]']").parents(".ecf-field-container").show();
		$("select[name=_projects_count]").parents(".ecf-field-container").hide();
		$("select[name=_projects_sortby]").parents(".ecf-field-container").hide();
		$("input[name=_projects_title]").parents(".ecf-field-container").hide();
		$("input[name='_hide_featured_projects[]']").parents(".ecf-field-container").hide();
	}
	
	// Page Layout - On Click
	var pagelayout_images = $('#page_settings_panel').find('img.radio_image');
	pagelayout_images.click(function(){
		var thisID = $(this).attr('rel');
		if (thisID != 'default'){
			$("input[name='_page_options[]']").parents(".ecf-field-container").slideUp('fast');
			$("select[name=_projects_count]").parents(".ecf-field-container").slideDown('fast');
			$("select[name=_projects_sortby]").parents(".ecf-field-container").slideDown('fast');
			$("input[name=_projects_title]").parents(".ecf-field-container").slideDown('fast');
			$("input[name='_hide_featured_projects[]']").parents(".ecf-field-container").slideDown('fast');
		} else {
			$("input[name='_page_options[]']").parents(".ecf-field-container").slideDown('fast');
			$("select[name=_projects_count]").parents(".ecf-field-container").slideUp('fast');
			$("select[name=_projects_sortby]").parents(".ecf-field-container").slideUp('fast');
			$("input[name=_projects_title]").parents(".ecf-field-container").slideUp('fast');
			$("input[name='_hide_featured_projects[]']").parents(".ecf-field-container").slideUp('fast');
		}
		
	});
	
	
	// Sidebar Choice - SETUP
	$('select[name=_sidebar_choice]').parents('.ecf-field-container').hide();
	var sidebar_choice = $("input:radio[name='_sidebar_layout[]']:checked").val();
	if (typeof sidebar_choice != 'undefined' && sidebar_choice != 'no-sidebar'){
		$('select[name=_sidebar_choice]').parents('.ecf-field-container').show();
	}
	
	// Sidebar Choice - On Click
	var sidebar_images = $('#sidebar_settings_panel').find('img.radio_image');
	sidebar_images.click(function(){
		var thisID = $(this).attr('rel');
		if (thisID != 'no-sidebar'){
			$('select[name=_sidebar_choice]').parents('.ecf-field-container').slideDown('fast');
		} else {
			$('select[name=_sidebar_choice]').parents('.ecf-field-container').slideUp('fast');
		}
	});
	
	
	// Page Widgets - SETUP
	$('select[name=_widget_layout]').parents('.ecf-field-container').hide();
	var widget_choice = $("input:radio[name='_widget_layout[]']:checked").val();
	if (typeof widget_choice === 'undefined' || widget_choice == 'no-widgets'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (widget_choice == 'one'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (widget_choice == 'two'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (widget_choice == 'three'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (widget_choice == 'four'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').show();
	} else if (widget_choice == 'onethird_twothird'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (widget_choice == 'onethird_twothird' || widget_choice == 'twothird_onethird'){
		$('select[name=_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_widget_block_4]').parents('.ecf-field-container').hide();
	}
	
	// Page Widgets - On Click
	var widget_choice = $('#widget_settings_panel').find('img.radio_image');
	widget_choice.click(function(){
		var thisID = $(this).attr('rel');
		if (thisID == 'no-widgets'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'one'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'two'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'three'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'four'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideDown('fast');
		} else if (thisID == 'onethird_twothird'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'onethird_twothird' || thisID == 'twothird_onethird'){
			$('select[name=_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		}
	});
	
	
	// Campaign Widgets - SETUP
	$('select[name=_campaigns_widget_layout]').parents('.ecf-field-container').hide();
	var campaign_choice = $("input:radio[name='_campaigns_widget_layout[]']:checked").val();
	if (typeof campaign_choice === 'undefined' || campaign_choice == 'no-widgets'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (campaign_choice == 'one'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (campaign_choice == 'two'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (campaign_choice == 'three'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (campaign_choice == 'four'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').show();
	} else if (campaign_choice == 'onethird_twothird'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	} else if (campaign_choice == 'onethird_twothird' || campaign_choice == 'twothird_onethird'){
		$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').show();
		$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').hide();
		$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').hide();
	}
	
	// Campaign Widgets - On Click
	var campaign_choice = $('#campaigns_widget_settings_panel').find('img.radio_image');
	campaign_choice.click(function(){
		var thisID = $(this).attr('rel');
		if (thisID == 'no-widgets'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'one'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'two'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'three'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'four'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideDown('fast');
		} else if (thisID == 'onethird_twothird'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		} else if (thisID == 'onethird_twothird' || thisID == 'twothird_onethird'){
			$('select[name=_campaigns_widget_block_1]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_2]').parents('.ecf-field-container').slideDown('fast');
			$('select[name=_campaigns_widget_block_3]').parents('.ecf-field-container').slideUp('fast');
			$('select[name=_campaigns_widget_block_4]').parents('.ecf-field-container').slideUp('fast');
		}
	});
	
	
	// "Feature" Blocks - SETUP
	
	$('.wrap-this-one').wrapAll('<div id="feature_1_block_wrap" class="feature-block-wrap" />');
	$('.wrap-this-two').wrapAll('<div id="feature_2_block_wrap" class="feature-block-wrap" />');
	$('.feature-block-wrap').append('<div class="cl"></div>');
	
	$('select[name=_feature_block_layout]').parents('.ecf-field-container').hide();
	var feature_block_choice = $("input:radio[name='_feature_block_layout[]']:checked").val();
	if (typeof feature_block_choice === 'undefined' || feature_block_choice == 'no-features'){
		$('input[name=_feature_1_title]').parents('.feature-block-wrap').hide();
		$('input[name=_feature_2_title]').parents('.feature-block-wrap').hide();
		$('#feature_1_block_wrap').removeClass('one_half');
		$('#feature_2_block_wrap').removeClass('one_half');
	} else if (feature_block_choice == 'one-feature'){
		$('input[name=_feature_1_title]').parents('.feature-block-wrap').show();
		$('input[name=_feature_2_title]').parents('.feature-block-wrap').hide();
		$('#feature_1_block_wrap').removeClass('one_half');
		$('#feature_2_block_wrap').removeClass('one_half');
	} else if (feature_block_choice == 'two-features'){
		$('input[name=_feature_1_title]').parents('.feature-block-wrap').show();
		$('input[name=_feature_2_title]').parents('.feature-block-wrap').show();
		$('#feature_1_block_wrap').addClass('one_half');
		$('#feature_2_block_wrap').addClass('one_half last');
	}
	
	// "Feature" Blocks - On Click
	var feature_block_choice = $('#features_settings_panel').find('img.radio_image');
	feature_block_choice.click(function(){
		var thisID = $(this).attr('rel');
		if (thisID == 'no-features'){
			$('input[name=_feature_1_title]').parents('.feature-block-wrap').slideUp('fast');
			$('input[name=_feature_2_title]').parents('.feature-block-wrap').slideUp('fast');
			$('#feature_1_block_wrap').removeClass('one_half');
			$('#feature_2_block_wrap').removeClass('one_half');
		} else if (thisID == 'one-feature'){
			$('input[name=_feature_1_title]').parents('.feature-block-wrap').slideDown('fast');
			$('input[name=_feature_2_title]').parents('.feature-block-wrap').hide();
			$('#feature_1_block_wrap').removeClass('one_half');
			$('#feature_2_block_wrap').removeClass('one_half');
		} else if (thisID == 'two-features'){
			$('input[name=_feature_1_title]').parents('.feature-block-wrap').slideDown('fast');
			$('input[name=_feature_2_title]').parents('.feature-block-wrap').slideDown('fast');
			$('#feature_1_block_wrap').addClass('one_half');
			$('#feature_2_block_wrap').addClass('one_half last');
		}
	});
	

});