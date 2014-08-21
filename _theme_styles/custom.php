<?php header("content-type: text/css");

$color = $_GET['color'];
$font = $_GET['font'];

function HexToRGB($hex) {
	$hex = str_replace("#", "", $hex);
	$color = array();
	
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1) . $r);
		$color['g'] = hexdec(substr($hex, 1, 1) . $g);
		$color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	
	return $color;
}

$rgb = HexToRGB($color);
$rgb_dark = ($rgb['r'] - 45).','.($rgb['g'] - 45).','.($rgb['b'] - 45);

if (strstr($font,':')){
	$font = explode(':',$font);
	$font = $font[0];
}

if ($font != 'sans-serif'){ $font = "'".$font."',sans-serif"; }

?>body,
h3,
#banner h2,
.section-head,
ul.numbers li strong,
#head nav ul li a,
p.inline-numbers,
p.inline-numbers strong,
a.button-big,
.entry h3,
.entry h4,
.button-large,
.button-mini,
.edd-add-to-cart-label,
.button-small,
.cart_item.edd_checkout a
.articles-list ul li h3,
.articles-list ul li p,
.articles-list ul li p.orange { font-family:<?php echo $font; ?>; }

a,
h2,
h4,
header nav ul li a:hover,
header nav ul li:hover > a,
.project .text h4 a,
a.view:hover,
.entry section.post.active h3 a,
.articles-list ul li h3 .price,
.articles-list ul li p.orange,
.footer-navigation nav ul li a:hover,
.footer-navigation nav ul li.active a,
.copyright a,
ul.numbers li strong,
#respond span.required,
.widget a:hover,
header nav .dd li:hover > a,
.entry p#breadcrumbs a,
a.button-big { color:#<?php echo $color; ?>; }

.progress-small span,
.colored-line,
.entry .cta,
.button-large,
.button-mini,
.edd-add-to-cart-label,
.button-small,
#respond input#submit,
article#content ol.commentlist li.comment div.reply a,
.widget-button,
.widget_search input.button,
article.entry .button:not(.add_media),
input[type=submit]:not(#searchsubmit),
#search input.button,
.atcf-submit-campaign h3, .atcf-profile h3,
.single-post-block.status,
.single-post-block.aside,
.mobile-nav-toggle,
#mobile-nav > ul,
#pagination ul li a,
.cart_item.edd_checkout a,
.ribbon.featured,
.progress-info.new .progress-big span,
header nav .dd > ul,
.progress-info.new a.button-big:hover,
.campaign-tabs .tab.active, .campaign-tabs .tab.active:hover,
#edd_purchase_receipt_products th, #edd_purchase_receipt th,
#head { background-color:#<?php echo $color; ?>; }

.edd-submit, #edd-purchase-button, input[type=submit].edd-submit {
     background:#<?php echo $color; ?> !important;
}

#page-widgets, .campaign-tabs, #pledges { border-color:#<?php echo $color; ?>; }

#content .cta,
.button-large,
.button-small,
.cart_item.edd_checkout a,
.cart_item.edd_checkout a:hover,
.button-large:hover,
input[type=submit]:not(#searchsubmit),
article.entry .button:not(.add_media),
input[type=submit]:not(#searchsubmit):hover,
article.entry .button:not(.add_media):hover,
.atcf-submit-campaign h3, .atcf-profile h3,
.button-small:hover { border-bottom-color: rgb(<?php echo $rgb_dark; ?>); }

.single-post-block.status,
.single-post-block.aside { border-top-color: rgb(<?php echo $rgb_dark; ?>); }

.widget-button:hover,
.widget_search input.button:hover,
#pagination ul li a:hover,
#search input.button:hover,
.cart_item.edd_checkout a:hover { background-color:rgb(<?php echo $rgb_dark; ?>); }