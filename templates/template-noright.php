<?php
/**
 * Template Name:  Left Sidebar Only Page (no right sidebar)
 *
 */

get_header(); ?>

        <div class="primary-content col-md-9 col-md-push-2">
        <main id="main" class="main" role="main">

               <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'partials/content', 'page' ); ?>

                  <?php comments_template('/comments.php'); ?>

                <?php endwhile; // End of the loop. ?>

        </main><!-- #main -->
        </div>

<?php get_sidebar('left2'); ?>
<?php get_footer(); ?>
