<?php
/**
 * The template for displaying Comments.
 *
 * @package Meola
 * @since Meola 1.0
 */
?>

	<div id="comments">
		<?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'meola' ); ?></div>
	</div><!-- end #comments -->
	
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php
				printf( _n( '1 comment', '%1$s comments', get_comments_number(), 'meola' ),
					number_format_i18n( get_comments_number() ) );
			?>
			<span><a href="#reply-title"><?php _e( 'Write a comment', 'meola' ); ?></a></span>
		</h3>

		<ol class="commentlist">
				<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use meola_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define meola_comment() and that will be used instead.
				 */
				wp_list_comments( array( 'callback' => 'meola_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr;  Older Comments', 'meola' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments  &rarr;', 'meola' ) ); ?></div>
		</nav><!-- end #comment-nav -->
		<?php endif; // check for comment navigation ?>

		<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( comments_open() ) : // If comments are open, but there are no comments ?>

		<?php else : // or, if we don't have comments:

			/* If there are no comments and comments are closed,
			 * we can leave a note (but only on posts, not pages).
			 */
			if ( ! comments_open() && ! is_page() ) :
			?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'meola' ); ?></p>
			<?php endif; // end ! comments_open() && ! is_page() ?>

		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form (
		array(
			'comment_notes_before' =>__( '<p class="comment-note">Required fields are marked <span class="required">*</span>.</p>', 'meola'),
			'comment_field'  => '<p class="comment-form-comment"><label for="comment">' . _x( 'Message <span class="required">*</span>', 'noun', 'meola' ) . 			'</label><br/><textarea id="comment" name="comment" rows="8"></textarea></p>',
			'label_submit'	=> __( 'Send Comment', 'meola' ))
		); 
	?>

	</div><!-- end #comments -->