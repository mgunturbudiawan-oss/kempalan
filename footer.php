<?php
/**
 * The template for displaying the footer
 *
 * @package haliyora
 */
?>

<footer id="colophon" class="site-footer">
	<div class="shadcn-container">
		<div class="footer-content">
			<div class="footer-left">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<h3 class="footer-site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h3>
					<?php
				}
				?>
				<div class="footer-info">
					<?php
					$footer_info = get_theme_mod( 'haliyora_footer_info', '' );
					if ( $footer_info ) {
						echo '<p>' . wp_kses_post( $footer_info ) . '</p>';
					} else {
						?>
						<p><?php bloginfo( 'description' ); ?></p>
						<?php
					}
					?>
				</div>
			</div>
			
			<div class="footer-right">
				<div class="social-media">
					<h4 class="social-title">Ikuti Kami</h4>
					<div class="social-links">
						<?php
						$facebook = get_theme_mod( 'haliyora_facebook_url', '' );
						$twitter = get_theme_mod( 'haliyora_twitter_url', '' );
						$instagram = get_theme_mod( 'haliyora_instagram_url', '' );
						$youtube = get_theme_mod( 'haliyora_youtube_url', '' );
						
						if ( $facebook ) {
							echo '<a href="' . esc_url( $facebook ) . '" target="_blank" rel="noopener" class="social-link facebook"><i class="fab fa-facebook-f"></i></a>';
						}
						if ( $twitter ) {
							echo '<a href="' . esc_url( $twitter ) . '" target="_blank" rel="noopener" class="social-link twitter"><i class="fab fa-twitter"></i></a>';
						}
						if ( $instagram ) {
							echo '<a href="' . esc_url( $instagram ) . '" target="_blank" rel="noopener" class="social-link instagram"><i class="fab fa-instagram"></i></a>';
						}
						if ( $youtube ) {
							echo '<a href="' . esc_url( $youtube ) . '" target="_blank" rel="noopener" class="social-link youtube"><i class="fab fa-youtube"></i></a>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Footer Menu -->
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<div class="footer-menu-wrapper">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'menu_class'     => 'footer-menu',
				'container'      => 'nav',
				'container_class' => 'footer-navigation',
				'depth'          => 1,
			) );
			?>
		</div>
		<?php endif; ?>
		
		<div class="footer-bottom">
			<p class="copyright">
				&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
			</p>
		</div>
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<!-- Mobile Bottom Navigation -->
<nav class="mobile-bottom-nav">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-item <?php echo is_home() ? 'active' : ''; ?>">
		<span class="material-icons">home</span>
		<span class="mobile-nav-label">Utama</span>
	</a>
	<a href="<?php echo esc_url( home_url( '/trending/' ) ); ?>" class="mobile-nav-item <?php echo is_page('trending') ? 'active' : ''; ?>">
		<span class="material-icons">trending_up</span>
		<span class="mobile-nav-label">Trending</span>
	</a>
	<button class="mobile-nav-item mobile-nav-add" aria-label="Add" id="regionPopupBtn">
		<span class="material-icons">add</span>
	</button>
	<a href="#" class="mobile-nav-item">
		<span class="material-icons">bookmark_border</span>
		<span class="mobile-nav-label">Simpan</span>
	</a>
	<a href="#" class="mobile-nav-item">
		<span class="material-icons">person</span>
		<span class="mobile-nav-label">Profil</span>
	</a>
</nav>

<!-- Analisis Popup -->
<div id="regionPopup" class="region-popup">
	<div class="region-popup-overlay"></div>
	<div class="region-popup-content">
		<div class="region-popup-header">
			<h3>Analisis</h3>
			<button class="region-popup-close" id="closeRegionPopup">
				<span class="material-icons">close</span>
			</button>
		</div>
		
		<div class="region-search">
			<input type="text" id="regionSearch" placeholder="Cari..." class="region-search-input">
			<span class="material-icons region-search-icon">search</span>
		</div>
		
		<div class="region-grid">
			<a href="<?php echo esc_url( home_url( '/?s=Analisis' ) ); ?>" class="region-item" data-region="analisis">
				<div class="region-icon" style="background: linear-gradient(135deg, #FF6B6B, #EE5A6F);">
					<i class="fas fa-chart-line"></i>
				</div>
				<span class="region-name">Analisis</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Sports' ) ); ?>" class="region-item" data-region="sports">
				<div class="region-icon" style="background: linear-gradient(135deg, #4ECDC4, #44A08D);">
					<i class="fas fa-running"></i>
				</div>
				<span class="region-name">Sports</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Opini' ) ); ?>" class="region-item" data-region="opini">
				<div class="region-icon" style="background: linear-gradient(135deg, #F7B731, #F79F1F);">
					<i class="fas fa-pen-nib"></i>
				</div>
				<span class="region-name">Opini</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Kolomnis' ) ); ?>" class="region-item" data-region="kolomnis">
				<div class="region-icon" style="background: linear-gradient(135deg, #5F27CD, #341F97);">
					<i class="fas fa-user-edit"></i>
				</div>
				<span class="region-name">Kolomnis</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Peta+Politik' ) ); ?>" class="region-item" data-region="peta politik">
				<div class="region-icon" style="background: linear-gradient(135deg, #00D2FF, #3A7BD5);">
					<i class="fas fa-map-marked-alt"></i>
				</div>
				<span class="region-name">Peta Politik</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Jatim' ) ); ?>" class="region-item" data-region="jatim">
				<div class="region-icon" style="background: linear-gradient(135deg, #FA8BFF, #2BD2FF);">
					<i class="fas fa-map-marker-alt"></i>
				</div>
				<span class="region-name">Jatim</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Jateng' ) ); ?>" class="region-item" data-region="jateng">
				<div class="region-icon" style="background: linear-gradient(135deg, #FD79A8, #E84393);">
					<i class="fas fa-map-marker-alt"></i>
				</div>
				<span class="region-name">Jateng</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Jabar' ) ); ?>" class="region-item" data-region="jabar">
				<div class="region-icon" style="background: linear-gradient(135deg, #A29BFE, #6C5CE7);">
					<i class="fas fa-map-marker-alt"></i>
				</div>
				<span class="region-name">Jabar</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Jakarta' ) ); ?>" class="region-item" data-region="jakarta">
				<div class="region-icon" style="background: linear-gradient(135deg, #FF7979, #F53B57);">
					<i class="fas fa-city"></i>
				</div>
				<span class="region-name">Jakarta</span>
			</a>
			
			<a href="<?php echo esc_url( home_url( '/?s=Bali' ) ); ?>" class="region-item" data-region="bali">
				<div class="region-icon" style="background: linear-gradient(135deg, #FDCB6E, #FFA502);">
					<i class="fas fa-umbrella-beach"></i>
				</div>
				<span class="region-name">Bali</span>
			</a>
		</div>
	</div>
</div>

<!-- Auth Popup (Login/Register) -->
<div id="authPopup" class="auth-popup">
	<div class="auth-popup-overlay"></div>
	<div class="auth-popup-content">
		<button class="auth-popup-close" id="closeAuthPopup">
			<span class="material-icons">close</span>
		</button>
		
		<div class="auth-tabs">
			<button class="auth-tab active" data-tab="login">Masuk</button>
			<button class="auth-tab" data-tab="register">Daftar</button>
		</div>
		
		<div class="auth-form-container active" id="loginForm">
			<h3>Selamat Datang Kembali</h3>
			<p>Masuk untuk bergabung dalam diskusi</p>
			<?php wp_login_form( array( 
				'redirect' => is_single() ? get_permalink() : home_url(),
				'label_log_in' => 'Masuk Sekarang',
				'id_submit' => 'auth-login-submit',
			) ); ?>
			<p class="auth-footer">Lupa kata sandi? <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Reset di sini</a></p>
		</div>
		
		<div class="auth-form-container" id="registerForm">
			<h3>Buat Akun Baru</h3>
			<p>Daftar sekarang dan mulai berdiskusi</p>
			<form action="<?php echo esc_url( wp_registration_url() ); ?>" method="post">
				<div class="auth-field">
					<label for="user_login">Username</label>
					<input type="text" name="user_login" id="user_reg_login" class="shadcn-input">
				</div>
				<div class="auth-field">
					<label for="user_email">Email</label>
					<input type="email" name="user_email" id="user_reg_email" class="shadcn-input">
				</div>
				<p class="reg-pass-note">Kata sandi akan dikirim ke email Anda.</p>
				<button type="submit" class="shadcn-btn shadcn-btn-primary full-width">Daftar Sekarang</button>
			</form>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

<script>
/**
 * Global Auth Popup Controller
 */
window.openAuthPopup = function(tab = 'login') {
    const authPopup = document.getElementById('authPopup');
    if (!authPopup) return;
    
    authPopup.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Switch to requested tab
    const tabs = authPopup.querySelectorAll('.auth-tab');
    const forms = authPopup.querySelectorAll('.auth-form-container');
    
    tabs.forEach(t => {
        if (t.getAttribute('data-tab') === tab) {
            t.classList.add('active');
        } else {
            t.classList.remove('active');
        }
    });
    
    forms.forEach(f => {
        if (f.id === tab + 'Form') {
            f.classList.add('active');
        } else {
            f.classList.remove('active');
        }
    });
};

(function() {
	'use strict';
	
	const authPopup = document.getElementById('authPopup');
	const closeBtn = document.getElementById('closeAuthPopup');
	const overlay = document.querySelector('.auth-popup-overlay');
	const tabs = document.querySelectorAll('.auth-tab');
	
	if (!authPopup) return;
	
	function closePopup() {
		authPopup.classList.remove('active');
		document.body.style.overflow = '';
	}
	
	if (closeBtn) closeBtn.addEventListener('click', closePopup);
	if (overlay) overlay.addEventListener('click', closePopup);
	
	if (tabs) {
		tabs.forEach(tab => {
			tab.addEventListener('click', function() {
				const target = this.getAttribute('data-tab');
				window.openAuthPopup(target);
			});
		});
	}
})();
</script>

<script>
// Region Popup
(function() {
	'use strict';
	
	const popupBtn = document.getElementById('regionPopupBtn');
	const popup = document.getElementById('regionPopup');
	const closeBtn = document.getElementById('closeRegionPopup');
	const overlay = document.querySelector('.region-popup-overlay');
	const searchInput = document.getElementById('regionSearch');
	const regionItems = document.querySelectorAll('.region-item');
	
	if (!popupBtn || !popup) return;
	
	// Open popup
	popupBtn.addEventListener('click', function() {
		popup.classList.add('active');
		document.body.style.overflow = 'hidden';
	});
	
	// Close popup
	function closePopup() {
		popup.classList.remove('active');
		document.body.style.overflow = '';
		searchInput.value = '';
		regionItems.forEach(item => item.style.display = 'flex');
	}
	
	if (closeBtn) {
		closeBtn.addEventListener('click', closePopup);
	}
	
	if (overlay) {
		overlay.addEventListener('click', closePopup);
	}
	
	// Search functionality
	if (searchInput) {
		searchInput.addEventListener('input', function() {
			const searchTerm = this.value.toLowerCase();
			
			regionItems.forEach(item => {
				const regionName = item.getAttribute('data-region');
				if (regionName.includes(searchTerm)) {
					item.style.display = 'flex';
				} else {
					item.style.display = 'none';
				}
			});
		});
	}
})();
</script>

<script>
// Mobile Menu Toggle - Inline backup
(function() {
	function initMobileMenu() {
		const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
		const mobileMenuSlide = document.querySelector('.mobile-menu-slide');
		const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
		const body = document.body;

		if (!mobileMenuToggle || !mobileMenuSlide) {
			return;
		}

		mobileMenuToggle.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			const isActive = mobileMenuSlide.classList.contains('active');
			
			if (isActive) {
				mobileMenuSlide.classList.remove('active');
				mobileMenuToggle.classList.remove('active');
				mobileMenuToggle.setAttribute('aria-expanded', 'false');
				body.style.overflow = '';
			} else {
				mobileMenuSlide.classList.add('active');
				mobileMenuToggle.classList.add('active');
				mobileMenuToggle.setAttribute('aria-expanded', 'true');
				body.style.overflow = 'hidden';
			}
		});

		if (mobileMenuOverlay) {
			mobileMenuOverlay.addEventListener('click', function() {
				mobileMenuSlide.classList.remove('active');
				mobileMenuToggle.classList.remove('active');
				mobileMenuToggle.setAttribute('aria-expanded', 'false');
				body.style.overflow = '';
			});
		}

		const menuItems = mobileMenuSlide.querySelectorAll('.mobile-category-menu-item');
		menuItems.forEach(function(item) {
			item.addEventListener('click', function() {
				setTimeout(function() {
					mobileMenuSlide.classList.remove('active');
					mobileMenuToggle.classList.remove('active');
					mobileMenuToggle.setAttribute('aria-expanded', 'false');
					body.style.overflow = '';
				}, 300);
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMobileMenu);
	} else {
		initMobileMenu();
	}
})();
</script>

</body>
</html>
