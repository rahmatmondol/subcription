<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_675b4923e73f4',
	'title' => 'boxes',
	'fields' => array(
		array(
			'key' => 'field_675b4926c876d',
			'label' => 'boxes',
			'name' => 'boxes',
			'aria-label' => '',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'box',
			),
			'post_status' => array(
				0 => 'publish',
			),
			'taxonomy' => '',
			'filters' => '',
			'return_format' => 'object',
			'min' => '',
			'max' => '',
			'allow_in_bindings' => 0,
			'elements' => '',
			'bidirectional' => 0,
			'bidirectional_target' => array(
			),
		),
		array(
			'key' => 'field_675b4951c876e',
			'label' => 'Set Limit',
			'name' => 'limit',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'min' => '',
			'max' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

add_action( 'init', function() {
	register_post_type( 'box', array(
	'labels' => array(
		'name' => 'boxes ',
		'singular_name' => 'box',
		'menu_name' => 'boxes ',
		'all_items' => 'All boxes ',
		'edit_item' => 'Edit box',
		'view_item' => 'View box',
		'view_items' => 'View boxes ',
		'add_new_item' => 'Add New box',
		'add_new' => 'Add New box',
		'new_item' => 'New box',
		'parent_item_colon' => 'Parent box:',
		'search_items' => 'Search boxes ',
		'not_found' => 'No boxes	found',
		'not_found_in_trash' => 'No boxes	found in Trash',
		'archives' => 'box Archives',
		'attributes' => 'box Attributes',
		'insert_into_item' => 'Insert into box',
		'uploaded_to_this_item' => 'Uploaded to this box',
		'filter_items_list' => 'Filter boxes	list',
		'filter_by_date' => 'Filter boxes	by date',
		'items_list_navigation' => 'boxes	list navigation',
		'items_list' => 'boxes	list',
		'item_published' => 'box published.',
		'item_published_privately' => 'box published privately.',
		'item_reverted_to_draft' => 'box reverted to draft.',
		'item_scheduled' => 'box scheduled.',
		'item_updated' => 'box updated.',
		'item_link' => 'box Link',
		'item_link_description' => 'A link to a box.',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_rest' => true,
	'menu_icon' => 'dashicons-welcome-learn-more',
	'supports' => array(
		0 => 'title',
		1 => 'author',
		2 => 'editor',
		3 => 'excerpt',
		4 => 'thumbnail',
		5 => 'custom-fields',
	),
	'delete_with_user' => false,
) );
} );
