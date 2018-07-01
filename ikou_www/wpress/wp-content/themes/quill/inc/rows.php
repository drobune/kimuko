<?php
/**
 * Dynamic styles for the Page Builder rows
 *
 * @package quill
 */
?>
<?php

function quill_panels_row_style_fields($fields) {

	$fields['color'] = array(
		'name' => __('Color', 'quill'),
		'type' => 'color',
	);	

	$fields['background'] = array(
		'name' => __('Background Color', 'quill'),
		'type' => 'color',
	);

	$fields['background_image'] = array(
		'name' => __('Background Image', 'quill'),
		'type' => 'url',
	);


	return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'quill_panels_row_style_fields');

function quill_panels_panels_row_style_attributes($attr, $style) {
	$attr['style'] = '';

	if(!empty($style['background'])) $attr['style'] .= 'background-color: '.$style['background'].'; ';
	if(!empty($style['color'])) $attr['style'] .= 'color: '.$style['color'].'; ';
	if(!empty($style['background_image'])) $attr['style'] .= 'background-image: url('.esc_url($style['background_image']).'); ';

	if(empty($attr['style'])) unset($attr['style']);
	return $attr;
}
add_filter('siteorigin_panels_row_style_attributes', 'quill_panels_panels_row_style_attributes', 10, 2);