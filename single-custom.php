<?php
/*
Template Name: New Template
*/

get_header(); ?>

<div class="row">
  <div class="span8">

<?php query_posts(array('post_type'=>'pb_custom')); ?>
	<?php $mypost = array( 'post_type' => 'pb_custom' );
	$loop = new WP_Query( $mypost ); ?>
	<!-- Cycle through all posts -->
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		
			

				<!-- Display featured image in right-aligned floating div -->
				<div style="float:top; margin: 10px">
					<?php the_post_thumbnail( array(100,100) ); ?>
				</div>

				<!-- Display Title and Author Name -->
				<strong>Title: </strong><?php the_title(); ?><br />
				<strong>URL: </strong>
				<?php echo esc_html( get_post_meta( get_the_ID(), 'url_custom', true ) ); ?>
				<strong>Description: </strong>
				<?php echo esc_html( get_post_meta( get_the_ID(), 'desc_custom', true ) ); ?>
				<br />

				


			

			<?php the_content(); ?>
			

		

		<hr/>
	<?php endwhile; ?>

  </div>
  <div class="span4">

	<?php get_sidebar(); ?>	
 
  </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>