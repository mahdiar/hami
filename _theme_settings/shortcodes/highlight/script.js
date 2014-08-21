// closure to avoid namespace collision
(function(){

	var edTest = '';

	// creates the plugin
	tinymce.create('tinymce.plugins.js_highlight', {
	
		init : function(ed, url) {  
            ed.addButton('js_highlight_button', {  
                title : 'Add Highlight',  
                image : url+'/icon_highlight.png',  
                onclick : function() {
                
                	// inserts the shortcode into the active editor
                	var selectedContent = tinyMCE.activeEditor.selection.getContent();
                	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[highlight]' + selectedContent + '[/highlight]');
                	
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_highlight', tinymce.plugins.js_highlight);
	
})()