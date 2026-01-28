/**
 * Comprehensive React Integration for Haliyora Theme
 * Ensures React components work across all elements and pages
 */

(function() {
    'use strict';

    // Wait for React and ReactDOM to be available globally
    function waitForReact(callback) {
        if (typeof window.React !== 'undefined' && typeof window.ReactDOM !== 'undefined') {
            callback();
        } else {
            setTimeout(() => waitForReact(callback), 100);
        }
    }

    // React Components Library
    const HaliyoraReactComponents = {
        // Material Design Card Component
        MaterialCard: ({ title, children, className = '', style = {} }) => {
            const defaultStyle = {
                backgroundColor: '#fff',
                borderRadius: '4px',
                boxShadow: '0 2px 4px rgba(0,0,0,0.1)',
                padding: '20px',
                marginBottom: '20px',
                ...style
            };

            return React.createElement('div', {
                className: `material-card ${className}`,
                style: defaultStyle
            }, [
                title ? React.createElement('h3', {
                    key: 'title',
                    style: {
                        fontSize: '20px',
                        fontWeight: '500',
                        marginBottom: '15px',
                        color: '#212121'
                    }
                }, title) : null,
                React.createElement('div', { key: 'content' }, children)
            ]);
        },

        // Material Button Component
        MaterialButton: ({ children, onClick, variant = 'contained', className = '', disabled = false }) => {
            const styles = {
                contained: {
                    backgroundColor: '#1976d2',
                    color: '#fff',
                    border: 'none',
                    padding: '10px 20px',
                    borderRadius: '4px',
                    cursor: disabled ? 'not-allowed' : 'pointer',
                    fontSize: '14px',
                    fontWeight: '500',
                    transition: 'background-color 0.3s',
                    opacity: disabled ? 0.6 : 1
                },
                outlined: {
                    backgroundColor: 'transparent',
                    color: '#1976d2',
                    border: '1px solid #1976d2',
                    padding: '10px 20px',
                    borderRadius: '4px',
                    cursor: disabled ? 'not-allowed' : 'pointer',
                    fontSize: '14px',
                    fontWeight: '500',
                    transition: 'all 0.3s',
                    opacity: disabled ? 0.6 : 1
                }
            };

            return React.createElement('button', {
                className: `material-button ${className}`,
                style: styles[variant],
                onClick: disabled ? null : onClick,
                disabled: disabled,
                onMouseEnter: disabled ? null : (e) => {
                    if (variant === 'contained') {
                        e.target.style.backgroundColor = '#1565c0';
                    } else {
                        e.target.style.backgroundColor = '#e3f2fd';
                    }
                },
                onMouseLeave: disabled ? null : (e) => {
                    if (variant === 'contained') {
                        e.target.style.backgroundColor = '#1976d2';
                    } else {
                        e.target.style.backgroundColor = 'transparent';
                    }
                }
            }, children);
        },

        // Dynamic Content Loader Component
        DynamicContentLoader: ({ endpoint, renderFunction, loadingMessage = 'Loading...', errorMessage = 'Error loading data' }) => {
            const [data, setData] = React.useState([]);
            const [loading, setLoading] = React.useState(true);
            const [error, setError] = React.useState(null);

            React.useEffect(() => {
                const fetchData = async () => {
                    try {
                        const response = await fetch(endpoint);
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        const result = await response.json();
                        setData(Array.isArray(result) ? result : [result]);
                    } catch (err) {
                        setError(err.message);
                    } finally {
                        setLoading(false);
                    }
                };

                if (endpoint) {
                    fetchData();
                }
            }, [endpoint]);

            if (loading) {
                return React.createElement('div', { className: 'dynamic-loader' }, loadingMessage);
            }

            if (error) {
                return React.createElement('div', { className: 'dynamic-error' }, `${errorMessage}: ${error}`);
            }

            return renderFunction ? renderFunction(data) : React.createElement('div', null, 'No render function provided');
        },

        // Comment System Component
        CommentSystem: ({ postId, currentUser = null, enableReplies = true }) => {
            const [comments, setComments] = React.useState([]);
            const [newComment, setNewComment] = React.useState('');
            const [loading, setLoading] = React.useState(true);
            const [replyTo, setReplyTo] = React.useState(null);

            React.useEffect(() => {
                // Load comments for the post
                fetch(`/wp-json/wp/v2/comments?post=${postId}&per_page=50&_embed`)
                    .then(response => response.json())
                    .then(data => {
                        setComments(data);
                        setLoading(false);
                    })
                    .catch(error => {
                        console.error('Error loading comments:', error);
                        setLoading(false);
                    });
            }, [postId]);

            const handleSubmit = async (e) => {
                e.preventDefault();
                if (!newComment.trim()) return;

                // Submit new comment
                const commentData = {
                    post: postId,
                    content: newComment,
                    parent: replyTo || 0
                };

                // Add author info if available
                if (currentUser && currentUser.name) {
                    commentData.author_name = currentUser.name;
                    commentData.author_email = currentUser.email || 'anonymous@example.com';
                }

                try {
                    const response = await fetch('/wp-json/wp/v2/comments', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(commentData)
                    });

                    if (response.ok) {
                        const newCommentData = await response.json();
                        
                        // Add to comments list
                        if (replyTo) {
                            // For replies, we'll just refresh the list for simplicity
                            setComments([]);
                            setLoading(true);
                            // Reload comments
                            fetch(`/wp-json/wp/v2/comments?post=${postId}&per_page=50&_embed`)
                                .then(response => response.json())
                                .then(data => {
                                    setComments(data);
                                    setLoading(false);
                                });
                        } else {
                            setComments([newCommentData, ...comments]);
                        }
                        
                        setNewComment('');
                        setReplyTo(null);
                    } else {
                        const error = await response.json();
                        alert(`Error: ${error.code || 'Failed to submit comment'}`);
                    }
                } catch (error) {
                    console.error('Error submitting comment:', error);
                    alert('Error submitting comment');
                }
            };

            const handleReply = (commentId) => {
                setReplyTo(commentId);
                document.getElementById('comment-input').focus();
            };

            const cancelReply = () => {
                setReplyTo(null);
                setNewComment('');
            };

            if (loading) {
                return React.createElement('div', { className: 'comments-loading' }, 'Loading comments...');
            }

            return React.createElement('div', { className: 'react-comment-system' }, [
                React.createElement('h3', { key: 'comments-title', className: 'comments-title' }, `Comments (${comments.length})`),
                
                React.createElement('form', { 
                    key: 'comment-form', 
                    onSubmit: handleSubmit,
                    className: 'comment-form'
                }, [
                    React.createElement('div', { key: 'reply-indicator', className: 'reply-indicator' }, 
                        replyTo ? React.createElement('div', { className: 'replying-to' }, [
                            `Replying to comment `,
                            React.createElement('button', {
                                type: 'button',
                                onClick: cancelReply,
                                className: 'cancel-reply-btn'
                            }, 'Cancel')
                        ]) : null
                    ),
                    React.createElement('textarea', {
                        key: 'comment-textarea',
                        id: 'comment-input',
                        value: newComment,
                        onChange: (e) => setNewComment(e.target.value),
                        placeholder: replyTo ? 'Write your reply...' : 'Write a comment...',
                        rows: 3,
                        required: true,
                        className: 'comment-input'
                    }),
                    React.createElement('div', { key: 'comment-actions', className: 'comment-actions' }, [
                        React.createElement(HaliyoraReactComponents.MaterialButton, {
                            key: 'comment-submit-btn',
                            children: replyTo ? 'Reply' : 'Post Comment',
                            variant: 'contained',
                            onClick: handleSubmit
                        }),
                        replyTo && React.createElement(HaliyoraReactComponents.MaterialButton, {
                            key: 'cancel-reply-btn',
                            children: 'Cancel',
                            variant: 'outlined',
                            onClick: cancelReply,
                            style: { marginLeft: '10px' }
                        })
                    ])
                ]),
                
                React.createElement('div', { key: 'comments-list', className: 'comments-list' }, 
                    comments.filter(comment => comment.parent === 0).map(comment => 
                        React.createElement('div', { 
                            key: comment.id, 
                            className: 'comment-item' 
                        }, [
                            React.createElement('div', { className: 'comment-header' }, [
                                React.createElement('div', { className: 'comment-author' }, [
                                    React.createElement('strong', null, comment.author_name || 'Anonymous'),
                                    React.createElement('span', { className: 'comment-date' }, ` - ${new Date(comment.date).toLocaleDateString()}`)
                                ]),
                                enableReplies && React.createElement('button', {
                                    type: 'button',
                                    onClick: () => handleReply(comment.id),
                                    className: 'reply-btn'
                                }, 'Reply')
                            ]),
                            React.createElement('div', { className: 'comment-content' }, 
                                React.createElement('div', { dangerouslySetInnerHTML: { __html: comment.content.rendered } })
                            ),
                            
                            // Render replies
                            comment._embedded && comment._embedded['replies'] && 
                            React.createElement('div', { className: 'comment-replies' }, 
                                comment._embedded['replies'].map(reply => 
                                    React.createElement('div', { 
                                        key: reply.id, 
                                        className: 'comment-reply' 
                                    }, [
                                        React.createElement('div', { className: 'comment-header' }, [
                                            React.createElement('div', { className: 'comment-author' }, [
                                                React.createElement('strong', null, reply.author_name || 'Anonymous'),
                                                React.createElement('span', { className: 'comment-date' }, ` - ${new Date(reply.date).toLocaleDateString()}`)
                                            ])
                                        ]),
                                        React.createElement('div', { className: 'comment-content' }, 
                                            React.createElement('div', { dangerouslySetInnerHTML: { __html: reply.content.rendered } })
                                        )
                                    ])
                                )
                            )
                        ])
                    )
                )
            ]);
        },

        // News Carousel Component
        NewsCarousel: ({ posts = [], autoPlay = true, interval = 5000, showArrows = true, showIndicators = true }) => {
            const [currentIndex, setCurrentIndex] = React.useState(0);

            React.useEffect(() => {
                if (!autoPlay || posts.length <= 1) return;
                
                const timer = setInterval(() => {
                    setCurrentIndex(prevIndex => (prevIndex + 1) % posts.length);
                }, interval);

                return () => clearInterval(timer);
            }, [autoPlay, interval, posts.length]);

            const goToSlide = (index) => {
                setCurrentIndex(index);
            };

            const nextSlide = () => {
                setCurrentIndex((currentIndex + 1) % posts.length);
            };

            const prevSlide = () => {
                const length = posts.length;
                setCurrentIndex((currentIndex - 1 + length) % length);
            };

            if (posts.length === 0) {
                return React.createElement('div', { className: 'carousel-empty' }, 'No posts available');
            }

            return React.createElement('div', { className: 'news-carousel' }, [
                React.createElement('div', { key: 'carousel-inner', className: 'carousel-inner' }, [
                    posts.map((post, index) => 
                        React.createElement('div', { 
                            key: post.id || index, 
                            className: `carousel-item ${index === currentIndex ? 'active' : ''}` 
                        }, [
                            React.createElement('a', { 
                                href: post.link || '#', 
                                className: 'carousel-link' 
                            }, [
                                React.createElement('img', { 
                                    src: post.featured_media_url || post.jetpack_featured_media_url || '/wp-content/themes/haliyora/images/placeholder.jpg', 
                                    alt: post.title?.rendered || post.title || 'Featured Image',
                                    className: 'carousel-image',
                                    onError: (e) => {
                                        e.target.src = '/wp-content/themes/haliyora/images/placeholder.jpg';
                                    }
                                }),
                                React.createElement('div', { className: 'carousel-content' }, [
                                    React.createElement('h3', { className: 'carousel-title' }, 
                                        post.title?.rendered || post.title || 'Untitled'
                                    ),
                                    React.createElement('p', { className: 'carousel-excerpt' }, 
                                        post.excerpt?.rendered || post.excerpt || 'No excerpt available'
                                    )
                                ])
                            ])
                        ])
                    )
                ]),
                
                showArrows && React.createElement('button', { 
                    key: 'prev-btn',
                    onClick: prevSlide,
                    className: 'carousel-btn carousel-btn-prev'
                }, '‹'),
                
                showArrows && React.createElement('button', { 
                    key: 'next-btn',
                    onClick: nextSlide,
                    className: 'carousel-btn carousel-btn-next'
                }, '›'),
                
                showIndicators && React.createElement('div', { 
                    key: 'indicators',
                    className: 'carousel-indicators'
                }, 
                    posts.map((_, index) => 
                        React.createElement('button', {
                            key: index,
                            onClick: () => goToSlide(index),
                            className: `indicator ${index === currentIndex ? 'active' : ''}`
                        }, '')
                    )
                )
            ]);
        },

        // Search Component
        SearchComponent: ({ placeholder = 'Search...', searchEndpoint = '/wp-json/wp/v2/posts' }) => {
            const [query, setQuery] = React.useState('');
            const [results, setResults] = React.useState([]);
            const [loading, setLoading] = React.useState(false);
            const [showResults, setShowResults] = React.useState(false);

            const handleSearch = async (searchQuery) => {
                if (!searchQuery.trim()) {
                    setResults([]);
                    return;
                }

                setLoading(true);
                try {
                    const response = await fetch(`${searchEndpoint}?search=${encodeURIComponent(searchQuery)}&per_page=10`);
                    const data = await response.json();
                    setResults(data);
                } catch (error) {
                    console.error('Search error:', error);
                    setResults([]);
                } finally {
                    setLoading(false);
                }
            };

            React.useEffect(() => {
                if (query.trim()) {
                    const timeoutId = setTimeout(() => handleSearch(query), 300);
                    return () => clearTimeout(timeoutId);
                } else {
                    setResults([]);
                }
            }, [query]);

            return React.createElement('div', { className: 'react-search-component' }, [
                React.createElement('div', { key: 'search-input-wrap', className: 'search-input-wrapper' }, [
                    React.createElement('input', {
                        type: 'text',
                        value: query,
                        onChange: (e) => {
                            setQuery(e.target.value);
                            setShowResults(true);
                        },
                        onFocus: () => setShowResults(true),
                        placeholder: placeholder,
                        className: 'react-search-input'
                    }),
                    loading && React.createElement('div', { key: 'search-loader', className: 'search-loader' }, '...')
                ]),
                
                showResults && results.length > 0 && React.createElement('div', { 
                    key: 'search-results', 
                    className: 'search-results-dropdown' 
                }, 
                    results.map(post => 
                        React.createElement('a', {
                            key: post.id,
                            href: post.link,
                            className: 'search-result-item'
                        }, [
                            React.createElement('h4', { className: 'search-result-title' }, post.title?.rendered || 'Untitled'),
                            React.createElement('p', { className: 'search-result-excerpt' }, 
                                post.excerpt?.rendered ? 
                                    post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100) + '...' : 
                                    'No excerpt available'
                            )
                        ])
                    )
                ),
                
                showResults && results.length === 0 && !loading && query.trim() && 
                React.createElement('div', { key: 'no-results', className: 'no-search-results' }, 'No results found')
            ]);
        }
    };

    // Universal React Component Renderer
    const renderReactComponents = () => {
        // Find all elements with data-react-component attributes
        const reactElements = document.querySelectorAll('[data-react-component]');
        
        reactElements.forEach(element => {
            const componentName = element.getAttribute('data-react-component');
            const propsString = element.getAttribute('data-props');
            
            try {
                const props = propsString ? JSON.parse(propsString) : {};
                
                let Component;
                switch(componentName) {
                    case 'MaterialCard':
                        Component = HaliyoraReactComponents.MaterialCard;
                        break;
                    case 'MaterialButton':
                        Component = HaliyoraReactComponents.MaterialButton;
                        break;
                    case 'DynamicContentLoader':
                        Component = HaliyoraReactComponents.DynamicContentLoader;
                        break;
                    case 'CommentSystem':
                        Component = HaliyoraReactComponents.CommentSystem;
                        break;
                    case 'NewsCarousel':
                        Component = HaliyoraReactComponents.NewsCarousel;
                        break;
                    case 'SearchComponent':
                        Component = HaliyoraReactComponents.SearchComponent;
                        break;
                    default:
                        console.warn(`Unknown React component: ${componentName}`);
                        return;
                }

                // Create a new root and render the component
                if (element._reactRoot) {
                    // If already rendered, unmount and re-render
                    element._reactRoot.unmount();
                }
                
                const root = ReactDOM.createRoot(element);
                element._reactRoot = root;
                
                root.render(React.createElement(Component, props));
            } catch (error) {
                console.error(`Error rendering ${componentName}:`, error);
                console.error('Props:', propsString);
            }
        });
    };

    // Initialize React components when DOM is ready and React is available
    if (typeof window !== 'undefined') {
        waitForReact(() => {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', renderReactComponents);
            } else {
                renderReactComponents();
            }

            // Watch for dynamic content additions (AJAX, etc.)
            const observer = new MutationObserver(function(mutations) {
                let shouldRerender = false;
                
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(node => {
                            if (node.nodeType === Node.ELEMENT_NODE) {
                                // Check if the added node itself has a React component
                                if (node.hasAttribute && node.hasAttribute('data-react-component')) {
                                    shouldRerender = true;
                                }
                                // Or if it contains elements with React components
                                if (node.querySelectorAll && node.querySelectorAll('[data-react-component]').length > 0) {
                                    shouldRerender = true;
                                }
                            }
                        });
                    }
                });

                if (shouldRerender) {
                    // Small delay to ensure DOM is fully updated
                    setTimeout(renderReactComponents, 100);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Expose components globally for use in PHP templates
            window.HaliyoraReact = HaliyoraReactComponents;
            window.HaliyoraReact.renderAll = renderReactComponents;
        });
    }

    // Handle window resize and other events that might affect React components
    window.addEventListener('resize', () => {
        // Trigger re-render if needed for responsive components
        // Currently not needed but available for future enhancements
    });

})();