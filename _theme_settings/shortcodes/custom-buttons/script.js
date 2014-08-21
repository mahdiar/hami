// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_customButtons', {
	
		init : function(ed, url) {  
            ed.addButton('js_customButtons_button', {  
                title : 'Add a Button',  
                image : url+'/icon_button.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Add a Button', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_customButtons-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_customButtons', tinymce.plugins.js_customButtons);
	
	// executes this when the DOM is ready
	jQuery(function(){
	
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_customButtons-form"><div class="shortcode-form">\
			<h2>Add a Button</h2>\
			<table id="js_customButtons-table" class="form-table">\
			<tr>\
				<th><label for="js_customButtons-size">Button Size</label></th>\
				<td><select name="size" id="js_customButtons-size">\
					<option value="large">Large</option>\
					<option value="small">Small</option>\
					<option value="mini">Mini</option>\
				</select><br />\
				<small>Specify the size of the button to display.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_customButtons-content">Button Text</label></th>\
				<td><input name="url" id="js_customButtons-content" type="text" /><br />\
				<small>Specify the text that should show up in the button.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_customButtons-url">Button URL</label></th>\
				<td><input name="url" id="js_customButtons-url" type="text" /><br />\
				<small>Specify the URL to where the button should link.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_customButtons-submit" class="button-primary" value="Add Button" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_customButtons-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'size'      : '',
				'url'		: '',
				'content'	: ''
				};
			var shortcode = '[button';
			
			for( var index in options) {
				var currentInput = table.find('#js_customButtons-' + index);
				var type = currentInput.attr('type');
				if (type == 'checkbox' || type == 'radio'){
					if (currentInput.is(':checked')){
						var value = currentInput.val();
					} else {
						var value = '';
					}
				} else {
					var value = currentInput.val();
				}
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()