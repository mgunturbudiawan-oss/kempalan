<?php
/**
 * The template for displaying video story posts
 */

get_header();
?>

<style>
.single-video-story-container {
    max-width: 100%;
    margin: 0 auto;
    background: #000;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.single-video-wrapper {
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    position: relative;
}

.single-video-content {
    position: relative;
    width: 100%;
    aspect-ratio: 9/16;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
}

.single-video-content video,
.single-video-content iframe {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.single-video-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 30px 20px 20px;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
    color: #fff;
}

.single-video-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 10px 0;
    color: #fff;
}

.single-video-description {
    font-size: 14px;
    line-height: 1.4;
    color: rgba(255,255,255,0.9);
}

@media (max-width: 768px) {
    .single-video-wrapper {
        max-width: 100%;
    }
    
    .single-video-content {
        border-radius: 0;
        aspect-ratio: 9/16;
        min-height: 100vh;
    }
}
</style>

<div class="single-video-story-container">
    <?php
    while ( have_posts() ) :
        the_post();
        
        $video_type = get_post_meta( get_the_ID(), '_video_type', true );
        $youtube_shorts_url = get_post_meta( get_the_ID(), '_youtube_shorts_url', true );
        $tiktok_embed_url = get_post_meta( get_the_ID(), '_tiktok_embed_url', true );
        $video_duration = get_post_meta( get_the_ID(), '_video_duration', true );
        $video_source = get_post_meta( get_the_ID(), '_video_source', true );
    ?>
        <div class="single-video-wrapper">
            <div class="single-video-content">
                <?php if ( $video_type === 'youtube_shorts' && !empty( $youtube_shorts_url ) ) : ?>
                    <iframe 
                        src="<?php echo esc_url( str_replace( 'watch?v=', 'embed/', str_replace( 'shorts/', 'embed/', $youtube_shorts_url ) ) ); ?>" 
                        frameborder="0" 
                        allowfullscreen
                        allow="autoplay; encrypted-media">
                    </iframe>
                <?php elseif ( $video_type === 'tiktok' && !empty( $tiktok_embed_url ) ) : ?>
                    <iframe 
                        src="https://www.tiktok.com/embed/oembed?url=<?php echo urlencode($tiktok_embed_url); ?>" 
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                <?php elseif ( $video_type === 'upload' && !empty( $video_source ) ) : ?>
                    <video controls playsinline>
                        <source src="<?php echo esc_url( $video_source ); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>

                <div class="single-video-info">
                    <h1 class="single-video-title"><?php the_title(); ?></h1>
                    <?php if ( get_the_content() ) : ?>
                        <div class="single-video-description"><?php the_content(); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php
    endwhile;
    ?>
</div>

<?php
get_footer();