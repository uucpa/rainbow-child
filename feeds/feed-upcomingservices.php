<?php
/*
 * RSS Page
 * This page handles the UUA services RSS feed.
 * 
 */ 
header ( "Content-type: application/rss+xml; charset=UTF-8" );
echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo esc_html(get_option('blogname')." Upcoming Worship Services"); ?></title>
		<link><?php echo get_option('siteurl'); ?></link>
		<description><?php echo esc_html(get_option('blogdescription')." - Upcoming Worship Services"); ?></description>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
		<pubDate><?php echo date('D, d M Y H:i:s +0000'); ?></pubDate>
		<atom:link href="<?php echo esc_attr(get_option('siteurl')."/worship/upcoming-worship-services/"); ?>" rel="self" type="application/rss+xml" />
		<?php
        $rss_limit = 5;
        $page_limit = $rss_limit > 50 || !$rss_limit ? 50 : $rss_limit; //set a limit of 50 to output at a time, unless overall limit is lower		
		// Service query args
		$query_args = array(
			'post_type' => 'uu_services',
			'meta_query' => array(
				array(
					'key'     => '_services_unixtime',
					'compare' => '>=',
					'value'   => current_time('timestamp'),
				),
			),
			'meta_key'       => '_services_unixtime',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'posts_per_page' => 5,
		);
		$query_args = apply_filters( 'uua_rss_upcoming_services_query_args', $query_args );
		$services = new WP_Query( $query_args );
		$count = 0;
		if ( $services->have_posts() ) {
			while ( $services->have_posts() ) {
				$services->the_post(); 
				$count++; 
		?>
				<item>
					<title><?php echo the_title(); ?></title>
                                        <link><?php echo the_permalink(); ?></link>
                                        <guid><?php echo the_permalink(); ?></guid>
                                        <pubDate><?php echo uua_get_the_service_date('D, d M Y H:i:s +0000'); ?></pubDate>
                                <description><![CDATA[
<?php
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			echo '<figure class="wp-block-image">';
			the_post_thumbnail('medium_large', array('class' => 'aligncenter'));
			$get_description = get_post(get_post_thumbnail_id())->post_excerpt;
			if(!empty($get_description)){//If description is not empty show the div
				echo '<figcaption>' . $get_description . '</figcaption>';
			}
			echo '</figure>';
		}
?>                              
		<div class="entrymeta">
<?php
                echo '<em>'.uua_service_datetime().'</em>';
		ent2ncr(convert_chars(the_content()));
?>
               </div>]]></description>

	</item>
	<?php
		}
       	}
	?>
</channel>
</rss>
