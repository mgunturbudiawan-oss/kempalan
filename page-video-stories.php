<?php
/**
 * Template Name: Video Stories Page
 * Description: A TikTok-like video stories experience
 */

get_header();
?>

<style>
.video-stories-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.video-story-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-story-slide.active {
    opacity: 1;
}

.video-story-slide video,
.video-story-slide iframe {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-story-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
    z-index: 10;
}

.video-story-actions {
    position: absolute;
    right: 20px;
    bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    z-index: 10;
}

.action-btn {
    background: rgba(0,0,0,0.5);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    font-size: 20px;
}

.video-story-actions .profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
    background-color: #ccc;
    background-size: cover;
}

.play-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0,0.7);
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    z-index: 5;
}

.video-duration {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 5;
}

/* Desktop Popup Styles */
.video-popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.video-popup-content {
    display: flex;
    width: 90%;
    max-width: 1200px;
    height: 80%;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

.video-popup-left {
    flex: 1;
    position: relative;
}

.video-popup-right {
    width: 400px;
    padding: 20px;
    overflow-y: auto;
    background: white;
}

.popup-video-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.popup-video-container video,
.popup-video-container iframe {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

@media (max-width: 768px) {
    .video-popup-content {
        flex-direction: column;
        height: 90%;
        width: 95%;
    }
    
    .video-popup-right {
        width: 100%;
        height: 40%;
    }
}
</style>

<div class="video-stories-container">
    <?php
    $video_stories = new WP_Query(array(
        'post_type' => 'video_story',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ));
    
    $counter = 0;
    if ($video_stories->have_posts()) :
        while ($video_stories->have_posts()) : $video_stories->the_post();
            $video_type = get_post_meta(get_the_ID(), '_video_type', true);
            $youtube_shorts_url = get_post_meta(get_the_ID(), '_youtube_shorts_url', true);
            $tiktok_embed_url = get_post_meta(get_the_ID(), '_tiktok_embed_url', true);
            $video_duration = get_post_meta(get_the_ID(), '_video_duration', true);
            $video_source = get_post_meta(get_the_ID(), '_video_source', true);
    ?>
        <div class="video-story-slide <?php echo $counter === 0 ? 'active' : ''; ?>" data-index="<?php echo $counter; ?>">
            <?php if ($video_type === 'youtube_shorts' && !empty($youtube_shorts_url)) : ?>
                <iframe width="100%" height="100%" 
                        src="<?php echo esc_url(str_replace('watch?v=', 'embed/', str_replace('shorts/', 'embed/', $youtube_shorts_url))); ?>" 
                        frameborder="0" 
                        allowfullscreen 
                        allow="autoplay; encrypted-media">
                </iframe>
            <?php elseif ($video_type === 'tiktok' && !empty($tiktok_embed_url)) : ?>
                <iframe width="100%" height="100%" 
                        src="https://www.tiktok.com/embed/oembed?url=<?php echo urlencode($tiktok_embed_url); ?>" 
                        frameborder="0" 
                        allowfullscreen>
                </iframe>
            <?php elseif ($video_type === 'upload' && !empty($video_source)) : ?>
                <video width="100%" height="100%" controls playsinline>
                    <source src="<?php echo esc_url($video_source); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="play-overlay">▶</div>
            <?php endif; ?>
            
            <?php if ($video_duration) : ?>
                <div class="video-duration"><?php echo gmdate('i:s', $video_duration); ?></div>
            <?php endif; ?>
            
            <div class="video-story-content">
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_content(), 15); ?></p>
            </div>
            
            <div class="video-story-actions">
                <div class="profile-pic"></div>
                <div class="action-btn like-btn" data-post-id="<?php the_ID(); ?>">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="action-btn comment-btn">
                    <i class="fas fa-comment"></i>
                </div>
                <div class="action-btn share-btn" data-url="<?php the_permalink(); ?>">
                    <i class="fas fa-share"></i>
                </div>
            </div>
        </div>
    <?php 
            $counter++;
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No video stories found.</p>';
    endif;
    ?>
</div>

<!-- Desktop Popup Modal -->
<div class="video-popup-overlay">
    <div class="video-popup-content">
        <div class="video-popup-left">
            <div class="popup-video-container">
                <!-- Video will be loaded here dynamically -->
            </div>
        </div>
        <div class="video-popup-right">
            <div class="popup-content-details">
                <!-- Content details will be loaded here dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    let currentIndex = 0;
    const slides = $('.video-story-slide');
    const totalSlides = slides.length;
    
    // Function to show a specific slide
    function showSlide(index) {
        slides.removeClass('active');
        slides.eq(index).addClass('active');
        currentIndex = index;
    }
    
    // Handle swipe gestures for mobile
    let startY;
    $('.video-stories-container').on('touchstart', function(e) {
        startY = e.originalEvent.touches[0].clientY;
    });
    
    $('.video-stories-container').on('touchend', function(e) {
        if (!startY) return;
        
        const endY = e.originalEvent.changedTouches[0].clientY;
        const diffY = startY - endY;
        
        // Swipe down for previous, swipe up for next
        if (Math.abs(diffY) > 50) { // Minimum swipe distance
            if (diffY > 0) {
                // Swiped up - go to next
                if (currentIndex < totalSlides - 1) {
                    showSlide(currentIndex + 1);
                }
            } else {
                // Swiped down - go to previous
                if (currentIndex > 0) {
                    showSlide(currentIndex - 1);
                }
            }
        }
        
        startY = null;
    });
    
    // Handle mouse wheel for desktop navigation
    $('.video-stories-container').on('wheel', function(e) {
        e.preventDefault();
        
        if (e.originalEvent.deltaY > 0) {
            // Scrolled down - go to next
            if (currentIndex < totalSlides - 1) {
                showSlide(currentIndex + 1);
            }
        } else {
            // Scrolled up - go to previous
            if (currentIndex > 0) {
                showSlide(currentIndex - 1);
            }
        }
    });
    
    // Click on video to toggle play/pause for uploaded videos
    $(document).on('click', '.video-story-slide video', function() {
        if (this.paused) {
            this.play();
        } else {
            this.pause();
        }
    });
    
    // Handle like button click
    $(document).on('click', '.like-btn', function() {
        const postId = $(this).data('post-id');
        const heartIcon = $(this).find('i');
        
        $.post(ajax_object.ajax_url, {
            action: 'haliyora_like_video',
            post_id: postId,
            nonce: ajax_object.nonce
        }, function(response) {
            if (response.success) {
                heartIcon.toggleClass('fas far');
                heartIcon.toggleClass('fa-heart fa-heart'); // Just toggles color
                heartIcon.css('color', heartIcon.hasClass('fas') ? 'red' : 'white');
            }
        });
    });
    
    // Handle share button click
    $(document).on('click', '.share-btn', function() {
        const url = $(this).data('url');
        
        if (navigator.share) {
            navigator.share({
                title: $('h3', $(this).closest('.video-story-slide')).text(),
                url: url
            }).catch(console.error);
        } else {
            // Fallback for browsers that don't support Web Share API
            alert('Copy this link: ' + url);
        }
    });
    
    // Show desktop popup when clicking on a video story (on desktop)
    if ($(window).width() > 768) {
        $(document).on('click', '.video-story-slide', function(e) {
            // Only trigger if not clicking on action buttons
            if (!$(e.target).closest('.video-story-actions, .video-story-content').length) {
                const index = $(this).data('index');
                openDesktopPopup(index);
            }
        });
    }
    
    // Function to open desktop popup
    function openDesktopPopup(index) {
        const slide = slides.eq(index);
        const postId = slide.find('.like-btn').data('post-id');
        
        // Get video HTML from the slide
        const videoHtml = slide.html();
        
        // Get content details
        const title = slide.find('h3').text();
        const content = slide.find('p').text();
        const permalink = slide.find('.share-btn').data('url');
        
        // Populate popup
        $('.popup-video-container').html(videoHtml);
        $('.popup-content-details').html(`
            <h3>${title}</h3>
            <p>${content}</p>
            <div class="popup-actions">
                <button class="popup-like-btn" data-post-id="${postId}">
                    <i class="far fa-heart"></i> Like
                </button>
                <button class="popup-share-btn" data-url="${permalink}">
                    <i class="fas fa-share"></i> Share
                </button>
            </div>
            <div class="comments-section">
                <h4>Comments</h4>
                <div class="comment-form">
                    <textarea placeholder="Write a comment..."></textarea>
                    <button class="submit-comment">Post</button>
                </div>
                <div class="comments-list">
                    <!-- Comments will appear here -->
                </div>
            </div>
        `);
        
        // Show popup
        $('.video-popup-overlay').fadeIn();
    }
    
    // Close popup
    $('.video-popup-overlay, .video-popup-content').click(function(e) {
        if (e.target === this) {
            $('.video-popup-overlay').fadeOut();
        }
    });
    
    // Handle popup like button
    $(document).on('click', '.popup-like-btn', function() {
        const postId = $(this).data('post-id');
        const heartIcon = $(this).find('i');
        
        $.post(ajax_object.ajax_url, {
            action: 'haliyora_like_video',
            post_id: postId,
            nonce: ajax_object.nonce
        }, function(response) {
            if (response.success) {
                heartIcon.toggleClass('fas far');
                heartIcon.toggleClass('fa-heart fa-heart');
            }
        });
    });
});
</script>

<?php
get_footer();