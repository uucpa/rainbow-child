<?php
function rainbow_theme_enqueue_styles() {

    $parent_style = 'uuatheme_css'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/assets/css/main.css', false, filemtime( get_template_directory() . '/assets/css/main.css'), 'all');

    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'rainbow_theme_enqueue_styles' );

add_post_type_support( 'page', 'excerpt' );

//Add custom event scope for events manager
add_filter( 'em_events_build_sql_conditions', 'my_em_scope_conditions',1,2);
function my_em_scope_conditions($conditions, $args){
    if( !empty($args['scope']) && $args['scope']=='sunday' ){
        $start_date = date('Y-m-d',current_time('timestamp'));
        $end_date = date('Y-m-d',strtotime("+1 day", current_time('timestamp')));
        $tomorrow = date('Y-m-d',strtotime('sunday'));// ' + current_time('timestamp')));
        $conditions['scope'] = " (event_start_date = CAST('$tomorrow' AS DATE))";
        //$conditions['scope'] = " (event_start_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE)) OR (event_end_date BETWEEN CAST('$end_date' AS DATE) AND CAST('$start_date' AS DATE))";
    } elseif( !empty($args['scope']) && $args['scope']=='week' ){
        $start_month = date('Y-m-d',current_time('timestamp'));
        $end_month = date('Y-m-d',current_time('timestamp')+60*60*24*7);
        $conditions['scope'] = " (event_start_date BETWEEN CAST('$start_month' AS DATE) AND CAST('$end_month' AS DATE))";
    }
    return $conditions;
}

add_filter( 'em_get_scopes','my_em_scopes',1,1);
function my_em_scopes($scopes){
    $my_scopes = array(
        'sunday' => 'This Sunday\'s events',
        'week' => 'This Week\'s events'
    );
    return $scopes + $my_scopes;
}

/* New Feed containing the upcoming services */
function the_upcoming_service_feed() {
        add_feed('upcomingservices', 'upcoming_services_feed');
}
add_action('init', 'the_upcoming_service_feed');
function upcoming_services_feed() {
        add_filter('pre_option_rss_use_excerpt', '__return_zero');
        //Use get_stylesheet_directory to find the child theme folder
        load_template( get_stylesheet_directory() . '/feeds/feed-upcomingservices.php' );
}
?>
