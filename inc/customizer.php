<?php
/**
 * haliyora Theme Customizer
 *
 * @package haliyora
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function haliyora_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'haliyora_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'haliyora_customize_partial_blogdescription',
			)
		);
	}
	
	// Panel: Haliyora Settings
	$wp_customize->add_panel( 'haliyora_settings', array(
		'title'    => __( 'Haliyora Settings', 'haliyora' ),
		'priority' => 30,
	) );
	
	// Section: Top Header Settings
	$wp_customize->add_section( 'haliyora_top_header', array(
		'title'    => __( 'Top Header', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'haliyora_tentang_kami_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_tentang_kami_url', array(
		'label'    => __( 'Tentang Kami URL', 'haliyora' ),
		'section'  => 'haliyora_top_header',
		'type'     => 'url',
	) );
	
	$wp_customize->add_setting( 'haliyora_redaksi_url', array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_redaksi_url', array(
		'label'    => __( 'Redaksi URL', 'haliyora' ),
		'section'  => 'haliyora_top_header',
		'type'     => 'url',
	) );
	
	$wp_customize->add_setting( 'haliyora_login_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_login_url', array(
		'label'       => __( 'Login URL', 'haliyora' ),
		'description' => __( 'URL untuk tombol login. Kosongkan untuk menggunakan default WordPress login.', 'haliyora' ),
		'section'     => 'haliyora_top_header',
		'type'        => 'url',
	) );
	
	// Section: SEO Settings
	$wp_customize->add_section( 'haliyora_seo', array(
		'title'    => __( 'SEO & Sitemap', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 20,
	) );
	
	$wp_customize->add_setting( 'haliyora_google_news_id', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'haliyora_google_news_id', array(
		'label'       => __( 'Google News ID', 'haliyora' ),
		'description' => __( 'Masukkan Google News ID untuk SEO', 'haliyora' ),
		'section'     => 'haliyora_seo',
		'type'        => 'text',
	) );
	
	$wp_customize->add_setting( 'haliyora_sitemap_enable', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	
	$wp_customize->add_control( 'haliyora_sitemap_enable', array(
		'label'       => __( 'Enable Sitemap', 'haliyora' ),
		'description' => __( 'Aktifkan sitemap untuk website', 'haliyora' ),
		'section'     => 'haliyora_seo',
		'type'        => 'checkbox',
	) );
	
	// Section: Footer Settings
	$wp_customize->add_section( 'haliyora_footer', array(
		'title'    => __( 'Footer', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 30,
	) );
	
	$wp_customize->add_setting( 'haliyora_footer_info', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	
	$wp_customize->add_control( 'haliyora_footer_info', array(
		'label'       => __( 'Footer Information', 'haliyora' ),
		'description' => __( 'Informasi tentang situs yang ditampilkan di footer', 'haliyora' ),
		'section'     => 'haliyora_footer',
		'type'        => 'textarea',
	) );
	
	// Social Media Settings
	$wp_customize->add_setting( 'haliyora_facebook_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_facebook_url', array(
		'label'   => __( 'Facebook URL', 'haliyora' ),
		'section' => 'haliyora_footer',
		'type'    => 'url',
	) );
	
	$wp_customize->add_setting( 'haliyora_twitter_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_twitter_url', array(
		'label'   => __( 'Twitter URL', 'haliyora' ),
		'section' => 'haliyora_footer',
		'type'    => 'url',
	) );
	
	$wp_customize->add_setting( 'haliyora_instagram_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_instagram_url', array(
		'label'   => __( 'Instagram URL', 'haliyora' ),
		'section' => 'haliyora_footer',
		'type'    => 'url',
	) );
	
	$wp_customize->add_setting( 'haliyora_youtube_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control( 'haliyora_youtube_url', array(
		'label'   => __( 'YouTube URL', 'haliyora' ),
		'section' => 'haliyora_footer',
		'type'    => 'url',
	) );
	
	// Section: Homepage Settings
	$wp_customize->add_section( 'haliyora_homepage', array(
		'title'    => __( 'Homepage Sections', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 40,
	) );
	
	// Video Stories Settings
	$wp_customize->add_setting( 'haliyora_video_stories_title', array(
		'default'           => 'Video Stories',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'haliyora_video_stories_title', array(
		'label'    => __( 'Video Stories Header Title', 'haliyora' ),
		'section'  => 'haliyora_homepage',
		'type'     => 'text',
	) );
	
	$video_cat_options = array( '0' => __( '-- All Categories --', 'haliyora' ) );
	
	// Video Story Categories
	$video_cats = get_terms( array(
		'taxonomy'   => 'video_story_category',
		'hide_empty' => false,
	) );
	if ( ! is_wp_error( $video_cats ) && ! empty( $video_cats ) ) {
		foreach ( $video_cats as $cat ) {
			$video_cat_options[ 'vs_' . $cat->term_id ] = 'Video Category: ' . $cat->name;
		}
	}
	
	// Regular Post Categories
	$post_cats_obj = get_categories();
	if ( ! empty( $post_cats_obj ) ) {
		foreach ( $post_cats_obj as $cat ) {
			$video_cat_options[ 'cat_' . $cat->term_id ] = 'Post Category: ' . $cat->name;
		}
	}
	
	$wp_customize->add_setting( 'haliyora_video_stories_category', array(
		'default'           => '0',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'haliyora_video_stories_category', array(
		'label'    => __( 'Video Stories Category', 'haliyora' ),
		'section'  => 'haliyora_homepage',
		'type'     => 'select',
		'choices'  => $video_cat_options,
	) );

	$wp_customize->add_setting( 'haliyora_video_stories_count', array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'haliyora_video_stories_count', array(
		'label'       => __( 'Video Stories Post Count', 'haliyora' ),
		'description' => __( 'Jumlah video stories yang akan ditampilkan', 'haliyora' ),
		'section'     => 'haliyora_homepage',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 20,
			'step' => 1,
		),
	) );
	
	// Rekomendasi Settings
	$wp_customize->add_setting( 'haliyora_rekomendasi_title', array(
		'default'           => 'Rekomendasi',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'haliyora_rekomendasi_title', array(
		'label'    => __( 'Rekomendasi Header Title', 'haliyora' ),
		'section'  => 'haliyora_homepage',
		'type'     => 'text',
	) );
	
	$post_cats = get_categories();
	$post_cat_options = array( 0 => __( '-- All Categories --', 'haliyora' ) );
	foreach ( $post_cats as $cat ) {
		$post_cat_options[ $cat->term_id ] = $cat->name;
	}
	
	$wp_customize->add_setting( 'haliyora_rekomendasi_category', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );
	
	$wp_customize->add_control( 'haliyora_rekomendasi_category', array(
		'label'    => __( 'Rekomendasi Category', 'haliyora' ),
		'section'  => 'haliyora_homepage',
		'type'     => 'select',
		'choices'  => $post_cat_options,
	) );
	
	$wp_customize->add_setting( 'haliyora_rekomendasi_orderby', array(
		'default'           => 'date',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	
	$wp_customize->add_control( 'haliyora_rekomendasi_orderby', array(
		'label'    => __( 'Rekomendasi Sort By', 'haliyora' ),
		'section'  => 'haliyora_homepage',
		'type'     => 'select',
		'choices'  => array(
			'date'   => __( 'Recent Posts', 'haliyora' ),
			'rand'   => __( 'Random Posts', 'haliyora' ),
		),
	) );

	$wp_customize->add_setting( 'haliyora_rekomendasi_count', array(
		'default'           => 6,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'haliyora_rekomendasi_count', array(
		'label'       => __( 'Rekomendasi Post Count', 'haliyora' ),
		'description' => __( 'Jumlah berita rekomendasi yang akan ditampilkan', 'haliyora' ),
		'section'     => 'haliyora_homepage',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 20,
			'step' => 1,
		),
	) );

	// Section: Sidebar Settings
	$wp_customize->add_section( 'haliyora_sidebar_settings', array(
		'title'    => __( 'Sidebar Sections', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 50,
	) );

	// Kolomnis Sidebar Settings
	$wp_customize->add_setting( 'haliyora_kolomnis_title', array(
		'default'           => 'Kolomnis',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'haliyora_kolomnis_title', array(
		'label'    => __( 'Kolomnis Sidebar Title', 'haliyora' ),
		'section'  => 'haliyora_sidebar_settings',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'haliyora_kolomnis_category', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'haliyora_kolomnis_category', array(
		'label'    => __( 'Kolomnis Category', 'haliyora' ),
		'section'  => 'haliyora_sidebar_settings',
		'type'     => 'select',
		'choices'  => $post_cat_options,
	) );

	// Trending Sidebar Settings
	$wp_customize->add_setting( 'haliyora_trending_period', array(
		'default'           => '7',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'haliyora_trending_period', array(
		'label'    => __( 'Trending Popularity Period', 'haliyora' ),
		'section'  => 'haliyora_sidebar_settings',
		'type'     => 'select',
		'choices'  => array(
			'1'  => __( 'Popular Last 1 Day', 'haliyora' ),
			'7'  => __( 'Popular Last 7 Days', 'haliyora' ),
			'30' => __( 'Popular Last 30 Days', 'haliyora' ),
		),
	) );

	// Section: KempalPlus Settings
	$wp_customize->add_section( 'haliyora_kempalplus', array(
		'title'    => __( 'KempalPlus Page', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 60,
	) );

	$wp_customize->add_setting( 'haliyora_kempalplus_category', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'haliyora_kempalplus_category', array(
		'label'    => __( 'KempalPlus Category', 'haliyora' ),
		'description' => __( 'Pilih kategori berita yang akan ditampilkan di halaman KempalPlus', 'haliyora' ),
		'section'  => 'haliyora_kempalplus',
		'type'     => 'select',
		'choices'  => $post_cat_options,
	) );

	$wp_customize->add_setting( 'haliyora_kempalplus_title_custom', array(
		'default'           => 'kempal<span>PLUS</span>',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'haliyora_kempalplus_title_custom', array(
		'label'    => __( 'KempalPlus Header Title', 'haliyora' ),
		'section'  => 'haliyora_kempalplus',
		'type'     => 'text',
	) );

	$wp_customize->add_setting( 'haliyora_kempalplus_desc_custom', array(
		'default'           => 'Konten eksklusif dari kreator dan pakar pilihan kempalan untuk informasi yang lebih mendalam.',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'haliyora_kempalplus_desc_custom', array(
		'label'    => __( 'KempalPlus Description', 'haliyora' ),
		'section'  => 'haliyora_kempalplus',
		'type'     => 'textarea',
	) );

	$wp_customize->add_setting( 'haliyora_kempalplus_count', array(
		'default'           => 9,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'haliyora_kempalplus_count', array(
		'label'       => __( 'KempalPlus Post Count', 'haliyora' ),
		'section'     => 'haliyora_kempalplus',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 3,
			'max'  => 30,
			'step' => 3,
		),
	) );

	// Section: Theme Update
	$wp_customize->add_section( 'haliyora_theme_update', array(
		'title'    => __( 'Theme Update', 'haliyora' ),
		'panel'    => 'haliyora_settings',
		'priority' => 100,
	) );

	$wp_customize->add_setting( 'haliyora_current_version', array(
		'default'           => wp_get_theme()->get( 'Version' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'haliyora_current_version', array(
		'label'       => __( 'Current Theme Version', 'haliyora' ),
		'description' => __( 'Versi tema yang saat ini terpasang di website Anda.', 'haliyora' ),
		'section'     => 'haliyora_theme_update',
		'type'        => 'text',
		'input_attrs' => array(
			'readonly' => 'readonly',
			'style'    => 'background: #f0f0f1; border-color: #ddd; color: #666; cursor: default;',
		),
	) );

	$wp_customize->add_setting( 'haliyora_update_check', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	/**
	 * Custom Control for Update Button
	 */
	class Haliyora_Update_Control extends WP_Customize_Control {
		public $type = 'haliyora_update_button';
		public function render_content() {
			?>
			<div style="margin-top: 20px; padding: 20px; background: #1e293b; border-radius: 12px; color: #fff; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
				<div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
					<div style="background: #00a9b8; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
						<span class="dashicons dashicons-github" style="color: #fff; margin: 0;"></span>
					</div>
					<label class="customize-control-title" style="margin: 0; color: #fff; font-weight: 700;"><?php echo esc_html( $this->label ); ?></label>
				</div>
				
				<p class="description" style="margin-bottom: 20px; color: #94a3b8; font-size: 13px; line-height: 1.5;">
					<?php echo esc_html( $this->description ); ?>
				</p>
				
				<div id="haliyora-update-status" style="margin-bottom: 20px; padding: 12px; border-radius: 8px; background: rgba(255,255,255,0.05); display: none;"></div>
				
				<button type="button" class="button button-primary" id="haliyora-check-update-btn" style="width: 100%; height: 42px; border-radius: 8px; background: #00a9b8; border: none; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;">
					<span class="dashicons dashicons-update" style="font-size: 18px; width: 18px; height: 18px; margin: 0;"></span> 
					Periksa Pembaruan
				</button>
				
				<a id="haliyora-apply-update-btn" href="#" target="_blank" class="button button-secondary" style="width: 100%; height: 42px; border-radius: 8px; margin-top: 12px; display: none; align-items: center; justify-content: center; gap: 8px; background: #fff; color: #1e293b; border: none; font-weight: 700;">
					<span class="dashicons dashicons-download" style="font-size: 18px; width: 18px; height: 18px; margin: 0;"></span> 
					Unduh Versi Terbaru
				</a>

				<div style="margin-top: 15px; text-align: center;">
					<a href="https://github.com/mgunturbudiawan-oss/kempalan" target="_blank" style="color: #64748b; text-decoration: none; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
						<span class="dashicons dashicons-external" style="font-size: 12px; width: 12px; height: 12px;"></span> 
						Buka Repositori GitHub
					</a>
				</div>
			</div>

			<script>
			jQuery(document).ready(function($) {
				$('#haliyora-check-update-btn').on('click', function() {
					var $btn = $(this);
					var $status = $('#haliyora-update-status');
					
					$btn.prop('disabled', true).text('Menghubungkan ke GitHub...');
					$status.hide();

					$.ajax({
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						type: 'POST',
						data: {
							action: 'haliyora_check_github_update'
						},
						success: function(response) {
							$btn.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Periksa Pembaruan');
							
							if (response.success) {
								var currentVer = '<?php echo wp_get_theme()->get( "Version" ); ?>';
								var latestVer = response.data.latest;
								var downloadUrl = response.data.url;
								var notes = response.data.notes;

								if (latestVer > currentVer) {
									$status.html(
										'<div style="color: #f87171; font-weight: 700; margin-bottom: 5px;">Update Tersedia: v' + latestVer + '</div>' +
										'<div style="color: #94a3b8; font-size: 12px; font-weight: 400;">' + notes + '</div>'
									).fadeIn();
									$('#haliyora-apply-update-btn').attr('href', downloadUrl).css('display', 'flex');
								} else {
									$status.html('<div style="color: #34d399; font-weight: 700; text-align: center;">Tema Anda sudah versi terbaru! (v'+currentVer+')</div>').fadeIn();
									$('#haliyora-apply-update-btn').hide();
								}
							} else {
								$status.html('<div style="color: #f87171; font-size: 12px;">Error: ' + response.data + '</div>').fadeIn();
							}
						},
						error: function() {
							$btn.prop('disabled', false).html('<span class="dashicons dashicons-update"></span> Periksa Pembaruan');
							$status.html('<div style="color: #f87171; font-size: 12px;">Gagal menghubungi server.</div>').fadeIn();
						}
					});
				});
			});
			</script>
			<?php
		}
	}

	$wp_customize->add_control( new Haliyora_Update_Control( $wp_customize, 'haliyora_update_button', array(
		'label'       => __( 'System Update', 'haliyora' ),
		'description' => __( 'Klik tombol di bawah untuk mengecek apakah ada pembaruan versi tema Haliyora yang tersedia di server.', 'haliyora' ),
		'section'     => 'haliyora_theme_update',
		'priority'    => 20,
	) ) );
}
add_action( 'customize_register', 'haliyora_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function haliyora_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function haliyora_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function haliyora_customize_preview_js() {
	wp_enqueue_script( 'haliyora-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'haliyora_customize_preview_js' );
