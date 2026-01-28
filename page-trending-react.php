<?php
/**
 * Template Name: Trending Page with React
 * Template Post Type: page
 *
 * @package haliyora
 */

get_header();

// Prepare trending posts data for React component
$trending_posts = new WP_Query( array(
    'posts_per_page' => 7,
    'orderby'        => 'comment_count',
    'order'          => 'DESC',
    'post_status'    => 'publish'
) );

$react_trending_data = array();
if ( $trending_posts->have_posts() ) {
    while ( $trending_posts->have_posts() ) {
        $trending_posts->the_post();
        $categories = get_the_category();
        $views = get_comments_number();
        
        // Random sentiment for demo
        $sentiments = array('positive', 'neutral', 'negative');
        $sentiment = $sentiments[array_rand($sentiments)];
        
        $react_trending_data[] = array(
            'id' => get_the_ID(),
            'title' => array('rendered' => get_the_title()),
            'excerpt' => array('rendered' => wp_trim_words(get_the_excerpt(), 20, '...')),
            'link' => get_permalink(),
            'comment_count' => $views,
            'featured_media_url' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            'sentiment' => $sentiment,
            'categories' => !empty($categories) ? array(array('name' => $categories[0]->name, 'link' => get_category_link($categories[0]->term_id))) : array(),
            'date' => haliyora_format_date($post->ID),
            'views' => number_format($views * 1000) . ' views'
        );
    }
    wp_reset_postdata();
}
?>

<div class="trending-page-wrapper">
	<div class="container-1100">
		<div class="trending-page-header">
			<h1 class="trending-page-title">
				<span class="material-icons">trending_up</span>
				Berita Trending
			</h1>
			<p class="trending-page-subtitle">7 Berita Paling Populer Saat Ini</p>
		</div>

		<!-- React-powered trending list -->
		<div class="trending-list">
			<?php echo haliyora_react_component('NewsCarousel', array(
				'posts' => $react_trending_data,
				'autoPlay' => false,
				'showArrows' => true,
				'showIndicators' => false
			), array('style' => 'margin-bottom: 30px;')); ?>
			
			<!-- Alternative React component for trending list -->
			<div id="trending-react-container"></div>
		</div>

		<!-- Media Monitoring Section with React -->
		<div class="media-monitoring-section">
			<div class="media-monitoring-header">
				<h2 class="media-monitoring-title">
					<span class="material-icons">monitoring</span>
					Media Monitoring
				</h2>
				<p class="media-monitoring-subtitle">Analisis frekuensi pemberitaan terhadap institusi publik</p>
			</div>
			
			<div class="media-monitoring-charts">
				<div class="chart-container">
					<h3 class="chart-title">Frekuensi Pemberitaan</h3>
					<div id="monitoring-charts-react-container"></div>
				</div>
			</div>
		</div>
		
		<!-- Performance Tracking Section with React -->
		<div class="performance-tracking-section">
			<div class="performance-tracking-header">
				<h2 class="performance-tracking-title">
					<span class="material-icons">assessment</span>
					Grafik Kinerja 10 Pemerintahan Kabupaten/Kota Maluku Utara
				</h2>
				<p class="performance-tracking-subtitle">Analisis sentimen pemberitaan terhadap pemerintahan daerah</p>
			</div>
			
			<div class="performance-charts">
				<div class="chart-container">
					<h3 class="chart-title">Sentimen Pemberitaan (Positif/Negatif)</h3>
					<div id="performance-charts-react-container"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Render React components after DOM is loaded
    if (window.HaliyoraReact && window.ReactDOM) {
        // Render trending list as a custom component
        var trendingContainer = document.getElementById('trending-react-container');
        if (trendingContainer) {
            var root = window.ReactDOM.createRoot(trendingContainer);
            
            // Create a custom component for trending posts
            const TrendingListComponent = ({ posts }) => {
                return React.createElement('div', { className: 'trending-posts-react' }, 
                    posts.map((post, index) => 
                        React.createElement('article', { 
                            key: post.id, 
                            className: 'trending-item-react' 
                        }, [
                            React.createElement('div', { className: 'trending-rank-react' }, [
                                React.createElement('span', { className: 'rank-number-react' }, index + 1)
                            ]),
                            React.createElement('div', { className: 'trending-thumbnail-react' }, [
                                React.createElement('a', { href: post.link }, [
                                    React.createElement('img', { 
                                        src: post.featured_media_url || '/wp-content/themes/haliyora/images/placeholder.jpg', 
                                        alt: post.title.rendered,
                                        className: 'trending-image-react',
                                        onError: (e) => {
                                            e.target.src = '/wp-content/themes/haliyora/images/placeholder.jpg';
                                        }
                                    })
                                ])
                            ]),
                            React.createElement('div', { className: 'trending-content-react' }, [
                                post.categories && post.categories.length > 0 && React.createElement('div', { className: 'trending-category-react' }, [
                                    React.createElement('a', { href: post.categories[0].link }, post.categories[0].name)
                                ]),
                                React.createElement('h2', { className: 'trending-title-react' }, [
                                    React.createElement('a', { href: post.link }, post.title.rendered)
                                ]),
                                React.createElement('div', { className: 'trending-excerpt-react' }, 
                                    React.createElement('div', { dangerouslySetInnerHTML: { __html: post.excerpt.rendered } })
                                ),
                                React.createElement('div', { className: 'trending-meta-react' }, [
                                    React.createElement('div', { className: 'trending-views-react' }, [
                                        React.createElement('i', { className: 'fas fa-eye' }),
                                        React.createElement('span', null, post.views)
                                    ]),
                                    React.createElement('div', { className: `trending-sentiment-react sentiment-${post.sentiment}-react` }, [
                                        React.createElement('i', { className: 'fas fa-chart-line' }),
                                        React.createElement('span', null, post.sentiment.charAt(0).toUpperCase() + post.sentiment.slice(1))
                                    ]),
                                    React.createElement('div', { className: 'trending-date-react' }, [
                                        React.createElement('i', { className: 'far fa-clock' }),
                                        React.createElement('span', null, post.date)
                                    ])
                                ])
                            ])
                        ])
                    )
                );
            };
            
            root.render(React.createElement(TrendingListComponent, { posts: <?php echo json_encode($react_trending_data); ?> }));
        }
        
        // Render monitoring charts with React
        var monitoringContainer = document.getElementById('monitoring-charts-react-container');
        if (monitoringContainer) {
            var monitoringRoot = window.ReactDOM.createRoot(monitoringContainer);
            
            const MonitoringChartsComponent = () => {
                // Simulated data
                const monitoringData = [
                    { institution: 'Polisi', count: Math.floor(Math.random() * 30) + 45 },
                    { institution: 'TNI', count: Math.floor(Math.random() * 25) + 30 },
                    { institution: 'Pemerintah', count: Math.floor(Math.random() * 30) + 60 },
                    { institution: 'Kasus', count: Math.floor(Math.random() * 30) + 50 },
                    { institution: 'Korupsi', count: Math.floor(Math.random() * 30) + 40 }
                ];
                
                return React.createElement('div', { className: 'chart-bars-react' },
                    monitoringData.map(item => 
                        React.createElement('div', { key: item.institution, className: 'chart-bar-react' }, [
                            React.createElement('div', { className: 'bar-label-react' }, [
                                React.createElement('span', { className: 'institution-name-react' }, item.institution),
                                React.createElement('span', { className: 'count-value-react' }, `${item.count} kali`)
                            ]),
                            React.createElement('div', { className: 'bar-container-react' }, [
                                React.createElement('div', { 
                                    className: 'bar-fill-react', 
                                    style: { width: `${Math.min(100, item.count)}%` } 
                                })
                            ])
                        ])
                    )
                );
            };
            
            monitoringRoot.render(React.createElement(MonitoringChartsComponent));
        }
        
        // Render performance charts with React
        var performanceContainer = document.getElementById('performance-charts-react-container');
        if (performanceContainer) {
            var performanceRoot = window.ReactDOM.createRoot(performanceContainer);
            
            const PerformanceChartsComponent = () => {
                const regions = [
                    'Halmahera Barat', 'Halmahera Tengah', 'Halmahera Selatan',
                    'Halmahera Utara', 'Halmahera Timur', 'Kepulauan Sula',
                    'Pulau Morotai', 'Pulau Taliabu', 'Kota Ternate', 'Kota Tidore Kepulauan'
                ];
                
                return React.createElement('div', { className: 'performance-bars-react' },
                    regions.map(region => {
                        const positive = Math.floor(Math.random() * 60) + 30; // 30-90
                        const negative = 100 - positive;
                        const dominantColor = positive > negative ? '#4CAF50' : (negative > positive ? '#F44336' : '#9E9E9E');
                        
                        return React.createElement('div', { key: region, className: 'performance-bar-react' }, [
                            React.createElement('div', { className: 'region-label-react' }, [
                                React.createElement('span', { className: 'region-name-react' }, region)
                            ]),
                            React.createElement('div', { className: 'performance-bar-container-react' }, [
                                React.createElement('div', { 
                                    className: 'performance-positive-react', 
                                    style: { width: `${positive}%`, backgroundColor: '#4CAF50' }
                                }),
                                React.createElement('div', { 
                                    className: 'performance-negative-react', 
                                    style: { width: `${negative}%`, backgroundColor: '#F44336' }
                                })
                            ]),
                            React.createElement('div', { className: 'performance-stats-react' }, [
                                React.createElement('span', { className: 'positive-stat-react' }, `${positive}%`),
                                React.createElement('span', { className: 'negative-stat-react' }, `${negative}%`)
                            ])
                        ]);
                    })
                );
            };
            
            performanceRoot.render(React.createElement(PerformanceChartsComponent));
        }
    }
});
</script>

<?php
get_footer();