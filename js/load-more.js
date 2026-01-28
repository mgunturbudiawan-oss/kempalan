/**
 * Load More Posts Functionality
 */
(function() {
	'use strict';
	
	const loadMoreBtn = document.querySelector('.berita-terbaru-load-more');
	const beritaList = document.querySelector('.berita-terbaru-list');
	
	if ( ! loadMoreBtn || ! beritaList ) {
		return;
	}
	
	let isLoading = false;
	
	loadMoreBtn.addEventListener('click', function() {
		if ( isLoading ) {
			return;
		}
		
		const currentPage = parseInt( beritaList.getAttribute('data-page') ) || 1;
		const maxPages = parseInt( beritaList.getAttribute('data-max-pages') ) || 1;
		const loadedIds = loadMoreBtn.getAttribute('data-loaded-ids') || '';
		const categoryId = beritaList.getAttribute('data-category') || loadMoreBtn.getAttribute('data-category') || '';
		const excludePost = beritaList.getAttribute('data-exclude') || loadMoreBtn.getAttribute('data-exclude') || '';
		
		if ( currentPage >= maxPages ) {
			loadMoreBtn.style.display = 'none';
			return;
		}
		
		isLoading = true;
		loadMoreBtn.disabled = true;
		loadMoreBtn.innerHTML = '<span class="material-icons">hourglass_empty</span> Memuat...';
		
		// AJAX request
		const xhr = new XMLHttpRequest();
		xhr.open('POST', haliyoraAjax.ajaxurl, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		
		xhr.onload = function() {
			if ( xhr.status === 200 ) {
				try {
					const response = JSON.parse( xhr.responseText );
					
					if ( response.success && response.data.html ) {
						// Append new posts
						const tempDiv = document.createElement('div');
						tempDiv.innerHTML = response.data.html;
						
						const newPosts = tempDiv.querySelectorAll('.berita-terbaru-item');
						newPosts.forEach(function(post) {
							beritaList.appendChild(post);
						});
						
						// Update page number
						const nextPage = currentPage + 1;
						beritaList.setAttribute('data-page', nextPage);
						
						// Update loaded IDs
						if ( response.data.loaded_ids ) {
							loadMoreBtn.setAttribute('data-loaded-ids', response.data.loaded_ids);
						}
						
						// Hide button if no more pages
						if ( nextPage >= maxPages ) {
							loadMoreBtn.style.display = 'none';
						} else {
							loadMoreBtn.innerHTML = '<span class="material-icons">expand_more</span> Tampilkan Lebih';
							loadMoreBtn.disabled = false;
						}
					} else {
						loadMoreBtn.innerHTML = '<span class="material-icons">error</span> Gagal memuat';
						setTimeout(function() {
							loadMoreBtn.innerHTML = '<span class="material-icons">expand_more</span> Tampilkan Lebih';
							loadMoreBtn.disabled = false;
						}, 2000);
					}
				} catch (e) {
					console.error('Error parsing response:', e);
					loadMoreBtn.innerHTML = '<span class="material-icons">error</span> Gagal memuat';
					setTimeout(function() {
						loadMoreBtn.innerHTML = '<span class="material-icons">expand_more</span> Tampilkan Lebih';
						loadMoreBtn.disabled = false;
					}, 2000);
				}
			} else {
				loadMoreBtn.innerHTML = '<span class="material-icons">error</span> Gagal memuat';
				setTimeout(function() {
					loadMoreBtn.innerHTML = '<span class="material-icons">expand_more</span> Tampilkan Lebih';
					loadMoreBtn.disabled = false;
				}, 2000);
			}
			
			isLoading = false;
		};
		
		xhr.onerror = function() {
			loadMoreBtn.innerHTML = '<span class="material-icons">error</span> Gagal memuat';
			setTimeout(function() {
				loadMoreBtn.innerHTML = '<span class="material-icons">expand_more</span> Tampilkan Lebih';
				loadMoreBtn.disabled = false;
			}, 2000);
			isLoading = false;
		};
		
		let data = 'action=load_more_berita&page=' + (currentPage + 1) + '&loaded_ids=' + encodeURIComponent(loadedIds) + '&nonce=' + haliyoraAjax.nonce;
		if ( categoryId ) {
			data += '&category=' + encodeURIComponent(categoryId);
		}
		if ( excludePost ) {
			data += '&exclude=' + encodeURIComponent(excludePost);
		}
		xhr.send(data);
	});
	
})();
