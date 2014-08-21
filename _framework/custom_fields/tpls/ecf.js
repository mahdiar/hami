jQuery(function ($) {
	if ($('form#post input[type=file]').length) {
		$('form#post').attr('enctype', 'multipart/form-data');
	}
	function enable_wp_write_panel_submit_button() {
		$('#ajax-loading').css('visibility', 'hidden');
		$('#publish').removeClass('button-primary-disabled');
	}
	$('.clone-ecf').live('click', function () {
	    var src_row = $(this).parents('tr')
	    var new_row = src_row.clone();
	    new_row.find('td:first').html('');
	    new_row.find('td:last').html('');
	    var field = new_row.find('input, textarea, select').eq(0);// .each(function () {
	    var related_fields = $('*[rel=' + field.attr('rel') + ']');
	    var new_id = field.attr('id') + '-' + related_fields.length;
	    field.attr('id', new_id);
	    field.val('');
		new_row.insertAfter(related_fields.eq(related_fields.length - 1).parents('tr:eq(0)'));
		$('p.ecf-description[rel=' + src_row.find('.ecf-description').attr('rel') + ']:not(:last)').hide();
		new_row.find('.ecf-description').show();
		field.focus();
		return false;
	});
	
	$('.delete-ecf').click(function () {
		var container = $(this).parents('tr:eq(0)');
	    var field = container.find('input, textarea, select').not('[name*=original_vals]');
	    field.remove();
	    container.hide();
	    return false;
	});
	
	if ($('img.radio_image').length){
	
		$('.ecf-set-list').each(function(){
		
			var saved = false;
			thisList = $(this);
			
			thisList.find('input[type=radio].ecf-ecf_fieldimageradio').each(function(){
				thisFieldSet = $(this);
			
				if (thisFieldSet.prop('checked')){
					saved = true;
					var thisID = thisFieldSet.attr('value');
					thisFieldSet.parents('.ecf-set-list').find('img.radio_image[rel='+thisID+']').addClass('active');
				}
			});
			
			if (saved == false){
				thisList.find('img.radio_image:first-child').addClass('active');
			}
			
		});
		
		$('img.radio_image').click(function(){
			var thisID = $(this).attr('rel');
			$(this).parent().find('img.radio_image').removeClass('active');
			$(this).addClass('active');
			$(this).parent().find('input[type=radio][value="'+thisID+'"]').prop('checked',true);
		});
	}

	$('.delete-file').click(function() {
		if (!confirm("Are you sure?")) {
			return false;
		}
	});
	
	$('.ecf-set-showall').click(function() {
		$(this).parent().hide().nextAll().show();	
		return false;
	});
	
	$('form#post').submit(function() {
		var required_fields = $('.ecf-field.required');
		for (var i=0; i < required_fields.length; i++) {
			var f = $(required_fields[i]);
			if (f.val()=='') {
				alert('Please enter ' + $('label[for=' + f.attr('id') + ']').html().toLowerCase());
				enable_wp_write_panel_submit_button();
				f.focus();
				return false;
			}
		}
	});
});