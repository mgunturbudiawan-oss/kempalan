jQuery(document).ready(function($) {
    // Handle like button clicks
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
    
    // Handle share button clicks
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
});