<?php
/**
 * Template part for displaying berita foto in archives
 *
 * @package haliyora
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'photo-card' ); ?>>
	<div class="photo-card-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php 
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'medium_large', array( 'class' => 'photo-card-image' ) );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.jpg" alt="' . get_the_title() . '" class="photo-card-image">';
			}
			?>
			<div class="photo-card-overlay">
				<span class="material-icons">visibility</span>
				<span>Lihat Galeri</span>
			</div>
		</a>
	</div>
	<div class="photo-card-content">
		<h2 class="photo-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="photo-card-meta">
			<span class="material-icons">schedule</span>
			<?php echo haliyora_format_date(); ?>
		</div>
	</div>
</article>
