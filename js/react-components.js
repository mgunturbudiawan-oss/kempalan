// Enhanced React Components for Haliyora Theme
// Using Babel standalone for JSX transformation

(function() {
	'use strict';
	
	// Wait for React and ReactDOM to load
	if (typeof React === 'undefined' || typeof ReactDOM === 'undefined') {
		console.warn('React or ReactDOM not loaded');
		return;
	}
	
	// Material Design Card Component
	const MaterialCard = ({ title, children, className = '' }) => {
		return React.createElement('div', {
			className: `material-card ${className}`,
			style: {
				backgroundColor: '#fff',
				borderRadius: '4px',
				boxShadow: '0 2px 4px rgba(0,0,0,0.1)',
				padding: '20px',
				marginBottom: '20px'
			}
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
	};
	
	// Material Button Component
	const MaterialButton = ({ children, onClick, variant = 'contained', className = '' }) => {
		const styles = {
			contained: {
				backgroundColor: '#1976d2',
				color: '#fff',
				border: 'none',
				padding: '10px 20px',
				borderRadius: '4px',
				cursor: 'pointer',
				fontSize: '14px',
				fontWeight: '500',
				transition: 'background-color 0.3s'
			},
			outlined: {
				backgroundColor: 'transparent',
				color: '#1976d2',
				border: '1px solid #1976d2',
				padding: '10px 20px',
				borderRadius: '4px',
				cursor: 'pointer',
				fontSize: '14px',
				fontWeight: '500',
				transition: 'all 0.3s'
			}
		};
		
		return React.createElement('button', {
			className: `material-button ${className}`,
			style: styles[variant],
			onClick: onClick,
			onMouseEnter: (e) => {
				if (variant === 'contained') {
					e.target.style.backgroundColor = '#1565c0';
				} else {
					e.target.style.backgroundColor = '#e3f2fd';
				}
			},
			onMouseLeave: (e) => {
				if (variant === 'contained') {
					e.target.style.backgroundColor = '#1976d2';
				} else {
					e.target.style.backgroundColor = 'transparent';
				}
			}
		}, children);
	};
	
	// Dynamic Content Loader Component
	const DynamicContentLoader = ({ endpoint, renderFunction }) => {
		const [data, setData] = React.useState([]);
		const [loading, setLoading] = React.useState(true);
		const [error, setError] = React.useState(null);
	
		React.useEffect(() => {
			const fetchData = async () => {
				try {
					const response = await fetch(endpoint);
					const result = await response.json();
					setData(result);
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
			return React.createElement('div', { className: 'dynamic-loader' }, 'Loading...');
		}
	
		if (error) {
			return React.createElement('div', { className: 'dynamic-error' }, `Error: ${error}`);
		}

		return renderFunction ? renderFunction(data) : React.createElement('div', null, 'No render function provided');
	};
	
	// Comment System Component
	const CommentSystem = ({ postId, currentUser = null }) => {
		const [comments, setComments] = React.useState([]);
		const [newComment, setNewComment] = React.useState('');
		const [loading, setLoading] = React.useState(true);
	
		React.useEffect(() => {
			// Load comments for the post
			fetch(`/wp-json/wp/v2/comments?post=${postId}&per_page=10`)
				.then(response => response.json())
				.then(data => {
					setComments(data);
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
				author_name: currentUser?.name || 'Anonymous',
				author_email: currentUser?.email || 'anonymous@example.com'
			};

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
					setComments([newCommentData, ...comments]);
					setNewComment('');
				}
			} catch (error) {
				console.error('Error submitting comment:', error);
			}
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
				React.createElement('textarea', {
					key: 'comment-textarea',
					value: newComment,
					onChange: (e) => setNewComment(e.target.value),
					placeholder: 'Write a comment...',
					rows: 3,
					required: true,
					className: 'comment-input'
				}),
				React.createElement(MaterialButton, {
					key: 'comment-submit-btn',
					children: 'Post Comment',
					variant: 'contained',
					onClick: handleSubmit
				})
			]),
			React.createElement('div', { key: 'comments-list', className: 'comments-list' }, 
				comments.map(comment => 
					React.createElement('div', { 
						key: comment.id, 
						className: 'comment-item' 
					}, [
						React.createElement('div', { className: 'comment-author' }, [
							React.createElement('strong', null, comment.author_name),
							React.createElement('span', { className: 'comment-date' }, ` - ${new Date(comment.date).toLocaleDateString()}`)
						]),
						React.createElement('div', { className: 'comment-content' }, comment.content.rendered)
					])
				)
			)
		]);
	};
	
	// News Carousel Component
	const NewsCarousel = ({ posts = [], autoPlay = true, interval = 5000 }) => {
		const [currentIndex, setCurrentIndex] = React.useState(0);
	
		React.useEffect(() => {
			if (!autoPlay) return;
			
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
						key: post.id, 
						className: `carousel-item ${index === currentIndex ? 'active' : ''}` 
					}, [
						React.createElement('a', { 
							href: post.link, 
							className: 'carousel-link' 
					}, [
							React.createElement('img', { 
								src: post.featured_media_url || '/wp-content/themes/haliyora/images/placeholder.jpg', 
								alt: post.title.rendered,
								className: 'carousel-image'
						}),
							React.createElement('div', { className: 'carousel-content' }, [
								React.createElement('h3', { className: 'carousel-title' }, post.title.rendered),
								React.createElement('p', { className: 'carousel-excerpt' }, post.excerpt.rendered)
							])
						])
					])
				)
			]),
			React.createElement('button', { 
				key: 'prev-btn',
				onClick: prevSlide,
				className: 'carousel-btn carousel-btn-prev'
			}, '‹'),
			React.createElement('button', { 
				key: 'next-btn',
				onClick: nextSlide,
				className: 'carousel-btn carousel-btn-next'
			}, '›'),
			React.createElement('div', { 
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
	};
	
	// Universal React Renderer - renders components on any element with data-react-component
	const renderReactComponents = () => {
		// Find all elements with data-react-component attributes
		const reactElements = document.querySelectorAll('[data-react-component]');
		
		reactElements.forEach(element => {
			const componentName = element.getAttribute('data-react-component');
			const propsString = element.getAttribute('data-props');
			const props = propsString ? JSON.parse(propsString) : {};
	
			let Component;
			switch(componentName) {
				case 'MaterialCard':
					Component = MaterialCard;
					break;
				case 'MaterialButton':
					Component = MaterialButton;
					break;
				case 'DynamicContentLoader':
					Component = DynamicContentLoader;
					break;
				case 'CommentSystem':
					Component = CommentSystem;
					break;
				case 'NewsCarousel':
					Component = NewsCarousel;
					break;
				default:
					console.warn(`Unknown React component: ${componentName}`);
					return;
			}
	
			try {
				const root = ReactDOM.createRoot(element);
				root.render(React.createElement(Component, props));
			} catch (error) {
				console.error(`Error rendering ${componentName}:`, error);
			}
		});
	};
	
	// Initialize React components when DOM is ready
	document.addEventListener('DOMContentLoaded', function() {
		renderReactComponents();
	});
	
	// Also run after any AJAX content is loaded (for dynamic content)
	document.addEventListener('DOMContentLoaded', function() {
		// Listen for custom events when content is dynamically added
		document.addEventListener('contentUpdated', renderReactComponents);
		
		// Watch for changes to the DOM
		const observer = new MutationObserver(function(mutations) {
			mutations.forEach(function(mutation) {
				if (mutation.type === 'childList') {
					// Check if any new elements contain React component attributes
					mutation.addedNodes.forEach(node => {
						if (node.nodeType === Node.ELEMENT_NODE) {
							const hasReactElement = node.querySelector && node.querySelector('[data-react-component]');
							if (hasReactElement) {
								renderReactComponents();
							}
						}
					});
				}
			});
		});
	
		observer.observe(document.body, {
			childList: true,
			subtree: true
		});
	});
	
	// Export for use in other scripts
	window.HaliyoraReact = {
		MaterialCard,
		MaterialButton,
		DynamicContentLoader,
		CommentSystem,
		NewsCarousel,
		renderReactComponents
	};
	
})();
