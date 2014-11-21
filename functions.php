<?php 

//*****************************************************
// Here is all of our atlanta westside custom PHP
//*****************************************************

// Raise Upload Limit
//-----------------------------------------------------

@ini_set( 'upload_max_size' , '20M' );
@ini_set( 'post_max_size', '20M');
@ini_set( 'max_execution_time', '300' );



function additional_styles() {
	
	wp_enqueue_style( 'font-awesome-css', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');
	
}
add_action( 'wp_enqueue_scripts', 'additional_styles' );

function theme_js() {
	
	global $wp_scripts;
	
	wp_register_script( 'html5_shiv', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', '', '', false );
	wp_register_script( 'respond_js', 'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js', '', '', false );
	
	$wp_scripts->add_data( 'html5_shiv', 'conditional', 'lt IE 9' );
	$wp_scripts->add_data( 'respond_js', 'conditional', 'lt IE 9' );
	
}

add_action( 'wp_enqueue_scripts', 'theme_js' );





// Add Custom Post Types
//-----------------------------------------------------

add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'resources',
		array(
			'labels' => array(
				'name'               => _( 'Resources' ),
				'singular_name'      => _( 'Resource' ),
				'menu_name'          => _( 'Resources' ),
				'name_admin_bar'     => _( 'Resource' ),
				'add_new'            => _x( 'Add New', 'resource' ),
				'add_new_item'       => __( 'Add New Resource' ),
				'new_item'           => __( 'New Resource' ),
				'edit_item'          => __( 'Edit Resource' ),
				'view_item'          => __( 'View Resource' ),
				'all_items'          => __( 'All Resources' ),
				'search_items'       => __( 'Search Resources' ),
				'parent_item_colon'  => __( 'Parent Resources:' ),
				'not_found'          => __( 'No resources found.' ),
				'not_found_in_trash' => __( 'No resources found in Trash.' ),
			),
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'excerpt', 'thumbnail', 'custom-fields' )
		)
	);
	register_post_type( 'staff',
		array(
			'labels' => array(
				'name'               => _( 'Staff' ),
				'singular_name'      => _( 'Staff' ),
				'menu_name'          => _( 'Staff' ),
				'name_admin_bar'     => _( 'Staff' ),
				'add_new'            => _x( 'Add New', 'staff' ),
				'add_new_item'       => __( 'Add New Staff' ),
				'new_item'           => __( 'New Staff' ),
				'edit_item'          => __( 'Edit Staff' ),
				'view_item'          => __( 'View Staff' ),
				'all_items'          => __( 'All Staff' ),
				'search_items'       => __( 'Search Staff' ),
				'parent_item_colon'  => __( 'Parent Staff:' ),
				'not_found'          => __( 'No staff found.' ),
				'not_found_in_trash' => __( 'No staff found in Trash.' ),
			),
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'supports' => array( 'excerpt', 'thumbnail', 'custom-fields' )
		)
	);
	register_post_type( 'elders',
		array(
			'labels' => array(
				'name'               => _( 'Elders' ),
				'singular_name'      => _( 'Elder' ),
				'menu_name'          => _( 'Elders' ),
				'name_admin_bar'     => _( 'Elder' ),
				'add_new'            => _x( 'Add New', 'resource' ),
				'add_new_item'       => __( 'Add New Elder' ),
				'new_item'           => __( 'New Elder' ),
				'edit_item'          => __( 'Edit Elder' ),
				'view_item'          => __( 'View Elder' ),
				'all_items'          => __( 'All Elders' ),
				'search_items'       => __( 'Search Elders' ),
				'parent_item_colon'  => __( 'Parent Elders:' ),
				'not_found'          => __( 'No elders found.' ),
				'not_found_in_trash' => __( 'No elders found in Trash.' ),
			),
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'excerpt', 'thumbnail', 'custom-fields' )
		)
	);
	register_post_type( 'deacons',
		array(
			'labels' => array(
				'name'               => _( 'Deacons' ),
				'singular_name'      => _( 'Deacon' ),
				'menu_name'          => _( 'Deacons' ),
				'name_admin_bar'     => _( 'Deacon' ),
				'add_new'            => _x( 'Add New', 'deacon' ),
				'add_new_item'       => __( 'Add New Deacon' ),
				'new_item'           => __( 'New Deacon' ),
				'edit_item'          => __( 'Edit Deacon' ),
				'view_item'          => __( 'View Deacon' ),
				'all_items'          => __( 'All Deacons' ),
				'search_items'       => __( 'Search Deacons' ),
				'parent_item_colon'  => __( 'Parent Deacons:' ),
				'not_found'          => __( 'No deacons found.' ),
				'not_found_in_trash' => __( 'No deacons found in Trash.' ),
			),
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'excerpt', 'thumbnail', 'custom-fields' )
		)
	);
	
}


// Staff

add_filter( 'manage_edit-staff_columns', 'my_edit_staff_columns' ) ;
add_action( 'manage_staff_posts_custom_column', 'my_manage_staff_columns', 10, 2 );
add_action( 'init', 'remove_staff_title' );
add_filter( 'wp_insert_post_data' , 'modify_staff_post_title' , '99', 2 );


function remove_staff_title() {
    remove_post_type_support( 'staff', 'title' );
}

function my_edit_staff_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'title_role' => __('Title'),
		'type' => __( 'Type' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

function my_manage_staff_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		
		case 'type' :

			/* Get the post meta. */
			$type = ucfirst(get_post_meta( $post_id, 'type', true ));

			/* If no type is found, output a default message. */
			if ( empty( $type ) )
				echo __( 'Unknown' );
			else
				printf( __( $type ));

			break;		
		
		case 'title_role' :

			/* Get the post meta. */
			$title_role = get_post_meta( $post_id, 'title_role', true );

			/* If no first name is found, output a default message. */
			if ( empty( $title_role ) )
				echo __( 'Unknown' );
			else
				printf( __( $title_role ));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function modify_staff_post_title( $data , $postarr )
{
  if($data['post_type'] == 'staff') {
    $data['post_title'] = $postarr['fields']['field_536a7b8f7e716'].' '.$postarr['fields']['field_536a7bb17e717'];

  }
  return $data;
}

// Elders

add_filter( 'manage_edit-elders_columns', 'my_edit_elders_columns' ) ;
add_action( 'manage_elders_posts_custom_column', 'my_manage_elders_columns', 10, 2 );
add_action( 'init', 'remove_elders_title' );
add_filter( 'wp_insert_post_data' , 'modify_elders_post_title' , '99', 2 );


function remove_elders_title() {
    remove_post_type_support( 'elders', 'title' );
}

function my_edit_elders_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'title_role' => __('Title'),
		'type' => __( 'Type' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

function my_manage_elders_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		
		case 'type' :

			/* Get the post meta. */
			$type = ucfirst(get_post_meta( $post_id, 'type', true ));

			/* If no type is found, output a default message. */
			if ( empty( $type ) )
				echo __( 'Unknown' );
			else
				printf( __( $type ));

			break;		
		
		case 'title_role' :

			/* Get the post meta. */
			$title_role = get_post_meta( $post_id, 'title_role', true );

			/* If no first name is found, output a default message. */
			if ( empty( $title_role ) )
				echo __( 'Unknown' );
			else
				printf( __( $title_role ));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function modify_elders_post_title( $data , $postarr )
{
  if($data['post_type'] == 'elders') {
    $data['post_title'] = $postarr['fields']['field_536a7b8f7e716'].' '.$postarr['fields']['field_536a7bb17e717'];

  }
  return $data;
}

// Deacons

add_filter( 'manage_edit-deacons_columns', 'my_edit_deacons_columns' ) ;
add_action( 'manage_deacons_posts_custom_column', 'my_manage_deacons_columns', 10, 2 );
add_action( 'init', 'remove_deacons_title' );
add_filter( 'wp_insert_post_data' , 'modify_deacons_post_title' , '99', 2 );


function remove_deacons_title() {
    remove_post_type_support( 'deacons', 'title' );
}

function my_edit_deacons_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'title_role' => __('Title'),
		'type' => __( 'Type' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

function my_manage_deacons_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		
		case 'type' :

			/* Get the post meta. */
			$type = ucfirst(get_post_meta( $post_id, 'type', true ));

			/* If no type is found, output a default message. */
			if ( empty( $type ) )
				echo __( 'Unknown' );
			else
				printf( __( $type ));

			break;		
		
		case 'title_role' :

			/* Get the post meta. */
			$title_role = get_post_meta( $post_id, 'title_role', true );

			/* If no first name is found, output a default message. */
			if ( empty( $title_role ) )
				echo __( 'Unknown' );
			else
				printf( __( $title_role ));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function modify_deacons_post_title( $data , $postarr )
{
  if($data['post_type'] == 'deacons') {
    $data['post_title'] = $postarr['fields']['field_536a7b8f7e716'].' '.$postarr['fields']['field_536a7bb17e717'];

  }
  return $data;
}

// Resources

add_filter( 'manage_edit-resources_columns', 'my_edit_resources_columns' ) ;
add_action( 'manage_resources_posts_custom_column', 'my_manage_resources_columns', 10, 2 );
add_filter( 'manage_edit-resources_sortable_columns', 'my_resources_sortable_columns' );
add_action( 'load-edit.php', 'my_edit_resources_load' );

function my_edit_resources_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'type' => __( 'Type' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

function my_manage_resources_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		
		case 'type' :

			/* Get the post meta. */
			$type = str_replace('_', ' ', ucfirst(get_post_meta( $post_id, 'type', true )));

			/* If no type is found, output a default message. */
			if ( empty( $type ) )
				echo __( 'Unknown' );
			else
				printf( __( $type ));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function my_resources_sortable_columns( $columns ) {
	$columns['type'] = 'type';
	return $columns;
}

function my_edit_resources_load() {
	add_filter( 'request', 'my_sort_resources' );
}

function my_sort_resources( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'resources' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'name'. */
		if ( isset( $vars['orderby'] ) && 'type' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'type',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

// Staff Page 


function get_staff() {

	$args = array(
		'post_type' 		 => 'staff',
		'post_status'      => 'publish',
		'meta_key' 			=> 'title_role',
		'orderby'          => 'date',
		'order'            => 'DSC'
	);
	
	$the_query = new WP_Query( $args );		
	
	if ( $the_query->have_posts() ) {
			
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$type = get_post_meta(get_the_id(), 'type', true);
			$name = get_post_meta(get_the_id(), 'first_name', true).' '.get_post_meta(get_the_id(), 'last_name', true);
			$title = get_post_meta(get_the_id(), 'title_role', true);
			$bio = apply_filters('the_content', get_post_meta(get_the_id(), 'bio', true));
			
				 ?>
              <div class="staff-listing">
  <img src="<?php the_field( 'picture' ); ?>"/>
  <section class="staff-info">
  	<h2><?php the_field( 'first_name' ) ?> <span class="last_name"> <?php the_field( 'last_name'); ?></span></h2>
  	<h3><?php the_field ( 'title_role' ); ?></h3>
  	<p><?php the_field ( 'bio' ); ?></p>
  </section>
	</div>
           <?php
			
		}
	
	} else{ $staff="<h2>No Staff Added</h2>"; }
	
	
	return $staff;

}

add_shortcode('get_staff', 'get_staff');

// Elders Page 


function get_elders() {

	$args = array(
		'post_type' 		 => 'elders',
		'post_status'      => 'publish',
		'meta_key' 			=> 'last_name',
		'orderby'          => 'meta_value',
		'order'            => 'ASC'
	);
	
	$the_query = new WP_Query( $args );		
	
	if ( $the_query->have_posts() ) {
			
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$type = get_post_meta(get_the_id(), 'type', true);
			$name = get_post_meta(get_the_id(), 'first_name', true).' '.get_post_meta(get_the_id(), 'last_name', true);
			$title = get_post_meta(get_the_id(), 'title_role', true);
			$bio = apply_filters('the_content', get_post_meta(get_the_id(), 'bio', true));
			
				 ?>
              <div class="staff-listing">
  <img src="<?php the_field( 'picture' ); ?>"/>
  <section class="staff-info">
  	<h2><?php the_field( 'first_name' ) ?> <span class="last_name"> <?php the_field( 'last_name'); ?></span></h2>
  	<h3><?php the_field ( 'title_role' ); ?></h3>
  	<p><?php the_field ( 'bio' ); ?></p>
  </section>
	</div>
           <?php
			
		}
	
	} else{ $elders="<h2>No Staff Added</h2>"; }
	
	
	return $elders;

}

add_shortcode('get_elders', 'get_elders');


// Deacons Page

function get_deacons() {

	$args = array(
		'post_type' 		 => 'deacons',
		'post_status'      => 'publish',
		'meta_key' 			=> 'last_name',
		'orderby'          => 'meta_value',
		'order'            => 'ASC'
	);
	
	$the_query = new WP_Query( $args );		
	
	if ( $the_query->have_posts() ) {
			
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$type = get_post_meta(get_the_id(), 'type', true);
			$name = get_post_meta(get_the_id(), 'first_name', true).' '.get_post_meta(get_the_id(), 'last_name', true);
			$title = get_post_meta(get_the_id(), 'title_role', true);			
		
				?>
                
                <div class="staff-listing">
  					<img src="<?php the_field( 'picture' ); ?>"/>
  					<section class="staff-info">
                    <h2><?php the_field( 'first_name' ) ?> <span class="last_name"> <?php the_field( 'last_name'); ?></span></h2>
                    <h3><?php the_field( 'title_role' ) ?>, <?php echo ucfirst($type) ?></h3>
  					</section>
					</div>
                
               <?php
			
		}
	
	} else { $deacons="<h2>No Staff Added</h2>"; }
	
	
	return $deacons;

}

add_shortcode('get_deacons', 'get_deacons');

// Resources Page

function get_resources() {

	$args = array(
		'post_type' 		 => 'resources',
		'post_status'      => 'publish',
		'meta_key' 			=> 'type',
		'orderby'          => 'meta_value title',
		'order'            => 'ASC'
	);
	
	$the_query = new WP_Query( $args );		
	
	if ( $the_query->have_posts() ) {
			
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$title = get_the_title();
			$type = get_post_meta(get_the_id(), 'type', true);
			
			if(strpos($type,'_') !== false){ $type = str_replace('_', ' ', $type); }
			
			$url = get_post_meta(get_the_id(), 'url', true);
			$image = get_post_meta(get_the_id(), 'image', true);
			$leader = get_post_meta(get_the_id(), 'bible_study_leader', true);
			$author = get_post_meta(get_the_id(), 'author', true);
			$desc = get_post_meta(get_the_id(), 'description', true);
			
			?>
     		
            <?php if(strpos($new_type,$type) === false):?><h2 style="color:#333;"><?php echo $type ?></h2><?php endif; ?>
              <div class="staff-listing">
                  <section class="staff-info">
                    <h2><?php echo $title ?></h2>
                    <?php if(!empty($author)):?><h3>written by <?php echo $author ?></h3><?php endif; ?>
                    <?php if(!empty($leader)):?><h3>lead by <?php echo $leader ?></h3><?php endif; ?>
                    <?php if(!empty($url)):?><h3><a href="<?php echo $url ?>" >visit</a></h3><?php endif; ?>
                    <p><?php the_field ( 'description' ); ?></p>
                  </section>
	</div>
           <?php
		   
		   $new_type .= $type;
		   
		}
	
	} else{ $resources="<h2>No Resources Added</h2>"; }
	
	
	return $resources;

}

add_shortcode('get_resources', 'get_resources');



// Audio

add_filter( 'manage_edit-audio-items_columns', 'my_edit_audio_columns' ) ;
add_action( 'manage_audio-items_posts_custom_column', 'my_manage_audio_columns', 10, 2 );
add_filter( 'manage_edit-audio-items_sortable_columns', 'my_audio_sortable_columns' );
add_action( 'load-edit.php', 'my_edit_audio_load' );

function my_edit_audio_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'speaker' => __( 'Speaker' ),
		'sermon_date' => __( 'Sermon Date' )
	);

	return $columns;
}

function my_manage_audio_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		
		case 'speaker' :

			/* Get the post meta. */
			$speaker = str_replace('_', ' ', ucfirst(get_post_meta( $post_id, 'speaker', true )));

			/* If no speaker is found, output a default message. */
			if ( empty( $speaker ) )
				echo __( 'Unknown' );
			else
				printf( __( $speaker ));

			break;

		/* Just break out of the switch statement for everything else. */
		case 'sermon_date' :

			/* Get the post meta. */
			$sermon_date = str_replace('_', ' ', ucfirst(get_post_meta( $post_id, 'sermon_date', true )));

			/* If no speaker is found, output a default message. */
			if ( empty( $sermon_date ) )
				echo __( 'Unknown' );
			else
				printf( __( $sermon_date ));

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function my_audio_sortable_columns( $columns ) {
	$columns['speaker'] = 'speaker';
	$columns['sermon_date'] = 'sermon_date';
	return $columns;
}

function my_edit_audio_load() {
	add_filter( 'request', 'my_sort_audio' );
}

function my_sort_audio( $vars ) {

	/* Check if we're viewing the 'audio' post speaker. */
	if ( isset( $vars['post_type'] ) && 'audio-items' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'name'. */
		if ( isset( $vars['orderby'] ) && 'speaker' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'speaker',
					'orderby' => 'meta_value'
				)
			);
		}
		if ( isset( $vars['orderby'] ) && 'sermon_date' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'sermon_date',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}


function audio_tax( $query ) {
    if (is_admin()) return;
	
	if (strpos($_SERVER['REQUEST_URI'], 'title') !== false) {
		$orderby='title';
		$order =  'ASC';
	}
	else {
		$orderby='meta_value';
		$order =  'DSC';
	}
	
    if ( $query->is_main_query() && is_tax( 'audio' ) ) {
        $query->set('orderby', $orderby);
		if($orderby=='meta_value') $query->set( 'meta_key', 'sermon_date' );
		$query->set( 'order', $order );
		$query->set( 'posts_per_page', 5);
		
		//die();
		
        return;
    }
}
add_action( 'pre_get_posts', 'audio_tax' );


// CCB API
//-----------------------------------------------------

// Add script to admin to get Event Save action and input
function get_save_event() {
    wp_enqueue_script( 'save_event_script', get_stylesheet_directory_uri(). '/js/save_event.js' );
}
add_action( 'admin_enqueue_scripts', 'get_save_event' );

// Get New Event from AEC

function ccb_aec_add() {
	$input= cleanse_event_input($_POST['event']);
	$post_data = array(	'name'	 					=> $input->title,
						'start_date'				=> $input->start,
						'end_date'					=> $input->end,
						'group_id' 					=> 35,
						'description'				=> $input->description,
						'recurrence_frequency'		=> $input->repeat_freq,
					  	'recurrence_type'			=> $input->repeat_int,
						'recurrence_end_date'		=> $input->repeat_end,
						'location_name'				=> $input->venue,
						'location_street_address'	=> $input->address,
						'contact_phone'				=> $input->contact_info
						);
	
	if($input->repeat_int == 'weekly'){
				$post_data['recurrence_day_of_week'] = $input->repeat_day;
	}
	
	$ccb_api_post_data = convert_post_data($post_data);	
	$result = process_post($ccb_api_post_data);
	
	echo $result;

}

function cleanse_event_input($input) {
			
			if (!is_array($input)) {
				parse_str($input, $array);	// convert serialized form into array
				$input = $array;
			}
			
			array_walk($input, create_function('&$val', '$val = trim($val);'));
			
			$clean = new stdClass();
			
			foreach ($input as $key => $val) {
					$clean->{$key} = $val;
			}
			
			if ($clean->allDay) {
				$clean->start_time	= '00:00:00';
				$clean->end_time	= '23:59:59';
			}
			
			$clean->start = convert_date_time($clean->start_date, $clean->start_time);
			$clean->end	= convert_date_time($clean->end_date, $clean->end_time);
			$clean->repeat_int = convert_int($clean->repeat_int, $clean->repeat_end);
			$clean->repeat_end = convert_date_time($clean->repeat_end, NULL);
			
			// CCB doesn't support yearly recurrences
			if($clean->repeat_int == 'yearly') {
				$clean->repeat_int = '';
				$clean->repeat_end = '';
				$clean->repeat_freq = '';
			} elseif($clean->repeat_int == 'weekly'){
				$datetime = strtotime($clean->start);
				$clean->repeat_day = strtolower(date('D', $datetime));
			}
			
			return $clean;
}

function convert_date_time($date, $time = NULL) {
	
	if(!empty($time)){
		$s = $date.' '.$time;
		$datetime = strtotime($s);
		$datetime = date('Y-m-d H:i:s', $datetime);
	} elseif(!empty($date)) {
		$datetime = strtotime($date);
		$datetime = date('Y-m-d', $datetime);
	}
	
	return $datetime;
}

function convert_int($int, $end) {
	if(isset($int) && !empty($end)){
		$options = array('daily', 'weekly', 'monthly', 'yearly');
		$return = $options[$int];
	}
	return $return;
}

function convert_post_data($post_data) {
	if(is_array($post_data)){
		foreach($post_data as $key => $val){
			$val = str_replace(' ', '+', $val);
			$val = preg_replace('/[^\w\.\+\-\:]/ui', '', $val);
			$ccb_api_post_data .= $key.'='.$val.'&';
		}
		
		$ccb_api_post_data= substr($ccb_api_post_data, 0, -1);
	}
	
	return $ccb_api_post_data;
}
// Send to CCB

function process_post($postFields) {
	
	$login = 'username:password'; // Left out for security purposes
	
	$curl = curl_init('https://atlantawestside.ccbchurch.com/api.php?srv=create_event');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);     
			curl_setopt($curl, CURLOPT_USERPWD, $login);
			
	$record = curl_exec($curl);
	
	curl_close($curl);
	
	return $postFields.'<br><br>response:<br>'.$record;
}


add_action( 'wp_ajax_add_ccb_event', 'ccb_aec_add' );

// Feedburner API / Sermon Upload Management
//-----------------------------------------------------
add_filter( 'save_post' , 'modify_xml', 13, 2 );
add_action( 'trashed_post', 'remove_xml',1,1);

function modify_xml( $post_id) {
	
	$post_type = get_post_type($post_id);
	$post_title = get_the_title($post_id);
	
	if($post_type == 'audio-items'&&$post_title!='Auto Draft') {
		$url = '/home/atlWestside/atlantawestside.org/sermons/rss.xml';
		$xml = load_xml($url);
		$xml = edit_xml($xml, $post_id);
		$xml = save_xml($xml);
	}
}

function remove_xml( $post_id ) {
	
	$post_type = get_post_type($post_id);
	
	if($post_type == 'audio-items') {
		$url = '/home/atlWestside/atlantawestside.org/sermons/rss.xml';
		$xml = load_xml($url);
		$xml = remove_item($xml, $post_id);
	}
}

function load_xml($url) {
		
		if(file_exists($url)) {
			$use_errors = libxml_use_internal_errors(true);
			$xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);
			if ($xml === false) {
				$xml = "Failed loading XML:\n";
				foreach(libxml_get_errors() as $error) {
					$xml .= "\t".$error->message;
				}
			}
		} else {
			$xml = $url;
		}
		return $xml;

}

function edit_xml($xml, $post_id = NULL) {
	if(is_object($xml)){
		
		// Get Post Data
		
		if(!empty($post_id)){
			
			$upload_dir = wp_upload_dir();
			$uploads = $upload_dir['baseurl'];
			
			$post_meta = get_post_meta($post_id);
			$post_object = get_post( $post_id );
			$title = get_the_title($post_id);
			$subtitle = $post_meta['subtitle'][0];
			if(!empty($post_meta['_file_mp3'][0]) xor !empty($post_meta['_file_external_mp3'][0])){
				if(!empty($post_meta['_file_mp3'][0])){
					$mp3 = $uploads.'/'.$post_meta['_file_mp3'][0];
				} elseif(!empty($post_meta['_file_external_mp3'][0])){
					$mp3 = $post_meta['_file_external_mp3'][0];
				}
			} else { 
				$mp3 = $post_meta['_file_external_mp3'][0];
			}
			$summary = $post_object->post_content;
			$speaker = $post_meta['speaker'][0];
			$sermon_date = $post_meta['sermon_date'][0];
			
			$audio_data = array('title' => $title, 'subtitle' => $subtitle, 'speaker' => $speaker, 'sermon_date' => $sermon_date, 'mp3' => $mp3, 'summary' => $summary);
			
			// Convert DataTime for XML
			
			$datetime = strtotime($audio_data['sermon_date']);
			$audio_data['sermon_date'] = date(DATE_RFC2822, $datetime); // format str
			$audio_data['sermon_date'] = date_create($audio_data['sermon_date']); // covert to obj
			$audio_data['sermon_date']->modify('+12 hours'); // add 12 hours to ensure correct date in itunes
			$audio_data['sermon_date'] = $audio_data['sermon_date']->format('r'); // convert obj to str
			
			// Check existing IDs if so update
			
			$item_obj = $xml->channel->item;
			$id_exists = false;
		
			if(is_object($item_obj)){
				foreach($item_obj as $key){
					
					$key_id = $key[0]['page_id'];
					
					if($key_id == $post_id) { 
						
						$otherNode = $key->children('http://www.itunes.com/dtds/podcast-1.0.dtd');
						$dc = $key->children('http://purl.org/dc/elements/1.1/');
						$key->title = $audio_data['title'];
						$otherNode->summary = strip_tags($audio_data['summary']);
						$key->description = '<p>'.strip_tags($audio_data['summary']).'</p>';
						$key->pubDate = $audio_data['sermon_date'];
						$otherNode->subtitle = $audio_data['subtitle'];
						$dc->creator = $audio_data['speaker'];
						$key->enclosure[0]['url']= $audio_data['mp3'];
						$otherNode->author= $audio_data['speaker'];
						
						$id_exists = true;
						
					}
				}
			}
			
			// if ID doesn't exist append channel item
			
			if($id_exists === false) {
				
				$channel = $xml->channel;
				
				$dom = dom_import_simplexml($channel);

				$new = $dom->insertBefore(
					$dom->ownerDocument->createElement('item'),
					$dom->getElementsByTagName('item')->item(0)
				);

        		$new_obj = simplexml_import_dom($new, get_class($channel));
				
				$new_obj->addAttribute('page_id', $post_id);
				$new_obj->addChild('title', $audio_data['title']);
				$new_obj->addChild('creator', $audio_data['speaker'], 'http://purl.org/dc/elements/1.1/');
				$new_obj->addChild('duration', NULL , 'http://www.itunes.com/dtds/podcast-1.0.dtd');
				$new_obj->addChild('subtitle', $audio_data['subtitle'], 'http://www.itunes.com/dtds/podcast-1.0.dtd'); 
				$itunes_img = $new_obj->addChild('image', NULL, 'http://www.itunes.com/dtds/podcast-1.0.dtd');
				$itunes_img->addAttribute('href', 'http://atlantawestside.org/content/images/atlanta_westside_cover_300.png'); 
				$new_obj->addChild('author', $audio_data['speaker'], 'http://www.itunes.com/dtds/podcast-1.0.dtd');
				$new_obj->addChild('pubDate',$audio_data['sermon_date']); //Sun, 16 Mar 2014 10:30:36 -0700 
				$new_obj->addChild('link','http://atlantawestside.org/resources'); 
				$new_obj->addChild('description', '<p>'.strip_tags($audio_data['summary']).'</p>'); 
				$new_obj->addChild('summary', strip_tags($audio_data['summary']), 'http://www.itunes.com/dtds/podcast-1.0.dtd'); 
				$encl = $new_obj->addChild('enclosure');
				$encl->addAttribute('url', $audio_data['mp3']);
				$encl->addAttribute('type','audio/mpeg');
				$encl->addAttribute('length', '0');
			}		
		}
	}
	
	return $xml;
}

function remove_item($xml, $post_id = NULL){
	
	if(is_object($xml)){
	
		// Get Post Data
		
		if(!empty($post_id)){		
			$item_obj = $xml->channel->item;
			$id_exists = false;
			
			//$key_title = 'test';
			
			if(is_object($item_obj)){
				foreach($item_obj as $key){
					
					$key_id = $key[0]['page_id'];
					
					if($key_id == $post_id) {
						$node = dom_import_simplexml($key);
						$node->parentNode->removeChild($node);
													
						if(!empty($key)) unset($key[0]);	
						$xml = save_xml($xml);
						
						break;
					}
				}
			}
		}
	}
	
	return $xml;
	
}

function save_xml($xml){
	if(is_object($xml)){
		
		//save with preserved cddata
		
		$dom = dom_import_simplexml($xml);
		
		//update last build
		
		$dom->getElementsByTagName('lastBuildDate')->item(0)->nodeValue = date(DATE_RFC2822);
		
		// dom finds the simplexml element (via DOMNodeList->index)
    	$items = $dom->getElementsByTagName('item');
		
		foreach($items as $item) {
			
			$string = $item->getElementsByTagName('description')->item(0)->nodeValue;
			$cdata = $item->getElementsByTagName('description')->item(0)->ownerDocument->createCDATASection($string);
			$string = $item->getElementsByTagName('description')->item(0)->nodeValue = '';
			$item->getElementsByTagName('description')->item(0)->appendChild($cdata);
			
		}
		
		$xml->asXML('/home/atlWestside/atlantawestside.org/sermons/rss.xml');
	}
	return $xml;
}

?>
