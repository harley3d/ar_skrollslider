<?php


add_action( 'wp_enqueue_scripts', 'skrollslider_scripts_styles' );
function skrollslider_scripts_styles() {
    wp_register_style('skrollslider-jquery-rebox', plugins_url('css/jquery-rebox.css', __FILE__));
    wp_enqueue_style( 'skrollslider-jquery-rebox' );
    wp_register_style('skrollslider', plugins_url('css/skrollslider.css', __FILE__));
    wp_enqueue_style( 'skrollslider' );


    wp_register_script('skrollslider-jquery-rebox', plugins_url('js/jquery-rebox.js', __FILE__), array('jquery'), null, true);
    wp_register_script('rangeslider', 'https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.0/rangeslider.min.js', array('jquery'), null, true);
    wp_register_script('skrollslider', plugins_url('js/skrollslider.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('skrollslider-jquery-rebox');
    wp_enqueue_script('rangeslider');
    wp_enqueue_script('skrollslider');
}



add_action( 'init', 'skrollslider_add_post_type' );
function skrollslider_add_post_type(){

    register_taxonomy('skcat', 'skphoto', array(
        'label' => 'Категория',
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        //'rewrite' => array('slug' => 'skphoto/skcat')
    ));

    register_post_type('skphoto', array(
            'label' => 'Карусель',
            'public' => true,
            'supports' => array('title', 'thumbnail'),
            'has_arhive'=> true,
          //  'rewrite' => array('slug' => 'skphoto')
        )
    );
}


add_shortcode( 'skrollslider', 'skrollslider_func' );

function skrollslider_func( $atts ){

    global $post;
    $myposts = get_posts( [
        'posts_per_page' => -1,
        'post_type' => 'skphoto',
        'skcat' => $atts['slug'],
    ] );


    $res = '<div class="skrollslider">';
        $res .= '<div class="skrollslider__slides">';
            $dataSlide = 0;

            foreach( $myposts as $post ){
                setup_postdata( $post );

                $id = get_post_thumbnail_id( $post );
                $alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
                if(isset($atts['size'])) {
                    switch ($atts['size']) {
                        case 'thumbnail':
                            $size = 'thumbnail';
                            break;
                        case 'medium':
                            $size = 'medium';
                            break;
                    }
                } else {
                    $size = 'full';
                }
                $img = get_the_post_thumbnail_url( $post, $size );

                $dataSlide++;
                $classActive = ($dataSlide == count($myposts)) ? "active" : "";
                $res .= '<div class="slide '. $classActive .'" data-slide="'. $dataSlide .'">';
                    $res .= '<a href="'. $img .'">';
                        $res .= "<img src='" . $img . "' alt='". $alt ."'>";
                    $res .= '</a>';
                $res .= '</div>';

            }

        $res .= "</div>";
        $res .= '<div class="skrollslider__range">';
            $res .= '<input type="range" class="range" id="range" data-orientation="vertical" min="1" max="'. count($myposts) .'"  value="'. count($myposts) .'" step="1">';
        $res .= "</div>";
    $res .= "</div>";

    wp_reset_postdata();
    return $res;
}
