<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package haliyora
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area modern-comments shadcn-card chat-model-comments">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<div class="comments-header">
			<h2 class="comments-title">
				<span class="material-icons">chat</span>
				<?php
				$haliyora_comment_count = get_comments_number();
				printf( 
					/* translators: 1: comment count number. */
					esc_html__( '%1$s Chat', 'haliyora' ),
					number_format_i18n( $haliyora_comment_count )
				);
				?>
			</h2>
		</div>

		<div class="chat-container">
			<ol class="comment-list chat-list">
				<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
						'callback'   => 'haliyora_chat_comment_callback',
					)
				);
				?>
			</ol><!-- .comment-list -->
		</div>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Diskusi ditutup.', 'haliyora' ); ?></p>
			<?php
		endif;

	else :
		// No comments yet
		?>
		<div class="no-comments-yet">
			<div class="no-comments-icon">
				<span class="material-icons">forum</span>
			</div>
			<h3 class="no-comments-title">Belum ada obrolan</h3>
			<p class="no-comments-text">Mulai obrolan pertama kamu di sini!</p>
		</div>
		<?php
	endif; // Check for have_comments().

	// Chat Input Area
	if ( comments_open() ) :
		if ( is_user_logged_in() ) :
			// Custom comment form for logged in users
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$comment_form_args = array(
				'title_reply'          => '',
				'title_reply_to'       => 'Balas ke %s',
				'cancel_reply_link'    => 'Batal',
				'label_submit'         => 'Kirim',
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'logged_in_as'         => '', // Menghilangkan pesan "Logged in as..." di atas form
				'comment_field'        => '<div class="chat-input-wrapper"><textarea id="comment" name="comment" class="chat-input-field" placeholder="Tulis pesan..." aria-required="true"></textarea></div>',
				'submit_button'        => '<button name="submit" type="submit" id="submit" class="chat-send-btn"><span class="material-icons">send</span></button>',
				'submit_field'         => '<div class="chat-submit-field">%1$s %2$s</div>',
				'class_form'           => 'chat-form',
			);

			comment_form( $comment_form_args );

			// Menampilkan link Logout di bawah kolom chat agar lebih rapi
			$current_user = wp_get_current_user();
			?>
			<div class="chat-user-meta-footer">
				<span>Masuk sebagai <strong><?php echo esc_html( $current_user->display_name ); ?></strong>.</span>
				<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" title="Log out dari akun ini">Logout?</a>
			</div>
			<?php
		else :
			// Placeholder for non-logged in users that triggers popup
			?>
			<div class="chat-login-prompt" onclick="window.openAuthPopup('login')" role="button" tabindex="0" aria-label="Login atau Daftar untuk komentar" style="cursor: pointer;">
				<div class="chat-input-placeholder">
					<span>Tulis komentar...</span>
					<span class="material-icons">send</span>
				</div>
				<div class="chat-overlay-prompt">
					<p>Silakan <strong onclick="event.stopPropagation(); window.openAuthPopup('login');" style="cursor: pointer; color: #dc2626; text-decoration: underline;">Login</strong> atau <strong onclick="event.stopPropagation(); window.openAuthPopup('register');" style="cursor: pointer; color: #dc2626; text-decoration: underline;">Daftar</strong> untuk ikut berdiskusi</p>
				</div>
			</div>
			<?php
		endif;
	endif;
	?>

</div><!-- #comments -->

<script>
(function() {
	'use strict';
	
	// Scroll chat to bottom
	const chatContainer = document.querySelector('.chat-container');
	if (chatContainer) {
		chatContainer.scrollTop = chatContainer.scrollHeight;
	}
})();
</script>
