jQuery(document).ready(function($) {
    // Handle swipe gestures for mobile video story navigation
    let startY;
    
    // Check if we're on a video stories page or if video stories are present on homepage
    if ($('.video-stories-container').length > 0) {
        // Touch events for mobile navigation
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
                    showNextSlide();
                } else {
                    // Swiped down - go to previous
                    showPrevSlide();
                }
            }
            
            startY = null;
        });
        
        // Mouse wheel for desktop navigation
        $('.video-stories-container').on('wheel', function(e) {
            e.preventDefault();
            
            if (e.originalEvent.deltaY > 0) {
                // Scrolled down - go to next
                showNextSlide();
            } else {
                // Scrolled up - go to previous
                showPrevSlide();
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
        
        // Navigation functions
        function showNextSlide() {
            const $current = $('.video-story-slide.active');
            const $next = $current.next('.video-story-slide');
            
            if ($next.length > 0) {
                $current.removeClass('active');
                $next.addClass('active');
            } else {
                // If at the end, loop back to the first
                $('.video-story-slide').first().addClass('active');
                $current.removeClass('active');
            }
        }
        
        function showPrevSlide() {
            const $current = $('.video-story-slide.active');
            const $prev = $current.prev('.video-story-slide');
            
            if ($prev.length > 0) {
                $current.removeClass('active');
                $prev.addClass('active');
            } else {
                // If at the beginning, loop to the last
                $('.video-story-slide').last().addClass('active');
                $current.removeClass('active');
            }
        }
    }
    
    // Handle like button click (works everywhere)
    $(document).on('click', '.like-btn, .popup-like-btn', function(e) {
        e.stopPropagation();
        
        var button = $(this);
        var postId = button.data('post-id');
        var heartIcon = button.find('i');
        
        // Toggle heart icon
        heartIcon.toggleClass('far fas');
        heartIcon.toggleClass('text-white text-danger');
        
        // Send AJAX request to update like count
        $.post(ajax_object.ajax_url, {
            action: 'haliyora_like_video',
            post_id: postId,
            nonce: ajax_object.nonce
        }, function(response) {
            if (!response.success) {
                // Revert the icon if request failed
                heartIcon.toggleClass('far fas');
                heartIcon.toggleClass('text-white text-danger');
            }
        });
    });
    
    // Handle share button clicks (works everywhere)
    $(document).on('click', '.share-btn, .popup-share-btn', function(e) {
        e.stopPropagation();
        
        var url = $(this).data('url');
        var title = $(this).data('title') || document.title;
        
        // Try to use the Web Share API if available
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            }).catch(console.error);
        } else {
            // Fallback: copy to clipboard
            copyToClipboard(url);
            alert('Link copied to clipboard: ' + url);
        }
    });
    
    // Function to copy text to clipboard
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text);
        } else {
            // Fallback for older browsers
            var textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }
    }
    
    // Handle comment submission
    $(document).on('click', '.submit-comment', function(e) {
        e.preventDefault();
        
        var commentTextarea = $(this).siblings('textarea');
        var commentText = commentTextarea.val();
        
        if (commentText.trim() === '') {
            alert('Please enter a comment');
            return;
        }
        
        // In a real implementation, you would send this to the server
        // For now, just add it to the comments list
        var commentHtml = `
            <div class="comment-item">
                <div class="comment-author">${haliyoraCurrentUserData.display_name || 'Anonymous'}</div>
                <div class="comment-text">${commentText}</div>
                <div class="comment-date">Just now</div>
            </div>
        `;
        
        $('.comments-list').prepend(commentHtml);
        commentTextarea.val('');
    });
    
    // Initialize TikTok embeds if present
    if (typeof tkt === 'undefined') {
        // Load TikTok embed script if needed
        if ($('.tiktok-embed').length > 0) {
            $.getScript('https://www.tiktok.com/embed.js');
        }
    }

    // Function to open video story modal
    window.openVideoStoryModal = function(postId, videoType, videoSource, youtubeShortsUrl, tiktokEmbedUrl) {
        // Determine the video HTML based on type
        let videoHtml = '';
        if (videoType === 'upload' && videoSource) {
            videoHtml = `<video width="100%" height="100%" controls playsinline>
                            <source src="${videoSource}" type="video/mp4">
                            Your browser does not support the video tag.
                         </video>`;
        } else if (videoType === 'youtube_shorts' && youtubeShortsUrl) {
            const embedUrl = youtubeShortsUrl.replace('watch?v=', 'embed/').replace('shorts/', 'embed/');
            videoHtml = `<iframe width="100%" height="100%" src="${embedUrl}" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>`;
        } else if (videoType === 'tiktok' && tiktokEmbedUrl) {
            videoHtml = `<iframe width="100%" height="100%" src="https://www.tiktok.com/embed/oembed?url=${encodeURIComponent(tiktokEmbedUrl)}" frameborder="0" allowfullscreen></iframe>`;
        } else {
            videoHtml = '<div class="no-video">No video available</div>';
        }

        // Get the post title and content
        let title = '';
        let content = '';
        // Since we don't have direct access to the post data, we'll fetch it via AJAX
        $.post(ajax_object.ajax_url, {
            action: 'get_video_story_data',
            post_id: postId,
            nonce: ajax_object.nonce
        }, function(response) {
            if (response.success) {
                title = response.data.title;
                content = response.data.content;

                // Detect if mobile device
                const isMobile = window.innerWidth <= 768;

                if (isMobile) {
                    // Create mobile full screen video story view (TikTok/Reels style)
                    const mobileHtml = `
                        <div class="video-story-mobile-view" data-current-id="${postId}">
                            <button class="mobile-close-btn">&times;</button>
                            <div class="mobile-video-container">
                                ${videoHtml}
                            </div>
                            <div class="mobile-video-overlay">
                                <div class="mobile-video-content">
                                    <h3>${title}</h3>
                                    <p>${content}</p>
                                </div>
                                <div class="mobile-video-actions">
                                    <button class="mobile-action-btn like-btn" data-post-id="${postId}">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="mobile-action-btn share-btn" data-url="${response.data.permalink}" data-title="${title}">
                                        <i class="fas fa-share"></i>
                                    </button>
                                    <div class="mobile-profile-pic">${title.charAt(0)}</div>
                                </div>
                            </div>
                        </div>`;

                    // Add mobile view to body and show it
                    $('body').append(mobileHtml);

                    // Close mobile view when clicking close button
                    $('.mobile-close-btn').click(function() {
                        $('.video-story-mobile-view').remove();
                    });

                    // Handle like button in mobile view
                    $(document).off('click', '.mobile-action-btn.like-btn').on('click', '.mobile-action-btn.like-btn', function(e) {
                        e.stopPropagation();

                        var button = $(this);
                        var postId = button.data('post-id');
                        var heartIcon = button.find('i');

                        // Toggle heart icon
                        heartIcon.toggleClass('far fas');
                        heartIcon.toggleClass('text-white text-danger');

                        // Send AJAX request to update like count
                        $.post(ajax_object.ajax_url, {
                            action: 'haliyora_like_video',
                            post_id: postId,
                            nonce: ajax_object.nonce
                        }, function(response) {
                            if (!response.success) {
                                // Revert the icon if request failed
                                heartIcon.toggleClass('far fas');
                                heartIcon.toggleClass('text-white text-danger');
                            }
                        });
                    });

                    // Handle share button in mobile view
                    $(document).off('click', '.mobile-action-btn.share-btn').on('click', '.mobile-action-btn.share-btn', function(e) {
                        e.stopPropagation();

                        var url = $(this).data('url');
                        var title = $(this).data('title') || document.title;

                        // Try to use the Web Share API if available
                        if (navigator.share) {
                            navigator.share({
                                title: title,
                                url: url
                            }).catch(console.error);
                        } else {
                            // Fallback: copy to clipboard
                            copyToClipboard(url);
                            alert('Link copied to clipboard: ' + url);
                        }
                    });
                    
                    // Fetch and cache the next/previous video stories for swiping
                    fetchAdjacentStories(postId);
                } else {
                    // Create desktop popup view
                    const modalHtml = `
                        <div class="video-popup-overlay" style="display:flex;">
                            <div class="video-popup-content">
                                <button class="popup-close-btn">&times;</button>
                                <div class="video-popup-left">
                                    <div class="popup-video-container">
                                        ${videoHtml}
                                    </div>
                                </div>
                                <div class="video-popup-right">
                                    <h3>${title}</h3>
                                    <div class="popup-content-details">${content}</div>
                                    <div class="popup-actions">
                                        <button class="popup-like-btn" data-post-id="${postId}">
                                            <i class="far fa-heart"></i> Like
                                        </button>
                                        <button class="popup-share-btn" data-url="${response.data.permalink}">
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
                                </div>
                            </div>
                        </div>`;

                    // Add modal to body and show it
                    $('body').append(modalHtml);

                    // Close modal when clicking on close button
                    $('.popup-close-btn').click(function() {
                        $('.video-popup-overlay').remove();
                    });

                    // Close modal when clicking on overlay
                    $('.video-popup-overlay').click(function(e) {
                        if (e.target === this) {
                            $(this).remove();
                        }
                    });

                    // Handle like button
                    $(document).off('click', '.popup-like-btn').on('click', '.popup-like-btn', function(e) {
                        e.stopPropagation();

                        var button = $(this);
                        var postId = button.data('post-id');
                        var heartIcon = button.find('i');

                        // Toggle heart icon
                        heartIcon.toggleClass('far fas');
                        heartIcon.toggleClass('text-white text-danger');

                        // Send AJAX request to update like count
                        $.post(ajax_object.ajax_url, {
                            action: 'haliyora_like_video',
                            post_id: postId,
                            nonce: ajax_object.nonce
                        }, function(response) {
                            if (!response.success) {
                                // Revert the icon if request failed
                                heartIcon.toggleClass('far fas');
                                heartIcon.toggleClass('text-white text-danger');
                            }
                        });
                    });

                    // Handle share button
                    $(document).off('click', '.popup-share-btn').on('click', '.popup-share-btn', function(e) {
                        e.stopPropagation();

                        var url = $(this).data('url');
                        var title = $(this).data('title') || document.title;

                        // Try to use the Web Share API if available
                        if (navigator.share) {
                            navigator.share({
                                title: title,
                                url: url
                            }).catch(console.error);
                        } else {
                            // Fallback: copy to clipboard
                            copyToClipboard(url);
                            alert('Link copied to clipboard: ' + url);
                        }
                    });
                }
            }
        });
    };
    
    // Function to fetch adjacent video stories for swiping navigation
    function fetchAdjacentStories(currentId) {
        $.post(ajax_object.ajax_url, {
            action: 'get_adjacent_video_stories',
            current_id: currentId,
            nonce: ajax_object.nonce
        }, function(response) {
            if (response.success) {
                window.adjacentStories = response.data;
            }
        });
    }

    // Close modal with Escape key
    $(document).keydown(function(e) {
        if (e.key === 'Escape') {
            $('.video-popup-overlay, .video-story-mobile-view').remove();
        }
    });
    
    // Handle swipe gestures for mobile video story navigation in mobile view
    let mobileStartY;
    
    // Touch events for mobile navigation in mobile view
    $(document).on('touchstart', '.video-story-mobile-view', function(e) {
        mobileStartY = e.originalEvent.touches[0].clientY;
    });
    
    $(document).on('touchend', '.video-story-mobile-view', function(e) {
        if (!mobileStartY) return;
        
        const endY = e.originalEvent.changedTouches[0].clientY;
        const diffY = mobileStartY - endY;
        
        // Swipe down for previous, swipe up for next
        if (Math.abs(diffY) > 50) { // Minimum swipe distance
            if (diffY > 0) {
                // Swiped up - go to next
                navigateToAdjacentStory('next');
            } else {
                // Swiped down - go to previous
                navigateToAdjacentStory('prev');
            }
        }
        
        mobileStartY = null;
    });
    
    // Function to navigate to adjacent story
    function navigateToAdjacentStory(direction) {
        const currentId = parseInt($('.video-story-mobile-view').data('current-id'));
        let targetStory = null;
        
        if (window.adjacentStories && window.adjacentStories[direction]) {
            targetStory = window.adjacentStories[direction];
        }
        
        if (targetStory) {
            // Close current view and open new one
            $('.video-story-mobile-view').remove();
            
            // Open the new story
            setTimeout(() => {
                openVideoStoryModal(
                    targetStory.id,
                    targetStory.video_type,
                    targetStory.video_source,
                    targetStory.youtube_shorts_url,
                    targetStory.tiktok_embed_url
                );
            }, 300);
        }
    }
});