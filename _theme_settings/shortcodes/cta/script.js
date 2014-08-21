// closure to avoid namespace collision
(function(){

	var edTest = '';

	// creates the plugin
	tinymce.create('tinymce.plugins.js_cta', {
	
		init : function(ed, url) {  
            ed.addButton('js_cta_button', {  
                title : 'Add Call to Action Block',  
                image : url+'/icon_cta.png',  
                onclick : function() {
                
                	// inserts the shortcode into the active editor
                	var selectedContent = tinyMCE.activeEditor.selection.getContent();
                	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[cta]' + selectedContent + '[/cta]');
                	
				} 
            });  
        },
        
        createControl : function(n, cm) {  
            return null;
        },
        
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('js_cta', tinymce.plugins.js_cta);
	
})()