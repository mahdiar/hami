// closure to avoid namespace collision
(function(){

	var edTest = '';

	// creates the plugin
	tinymce.create('tinymce.plugins.js_columns', {
	
		init : function(ed, url) {  
            ed.addButton('js_columns_button', {  
                title : 'Add Column',  
                image : url+'/icon_columns.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					edTest = ed;
					tb_show( 'Add Column', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_columns-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_columns', tinymce.plugins.js_columns);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_columns-form"><div class="shortcode-form">\
			<h2>Add Column</h2>\
			<table id="js_columns-table" class="form-table">\
			<tr>\
				<th><label for="js_columns-size">Column Size</label></th>\
				<td><select name="size" id="js_columns-size">\
					<option value="one_third">One Third (1/3)</option>\
					<option value="two_third">Two Thirds (2/3)</option>\
					<option value="one_half">One Half (1/2)</option>\
					<option value="one_fourth">One Fourth (1/4)</option>\
					<option value="three_fourth">Three Fourths (3/4)</option>\
					<option value="one_fifth">One Fifth (1/5)</option>\
					<option value="two_fifth">Two Fifths (2/5)</option>\
					<option value="three_fifth">Three Fifths (3/5)</option>\
					<option value="four_fifth">Four Fifths (4/5)</option>\
					<option value="one_sixth">One Sixth (1/6)</option>\
					<option value="five_sixth">Five Sixths (5/6)</option>\
				</select><br />\
				<small>Specify a column size to use.</small></td>\
			</tr>\
			<tr>\
				<th><label>Is this the last column in the row?</label></th>\
				<td><input type="checkbox" name="last" id="js_columns-last" value="1" /> <label for="js_columns-last">Last Column</label><br />\
				<small>Check this to end a row of columns.</small>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_columns-submit" class="button-primary" value="Add Column" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_columns-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'size'  : '',
				'last'	: ''
				};
			
			for( var index in options) {
				var currentInput = table.find('#js_columns-' + index);
				var type = currentInput.attr('type');
				if (index == 'size'){
					var value = currentInput.val();
					var shortcode = '['+value;
				}
				if (index == 'last'){
					if (currentInput.is(':checked')){
						shortcode += '_last';
					}
				}
			}
			
			var selectedContent = tinyMCE.activeEditor.selection.getContent();
			
			shortcode += ']';
			endShortcode = shortcode.replace('[','[/');
			shortcode += '<p>' + selectedContent + '</p>';
			shortcode += endShortcode;
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()