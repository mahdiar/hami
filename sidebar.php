<?php

if (function_exists('dynamic_sidebar')) :

	if (is_single() || is_archive() || is_category() || is_search()){
		
		dynamic_sidebar('post-sidebar');
	
	} else {
	
		dynamic_sidebar('default-sidebar');
	
	}

endif;

?>