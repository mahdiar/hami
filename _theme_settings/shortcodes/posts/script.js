// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.js_posts', {
	
		init : function(ed, url) {  
            ed.addButton('js_posts_button', {  
                title : 'Posts',  
                image : url+'/icon_posts.png',  
                onclick : function() {
					// triggers the thickbox
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 84;
					tb_show( 'Posts', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=js_posts-form' );
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;  
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_posts', tinymce.plugins.js_posts);
	
	// executes this when the DOM is ready
	jQuery(function(){
	
		var categoryOptions = '';
	
		for (var prop in postCategories) {
			if (postCategories.hasOwnProperty(prop)) { 
		    	categoryOptions += '<option value="'+prop+'">'+postCategories[prop]+'</option>';
		    }
		}
	
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="js_posts-form"><div class="shortcode-form">\
			<h2>Posts</h2>\
			<table id="js_posts-table" class="form-table">\
			<tr>\
				<th><label for="js_posts-category">Post Category</label></th>\
				<td><select name="category" id="js_posts-category">\
					<option value="">All Posts</option>'+categoryOptions+'</select><br />\
				<small>Specify the category of posts to display.</small></td>\
			</tr>\
			<tr>\
				<th><label for="js_posts-count">How many posts to display?</label></th>\
				<td><input type="text" name="postCount" id="js_posts-count" value="5" /><br />\
				<small>How many posts do you want to display?</small>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="js_posts-submit" class="button-primary" value="Add Posts" name="submit" />\
		</p>\
		</div></div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#js_posts-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = { 
				'category'      : '',
				'count'			: ''
				};
			var shortcode = '[display-posts';
			
			for( var index in options) {
				var currentInput = table.find('#js_posts-' + index);
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