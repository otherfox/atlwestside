<?php get_header(); ?>

</header>

<div id="main">
	<div class="shell">
		<article id="content" <?php post_class('left'); ?>>
					
			<?php js_breadcrumbs($post->ID); ?>
			<?php // Get the Event category and display the title.
			// Get the Event category and display the title.
			$cat = get_query_var('audio');
			$category_name = get_term_by('slug',$cat,'audio'); ?>
							
			<?php echo '<h1>'.$category_name->name.'</h1>'; ?>
			
			<?php if ( have_posts() ) : ?>
			
				<?php while (have_posts()) : the_post();
					
					if (get_post_meta($post->ID, '_file_mp3', true)){
						$upload_dir = wp_upload_dir();
						$audio_file =  $upload_dir['baseurl'].'/'.get_post_meta($post->ID, '_file_mp3', true);
					} else if (get_post_meta($post->ID, '_file_external_mp3', true)){
						$audio_file = get_post_meta($post->ID, '_file_external_mp3', true);
					} else {
						$audio_file = '';	
					} ?>
						
					<div class="single-post">
					
						<div class="post-content">
							<h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
							
							<?php if (of_get_option('js_hide_metainfo') == 0){ ?>
								<p class="post-meta"><?php _e('Sermon given on','savior'); ?> <strong><?php echo get_post_meta( get_the_ID(), 'sermon_date' , true ); ?></strong> <?php _e('by','savior'); ?> <?php echo get_post_meta( get_the_ID(), 'speaker' , true ); ?><br /></p>
							<?php } else { ?>
								<br />
							<?php } ?>
							
							<?php if ($audio_file){
								?><a href="#" class="button-small white play" data-src="<?php echo $audio_file; ?>"><?php _e('Play Audio','savior'); ?></a><br /><br /><?php
							} ?>
	
							<?php the_excerpt(); ?>
						</div>
					
					</div>
		
				<?php endwhile; ?>
				
			<?php endif; ?>
			
			<?php js_get_pagination(); wp_reset_query(); ?>
						
		</article>
		<section id="sidebar" class="right">
			<?php get_sidebar(); ?>				
		</section>
		
		<div class="cl"></div>
				
	</div>
</div>
	
<?php get_footer(); ?>