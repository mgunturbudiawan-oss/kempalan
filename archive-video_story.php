<?php
/**
 * The template for displaying video story archives
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="video-stories-archive-container">
            <header class="video-stories-archive-header">
                <h1 class="video-stories-archive-title">
                    <span class="video-stories-archive-title-line"></span>
                    <?php _e( 'Video Stories', 'haliyora' ); ?>
                </h1>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="video-stories-archive-grid">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        
                        $video_type = get_post_meta( get_the_ID(), '_video_type', true );
                        $youtube_shorts_url = get_post_meta( get_the_ID(), '_youtube_shorts_url', true );
                        $tiktok_embed_url = get_post_meta( get_the_ID(), '_tiktok_embed_url', true );
                        $video_duration = get_post_meta( get_the_ID(), '_video_duration', true );
                        $video_source = get_post_meta( get_the_ID(), '_video_source', true );
                    ?>
                        <article class="video-story-card">
                            <a href="javascript:void(0);" onclick="openVideoStoryModal(<?php echo get_the_ID(); ?>, '<?php echo esc_js($video_type); ?>', '<?php echo esc_js($video_source); ?>', '<?php echo esc_js($youtube_shorts_url); ?>', '<?php echo esc_js($tiktok_embed_url); ?>')" class="video-story-link">
                                <div class="video-story-thumbnail">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium', array('class' => 'video-story-img') ); ?>
                                    <?php else: ?>
                                        <img src="https://placehold.co/300x400/e0e0e0/9e9e9e?text=Video" alt="<?php the_title_attribute(); ?>" class="video-story-img">
                                    <?php endif; ?>
                                    <div class="video-overlay">
                                        <span class="video-play-icon">
                                            <i class="fas fa-play"></i>
                                        </span>
                                    </div>
                                    <?php if ( $video_duration ) : ?>
                                        <div class="video-time-badge"><?php echo haliyora_format_video_duration($video_duration); ?></div>
                                    <?php endif; ?>
                                    <h3 class="video-story-card-title"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="video-stories-pagination">
                    <?php the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '<span class="material-icons">chevron_left</span>',
                        'next_text' => '<span class="material-icons">chevron_right</span>',
                    ) ); ?>
                </div>
            <?php else : ?>
                <p class="no-video-stories"><?php _e( 'No video stories found.', 'haliyora' ); ?></p>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php
get_footer();