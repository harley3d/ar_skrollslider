<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

register_taxonomy( 'skcat', 'skphoto' );
// remove all custom taxonomies
$terms = get_terms( 'skcat', array( 'hide_empty' => false ) );
foreach ( $terms as $term ) {
    wp_delete_term( $term->term_id, 'skcat' );
}

$allposts= get_posts( array('post_type'=>'skphoto','numberposts'=>-1) );
foreach ($allposts as $eachpost) {
    wp_delete_post( $eachpost->ID, true );
}