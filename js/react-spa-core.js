/**
 * React SPA Core - Main Application
 * Handles routing and state management for home, category, and single pages
 */

(function() {
    'use strict';

    // Wait for React to be available
    function waitForReact(callback) {
        if (typeof window.React !== 'undefined' && typeof window.ReactDOM !== 'undefined') {
            callback();
        } else {
            setTimeout(() => waitForReact(callback), 100);
        }
    }

    waitForReact(() => {
        const { useState, useEffect, createElement: h } = React;

        // ========================================
        // STATE MANAGEMENT
        // ========================================
        const AppState = {
            currentPage: 'home',
            currentPostId: null,
            currentCategory: null,
            posts: [],
            categories: [],
            singlePost: null,
            loading: false,
            error: null
        };

        // ========================================
        // API UTILITIES
        // ========================================
        const API = {
            baseUrl: window.location.origin + '/wp-json/wp/v2',

            async fetchPosts(params = {}) {
                const queryString = new URLSearchParams(params).toString();
                const response = await fetch(`${this.baseUrl}/posts?${queryString}&_embed`);
                return await response.json();
            },

            async fetchPost(id) {
                const response = await fetch(`${this.baseUrl}/posts/${id}?_embed`);
                return await response.json();
            },

            async fetchCategories() {
                const response = await fetch(`${this.baseUrl}/categories`);
                return await response.json();
            },

            async fetchCategoryPosts(categoryId, params = {}) {
                params.categories = categoryId;
                return this.fetchPosts(params);
            }
        };

        // ========================================
        // ROUTER
        // ========================================
        const Router = {
            currentRoute: { page: 'home', params: {} },

            parseUrl() {
                const path = window.location.pathname;
                const urlParams = new URLSearchParams(window.location.search);

                // Check if single post
                if (path.match(/\/\d{4}\/\d{2}\/\d{2}\/[^\/]+\/?$/)) {
                    return { page: 'single', params: { path } };
                }

                // Check if category
                if (path.includes('/category/')) {
                    const categorySlug = path.split('/category/')[1].replace(/\/$/, '');
                    return { page: 'category', params: { slug: categorySlug } };
                }

                // Check if category by query param
                if (urlParams.has('cat')) {
                    return { page: 'category', params: { id: urlParams.get('cat') } };
                }

                // Check if single by query param
                if (urlParams.has('p')) {
                    return { page: 'single', params: { id: urlParams.get('p') } };
                }

                // Default to home
                return { page: 'home', params: {} };
            },

            navigate(route) {
                this.currentRoute = route;
                window.dispatchEvent(new CustomEvent('reactRouteChange', { detail: route }));
            },

            init() {
                this.currentRoute = this.parseUrl();
                
                // Handle browser back/forward
                window.addEventListener('popstate', () => {
                    this.currentRoute = this.parseUrl();
                    window.dispatchEvent(new CustomEvent('reactRouteChange', { detail: this.currentRoute }));
                });
            }
        };

        // ========================================
        // COMPONENTS
        // ========================================

        // Loading Component
        const Loading = () => {
            return h('div', { 
                className: 'react-loading',
                style: { 
                    textAlign: 'center', 
                    padding: '40px',
                    color: '#757575'
                }
            }, [
                h('span', { className: 'material-icons', style: { fontSize: '48px', animation: 'spin 1s linear infinite' } }, 'refresh'),
                h('p', { style: { marginTop: '10px' } }, 'Loading...')
            ]);
        };

        // Error Component
        const ErrorDisplay = ({ error }) => {
            return h('div', {
                className: 'react-error',
                style: {
                    padding: '20px',
                    background: '#ffebee',
                    border: '1px solid #ef5350',
                    borderRadius: '4px',
                    color: '#c62828'
                }
            }, [
                h('h3', {}, 'Error'),
                h('p', {}, error || 'Something went wrong')
            ]);
        };

        // Post Card Component
        const PostCard = ({ post }) => {
            const featuredImage = post._embedded?.['wp:featuredmedia']?.[0]?.source_url;
            const category = post._embedded?.['wp:term']?.[0]?.[0];
            
            return h('article', {
                className: 'berita-terbaru-item',
                'data-post-id': post.id
            }, [
                featuredImage && h('div', { className: 'berita-terbaru-thumbnail' }, [
                    h('a', { href: post.link }, [
                        h('img', {
                            src: featuredImage,
                            alt: post.title.rendered,
                            className: 'berita-terbaru-image',
                            loading: 'lazy'
                        })
                    ])
                ]),
                h('div', { className: 'berita-terbaru-content' }, [
                    category && h('span', { className: 'berita-terbaru-category' }, [
                        h('a', { href: `/category/${category.slug}` }, category.name)
                    ]),
                    h('h3', { className: 'berita-terbaru-title' }, [
                        h('a', { 
                            href: post.link,
                            dangerouslySetInnerHTML: { __html: post.title.rendered }
                        })
                    ]),
                    h('div', { className: 'berita-terbaru-date' }, [
                        h('span', { className: 'material-icons' }, 'schedule'),
                        new Date(post.date).toLocaleDateString('id-ID')
                    ])
                ])
            ]);
        };

        // Home Page Component
        const HomePage = () => {
            const [headlinePosts, setHeadlinePosts] = useState([]);
            const [rekomPosts, setRekomPosts] = useState([]);
            const [posts, setPosts] = useState([]);
            const [loading, setLoading] = useState(true);

            useEffect(() => {
                setLoading(true);
                
                const loadAllData = async () => {
                    try {
                        // Fetch headline posts (5 latest)
                        const headlineData = await API.fetchPosts({ per_page: 5 });
                        setHeadlinePosts(headlineData);
                        
                        // Fetch rekomendasi posts (6 posts)
                        const rekomData = await API.fetchPosts({ per_page: 6, offset: 5 });
                        setRekomPosts(rekomData);
                        
                        // Fetch berita terbaru (10 posts)
                        const postsData = await API.fetchPosts({ per_page: 10, offset: 11 });
                        setPosts(postsData);
                        
                        setLoading(false);
                        
                        // Reinitialize carousels after render
                        setTimeout(() => {
                            if (window.initHeadlineSlider) window.initHeadlineSlider();
                            if (window.initRekomendasiCarousel) window.initRekomendasiCarousel();
                        }, 100);
                    } catch (err) {
                        console.error('Error loading home data:', err);
                        setLoading(false);
                    }
                };

                loadAllData();
            }, []);

            if (loading) return h(Loading);

            return h('div', { className: 'react-home-page' }, [
                // Headline Section
                headlinePosts.length > 0 && h('section', { className: 'headline-section' }, [
                    h('div', { className: 'headline-slider' }, [
                        h('div', { className: 'headline-slides' },
                            headlinePosts.map((post, index) => {
                                const featuredImage = post._embedded?.['wp:featuredmedia']?.[0]?.source_url;
                                const category = post._embedded?.['wp:term']?.[0]?.[0];
                                return h('div', {
                                    key: post.id,
                                    className: `headline-slide ${index === 0 ? 'active' : ''}`,
                                    'data-slide': index + 1
                                }, [
                                    featuredImage && h('div', { className: 'headline-image' }, [
                                        h('img', { 
                                            src: featuredImage, 
                                            className: 'headline-thumbnail',
                                            alt: post.title.rendered 
                                        }),
                                        h('div', { className: 'headline-overlay' })
                                    ]),
                                    h('div', { className: 'headline-content-overlay' }, [
                                        category && h('span', { className: 'headline-category' }, [
                                            h('a', { href: `/category/${category.slug}` }, category.name)
                                        ]),
                                        h('h2', { className: 'headline-title' }, [
                                            h('a', { 
                                                href: post.link,
                                                dangerouslySetInnerHTML: { __html: post.title.rendered }
                                            })
                                        ]),
                                        h('div', { className: 'headline-date' }, [
                                            h('span', { className: 'material-icons' }, 'schedule'),
                                            new Date(post.date).toLocaleDateString('id-ID')
                                        ])
                                    ])
                                ]);
                            })
                        ),
                        h('div', { className: 'headline-nav' }, [
                            h('button', { className: 'headline-nav-prev', 'aria-label': 'Previous' }, [
                                h('span', { className: 'material-icons' }, 'chevron_left')
                            ]),
                            h('button', { className: 'headline-nav-next', 'aria-label': 'Next' }, [
                                h('span', { className: 'material-icons' }, 'chevron_right')
                            ])
                        ]),
                        h('div', { className: 'headline-dots' },
                            headlinePosts.map((_, index) =>
                                h('button', {
                                    key: index,
                                    className: `headline-dot ${index === 0 ? 'active' : ''}`,
                                    'data-slide': index + 1,
                                    'aria-label': `Slide ${index + 1}`
                                })
                            )
                        )
                    ])
                ]),
                
                // Rekomendasi Section
                rekomPosts.length > 0 && h('section', { className: 'rekomendasi-section' }, [
                    h('div', { className: 'rekomendasi-header' }, [
                        h('h2', { className: 'rekomendasi-title' }, [
                            h('span', { className: 'rekomendasi-title-line' }),
                            'Rekomendasi'
                        ]),
                        h('a', { href: '/', className: 'rekomendasi-more' }, [
                            h('span', { className: 'material-icons' }, 'add'),
                            'Lihat lainnya'
                        ])
                    ]),
                    h('div', { className: 'rekomendasi-carousel' }, [
                        h('div', { className: 'rekomendasi-slides' },
                            rekomPosts.map(post => {
                                const featuredImage = post._embedded?.['wp:featuredmedia']?.[0]?.source_url;
                                const category = post._embedded?.['wp:term']?.[0]?.[0];
                                return h('div', { key: post.id, className: 'rekomendasi-item' }, [
                                    featuredImage && h('div', { className: 'rekomendasi-thumbnail' }, [
                                        h('a', { href: post.link }, [
                                            h('img', {
                                                src: featuredImage,
                                                className: 'rekomendasi-image',
                                                alt: post.title.rendered
                                            })
                                        ])
                                    ]),
                                    h('div', { className: 'rekomendasi-content' }, [
                                        category && h('span', { className: 'rekomendasi-category' }, [
                                            h('a', { href: `/category/${category.slug}` }, category.name)
                                        ]),
                                        h('h3', { className: 'rekomendasi-item-title' }, [
                                            h('a', {
                                                href: post.link,
                                                dangerouslySetInnerHTML: { __html: post.title.rendered }
                                            })
                                        ]),
                                        h('div', { className: 'rekomendasi-meta' }, [
                                            h('span', { className: 'rekomendasi-date' }, 
                                                new Date(post.date).toLocaleDateString('id-ID')
                                            )
                                        ])
                                    ])
                                ]);
                            })
                        ),
                        h('button', { className: 'rekomendasi-nav rekomendasi-prev', 'aria-label': 'Previous' }, [
                            h('span', { className: 'material-icons' }, 'chevron_left')
                        ]),
                        h('button', { className: 'rekomendasi-nav rekomendasi-next', 'aria-label': 'Next' }, [
                            h('span', { className: 'material-icons' }, 'chevron_right')
                        ])
                    ])
                ]),
                
                // Berita Terbaru Section
                h('section', { className: 'berita-terbaru-section' }, [
                    h('div', { className: 'berita-terbaru-header' }, [
                        h('h2', { className: 'berita-terbaru-title' }, [
                            h('span', { className: 'berita-terbaru-title-line' }),
                            'Berita Terbaru'
                        ])
                    ]),
                    h('div', { className: 'berita-terbaru-list' },
                        posts.map(post => h(PostCard, { key: post.id, post }))
                    )
                ])
            ]);
        };

        // Category Page Component
        const CategoryPage = ({ slug, id }) => {
            const [posts, setPosts] = useState([]);
            const [category, setCategory] = useState(null);
            const [loading, setLoading] = useState(true);

            useEffect(() => {
                setLoading(true);
                
                const loadCategoryData = async () => {
                    try {
                        // Get category info
                        const categories = await API.fetchCategories();
                        const foundCategory = id 
                            ? categories.find(c => c.id === parseInt(id))
                            : categories.find(c => c.slug === slug);
                        
                        if (foundCategory) {
                            setCategory(foundCategory);
                            const categoryPosts = await API.fetchCategoryPosts(foundCategory.id, { per_page: 10 });
                            setPosts(categoryPosts);
                        }
                        setLoading(false);
                    } catch (err) {
                        console.error('Error loading category:', err);
                        setLoading(false);
                    }
                };

                loadCategoryData();
            }, [slug, id]);

            if (loading) return h(Loading);
            if (!category) return h(ErrorDisplay, { error: 'Category not found' });

            return h('div', { className: 'react-category-page' }, [
                h('header', { className: 'page-header', style: { marginBottom: '30px' } }, [
                    h('h1', { className: 'page-title' }, [
                        'Category: ',
                        h('span', { style: { color: '#d32f2f' } }, category.name)
                    ]),
                    category.description && h('p', { 
                        className: 'category-description',
                        dangerouslySetInnerHTML: { __html: category.description }
                    })
                ]),
                h('section', { className: 'berita-terbaru-section' }, [
                    h('div', { className: 'berita-terbaru-list' },
                        posts.length > 0 
                            ? posts.map(post => h(PostCard, { key: post.id, post }))
                            : h('p', {}, 'No posts found in this category.')
                    )
                ])
            ]);
        };

        // Single Post Component
        const SinglePage = ({ postId, path }) => {
            const [post, setPost] = useState(null);
            const [loading, setLoading] = useState(true);

            useEffect(() => {
                setLoading(true);
                
                const loadPost = async () => {
                    try {
                        let postData;
                        if (postId) {
                            postData = await API.fetchPost(postId);
                        } else {
                            // Get post by path - simplified version
                            const posts = await API.fetchPosts({ per_page: 1 });
                            postData = posts[0]; // Fallback
                        }
                        setPost(postData);
                        setLoading(false);
                    } catch (err) {
                        console.error('Error loading post:', err);
                        setLoading(false);
                    }
                };

                loadPost();
            }, [postId, path]);

            if (loading) return h(Loading);
            if (!post) return h(ErrorDisplay, { error: 'Post not found' });

            const featuredImage = post._embedded?.['wp:featuredmedia']?.[0]?.source_url;
            const category = post._embedded?.['wp:term']?.[0]?.[0];

            return h('article', { className: 'single-post-article react-single-page' }, [
                h('header', { className: 'single-post-header' }, [
                    category && h('span', { 
                        className: 'single-post-category',
                        style: { 
                            display: 'inline-block',
                            background: '#d32f2f',
                            color: 'white',
                            padding: '4px 12px',
                            borderRadius: '4px',
                            fontSize: '12px',
                            marginBottom: '15px'
                        }
                    }, category.name),
                    h('h1', { 
                        className: 'single-post-title',
                        dangerouslySetInnerHTML: { __html: post.title.rendered }
                    }),
                    h('div', { className: 'single-post-meta' }, [
                        h('div', { className: 'single-post-meta-item' }, [
                            h('span', { className: 'material-icons' }, 'schedule'),
                            new Date(post.date).toLocaleDateString('id-ID')
                        ])
                    ])
                ]),
                featuredImage && h('div', { className: 'single-post-featured-image' }, [
                    h('img', { 
                        src: featuredImage,
                        alt: post.title.rendered,
                        className: 'single-post-thumbnail'
                    })
                ]),
                h('div', { 
                    className: 'single-post-content',
                    dangerouslySetInnerHTML: { __html: post.content.rendered }
                })
            ]);
        };

        // Main App Component
        const App = () => {
            const [route, setRoute] = useState(Router.currentRoute);

            useEffect(() => {
                const handleRouteChange = (e) => {
                    setRoute(e.detail);
                };

                window.addEventListener('reactRouteChange', handleRouteChange);
                return () => window.removeEventListener('reactRouteChange', handleRouteChange);
            }, []);

            console.log('React SPA Route:', route);

            switch(route.page) {
                case 'single':
                    return h(SinglePage, { 
                        postId: route.params.id,
                        path: route.params.path
                    });
                case 'category':
                    return h(CategoryPage, { 
                        slug: route.params.slug,
                        id: route.params.id
                    });
                case 'home':
                default:
                    return h(HomePage);
            }
        };

        // ========================================
        // INITIALIZATION
        // ========================================
        function initReactSPA() {
            const container = document.getElementById('react-spa-root');
            
            if (!container) {
                console.warn('React SPA: Root container not found (#react-spa-root)');
                return;
            }

            console.log('🚀 Initializing React SPA...');
            Router.init();

            const root = ReactDOM.createRoot(container);
            root.render(h(App));

            console.log('✓ React SPA initialized');
        }

        // Run when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initReactSPA);
        } else {
            initReactSPA();
        }

        // Expose for debugging
        window.HaliyoraReactSPA = {
            Router,
            API,
            initReactSPA
        };
    });

})();
