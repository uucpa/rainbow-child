<article <?php post_class(); ?>>
  <header>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <?php get_template_part('partials/entry-meta'); ?>
  </header>
  <?php 
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			if(is_singular('testimonial')) {
			the_post_thumbnail('medium', array('class' => 'alignright round'));
			} else {
                        	echo '<figure class="wp-block-image">';
                        	the_post_thumbnail('medium_large', array('class' => 'aligncenter'));
                        	$get_description = get_post(get_post_thumbnail_id())->post_excerpt;
                        	if(!empty($get_description)){//If description is not empty show the div
                           		echo '<figcaption>' . $get_description . '</figcaption>';
                        	}
                        	echo '</figure>';
			}				
		}
	?>
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
  <footer>
    <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'uuatheme'), 'after' => '</p></nav>')); ?>
  </footer>
  <?php comments_template('/comments.php'); ?>
</article>
