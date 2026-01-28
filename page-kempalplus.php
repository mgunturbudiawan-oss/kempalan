<?php
/**
 * Template Name: Kempal Plus Page
 * Template Post Type: page
 *
 * @package haliyora
 */

get_header();

// Get settings from Customizer
$kp_title = get_theme_mod('haliyora_kempalplus_title_custom', 'kempal<span>PLUS</span>');
$kp_desc = get_theme_mod('haliyora_kempalplus_desc_custom', 'Konten eksklusif dari kreator dan pakar pilihan kempalan untuk informasi yang lebih mendalam.');
$kp_cat = get_theme_mod('haliyora_kempalplus_category', 0);
$kp_count = get_theme_mod('haliyora_kempalplus_count', 9);

// Prepare Query
$kp_args = array(
    'post_type'           => array('post', 'berita_foto'),
    'posts_per_page'      => $kp_count,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'orderby'             => 'date',
    'order'               => 'DESC'
);

if ($kp_cat > 0) {
    $kp_args['cat'] = $kp_cat;
}

$kp_query = new WP_Query($kp_args);
?>

<div class="kempal-plus-page">
	<div class="kempal-plus-header">
		<div class="shadcn-container">
			<h1 class="kempal-plus-logo"><?php echo $kp_title; ?></h1>
			<p class="kempal-plus-description"><?php echo esc_html($kp_desc); ?></p>
		</div>
	</div>

	<div class="shadcn-container">
		<div class="kempal-plus-section">
			<h2 class="kempal-plus-section-title">
				<span class="material-icons" style="color: #00a9b8;">star</span>
				Konten Pilihan
			</h2>

			<div class="kempal-plus-grid">
				<?php
				if ($kp_query->have_posts()) :
					while ($kp_query->have_posts()) : $kp_query->the_post();
						$categories = get_the_category();
						$badge = !empty($categories) ? $categories[0]->name : 'PLUS';
						?>
						<a href="<?php the_permalink(); ?>" class="kempal-plus-card">
							<div class="kempal-plus-card-badge"><?php echo esc_html($badge); ?></div>
							<?php 
							if (function_exists('haliyora_get_post_thumbnail')) {
								echo haliyora_get_post_thumbnail(get_the_ID(), 'large', array('class' => 'kempal-plus-card-image'));
							} else {
								the_post_thumbnail('large', array('class' => 'kempal-plus-card-image'));
							}
							?>
							<div class="kempal-plus-card-overlay">
								<h3 class="kempal-plus-card-title"><?php the_title(); ?></h3>
								<div class="kempal-plus-card-info">
									<i class="far fa-clock"></i>
									<span><?php echo haliyora_format_date(); ?></span>
								</div>
							</div>
						</a>
					<?php endwhile;
					wp_reset_postdata();
				else :
					// Fallback to dummy content if no posts found
					$dummy_content = array(
						array(
							'title' => 'Love Scamming Merajalela: Modus dan Cara Menghindarinya',
							'count' => '2 Konten',
							'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop',
							'badge' => 'INVESTIGASI'
						),
						array(
							'title' => 'Maraknya Fasum Dirusak, Kabel-Besi Dicolong di Berbagai Kota',
							'count' => '3 Konten',
							'image' => 'https://images.unsplash.com/photo-1590234918235-86f7844087b2?q=80&w=800&auto=format&fit=crop',
							'badge' => 'KABAR DAERAH'
						),
						array(
							'title' => 'Maka Kitalah Siti Julaika dan Durakim Si Buruh Pabrik Gula',
							'count' => '39 Konten',
							'image' => 'https://images.unsplash.com/photo-1558444479-c8f02e62156e?q=80&w=800&auto=format&fit=crop',
							'badge' => 'CERITA'
						),
						array(
							'title' => 'Tumbler, Dosa Kecil yang Terlalu Sering Kita Banggakan',
							'count' => '21 Konten',
							'image' => 'https://images.unsplash.com/photo-1519690889869-e705e59f72e1?q=80&w=800&auto=format&fit=crop',
							'badge' => 'GAYA HIDUP'
						),
						array(
							'title' => 'Remaja WNI dalam Tahanan Yordania: Sebuah Kisah Pilu',
							'count' => '3 Konten',
							'image' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800&auto=format&fit=crop',
							'badge' => 'INTERNASIONAL'
						),
						array(
							'title' => 'Kisah Eks Napiter Mencari Jalan Pulang ke Pangkuan NKRI',
							'count' => '12 Konten',
							'image' => 'https://images.unsplash.com/photo-1501533151544-773f32429402?q=80&w=800&auto=format&fit=crop',
							'badge' => 'EKSKLUSIF'
						),
						array(
							'title' => 'Dibalik Megahnya Infrastruktur: Nasib Pekerja Harian Lepas',
							'count' => '5 Konten',
							'image' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=800&auto=format&fit=crop',
							'badge' => 'EKONOMI'
						),
						array(
							'title' => 'Misteri di Balik Hilangnya Artefak Kerajaan Majapahit',
							'count' => '8 Konten',
							'image' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?q=80&w=800&auto=format&fit=crop',
							'badge' => 'SEJARAH'
						),
						array(
							'title' => 'Startup di Persimpangan Jalan: Masa Depan Ekonomi Digital',
							'count' => '15 Konten',
							'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800&auto=format&fit=crop',
							'badge' => 'TEKNOLOGI'
						)
					);

					foreach ( $dummy_content as $item ) : ?>
						<a href="#" class="kempal-plus-card">
							<div class="kempal-plus-card-badge"><?php echo esc_html( $item['badge'] ); ?></div>
							<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" class="kempal-plus-card-image">
							<div class="kempal-plus-card-overlay">
								<h3 class="kempal-plus-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
								<div class="kempal-plus-card-info">
									<i class="fas fa-layer-group"></i>
									<span><?php echo esc_html( $item['count'] ); ?></span>
								</div>
							</div>
						</a>
					<?php endforeach;
				endif; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
