<script type="text/javascript">
(function($){
	$(document).ready(function(){
		tinyMCE.init({
			// General options
			mode : "specific_textareas",
			editor_selector: "ecfRichtext", 
			theme: "advanced",
			skin: "wp_theme",

			// Theme options
			theme_advanced_buttons1: "code,|,bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,wp_more,|,spellchecker,fullscreen,wp_adv,separator,WPSC", 
			theme_advanced_buttons2:"formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,media,charmap,|,outdent,indent,|,undo,redo,wp_help",
			theme_advanced_buttons3:"", 
			theme_advanced_buttons4:"", 
			language:"en", 
			spellchecker_languages:"+English=en,Danish=da,Dutch=nl,Finnish=fi,French=fr,German=de,Italian=it,Polish=pl,Portuguese=pt,Spanish=es,Swedish=sv", 
			theme_advanced_toolbar_location:"top", 
			theme_advanced_toolbar_align:"left", 
			theme_advanced_statusbar_location:"bottom", 
			theme_advanced_resizing:"1", 
			theme_advanced_resize_horizontal:"", 
			dialog_type:"modal", 
			relative_urls:"", 
			remove_script_host:"", 
			convert_urls:"", 
			apply_source_formatting:"", 
			remove_linebreaks:"1", 
			gecko_spellcheck:"1", 
			entities:"38,amp,60,lt,62,gt", 
			
			accessibility_focus:"1", 
			tabfocus_elements:"major-publishing-actions", 
			media_strict:"", 
			// save_callback:"switchEditors.saveCallback", 
			wpeditimage_disable_captions:"", 
			
			/* Break Richtext on WP 3.1
			plugins:"safari,inlinepopups,spellchecker,paste,wordpress,media,fullscreen,wpeditimage,wpgallery,tabfocus,-WPSC,-productspage_image,-transactionresultpage_image,-checkoutpage_image,-userlogpage_image"
			*/
		});
	})
})(jQuery)
</script>