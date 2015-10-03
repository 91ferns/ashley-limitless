<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package limitless-career
 */

if ( ! function_exists( 'ashley_limitless_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ashley_limitless_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'ashley_limitless' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'ashley_limitless' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'ashley_limitless_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ashley_limitless_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'ashley_limitless' ) );
		if ( $categories_list && ashley_limitless_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ashley_limitless' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'ashley_limitless' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ashley_limitless' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'ashley_limitless' ), esc_html__( '1 Comment', 'ashley_limitless' ), esc_html__( '% Comments', 'ashley_limitless' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'ashley_limitless' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function ashley_limitless_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'ashley_limitless_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'ashley_limitless_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so ashley_limitless_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so ashley_limitless_categorized_blog should return false.
		return false;
	}
}

function ashley_limitless_nav_menu( $overrides = null ) {

    $args = array(
        'theme_location'  => 'primary',
        'menu'            => '',
        'container'       => false,
        'menu_class'      => 'nav navbar-nav navbar-right',
        'menu_id'		  => "main-menu",
        'walker'          => new ashley_limitless_Menu_Walker(),
        'echo'            => true
    );
    if ($overrides !== null) {
    	foreach( $overrides as $k=>$v ) {
    		$args[$k] = $v;
    	}
    }
    $defaults = array_merge($args, array('fallback_cb' => array('ashley_limitless_Menu_Walker', 'fallback')));
    wp_nav_menu( $defaults );
}

function ashley_limitless_list_comments( $overrides = null ) {
	$args = array(
        'walker'      => new ashley_limitless_Comments_Walker(),
        'style'       => 'ol',
        'short_ping'  => true,
        'avatar_size' => 64
    );

    if ($overrides !== null) {
    	foreach( $overrides as $k=>$v ) {
    		$args[$k] = $v;
    	}
    }

	wp_list_comments( $args );
}

function ashley_limitless_comment_form( $overrides = null ) {
  $args = array(
    'id_form'           => 'commentform',
    'id_submit'         => 'submit',
    'title_reply'       => __( 'Leave a Reply' ),
    'title_reply_to'    => __( 'Leave a Reply to %s' ),
    'cancel_reply_link' => __( 'Cancel Reply' ),
    'label_submit'      => __( 'Post Comment' ),
    'comment_field' =>
      '<div class="form-group">
          <label for="comment" class="col-sm-2 control-label">' . _x( 'Comment', 'noun' ) . '</label>' .
          '<div class="col-sm-10">
              <textarea id="comment" name="comment" rows="8" class="form-control" aria-required="true"></textarea>
          </div>' .
       '</div>',


    'must_log_in' => '<p class="must-log-in">' .
      sprintf(
          __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
          wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
      ) . '</p>',
    'logged_in_as' => '',
    'comment_notes_before' => '<p class="comment-notes">' .
      __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
      '</p>',
    'comment_notes_after' =>
      '<div class="form-group form-group-submit">
        <div class="col-sm-offset-2 col-sm-10" style="text-align:right;padding-top:15px;">
          <button type="submit" class="btn btn-secondary">'.__('Post Comment').'</button>
        </div>
       </div>',
    'fields' => apply_filters( 'comment_form_default_fields', array(
      'author' =>
          '<div class="form-group">
             <label for="author" class="col-sm-2 control-label">' . __( 'Name', 'domainreference' ) .
              '</label>
              <div class="col-sm-10">
                  <input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
          '" ' . $aria_req . ' />
              </div>
           </div>',
      'email' =>
          '<div class="form-group">
                 <label for="email" class="col-sm-2 control-label">' . __( 'Email', 'domainreference' ) .
          '</label>
          <div class="col-sm-10">
              <input id="email" name="email" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
          '" ' . $aria_req . ' />
              </div>
           </div>',
      'url' =>
          '<div class="form-group">
                 <label for="url" class="col-sm-2 control-label">' . __( 'Website', 'domainreference' ) .
          '</label>
          <div class="col-sm-10">
              <input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
          '" ' . $aria_req . ' />
              </div>
           </div>',
      'submit' => ''
      )
    ),
  );

  if ($overrides !== null) {
    foreach( $overrides as $k=>$v ) {
      $args[$k] = $v;
    }
  }

  comment_form($args);

}

function ashley_limitless_image($img) {
	echo get_template_directory_uri() . '/img/' . $img;
}

function ashley_limitless_bloginfo() {
	$bloginfo = get_bloginfo( 'description' );
	echo apply_filters('bloginfo_colors', $bloginfo);
}

function ashley_limitless_module($k) {
	$k1 = $k + 1;
	?>
	<div class="clearfix columns">
		<figure class="image">
			<img src="<?php ashley_limitless_image("module-image-${k1}.png"); ?>">
		</figure>
		<div class="text">
			<ul>
				<?php switch ($k) {
					case 0: ?>
						<li>Get an answer to the question, “Am I even on the right track?”</li>
						<li>Become more aligned with your true purpose. </li>
						<li>Get more clear on your gifts – and how to translate them into the right jobs for you (this will save you endless hours of applying for the wrong jobs!). </li>
						<li>Shift your perspective and cultivate a success mindset </li>
						<li>Make a plan for where you’re going in your life/career, and HOW to get there.</li>
					<?php break;
					case 1: ?>
						<li>Learn to talk about yourself when someone says, “tell me about yourself” in a way that opens really heavy doors. </li>
						<li>Train your ear to hear an invitation for an elevator pitch…and never feel like you’ve left an opportunity on the table again. </li>
						<li>Discover the two key questions you should ALWAYS ask in a networking conversation. </li>
						<li>Understand how to re-frame something “negative” (i.e. a resume gap, illness, etc.) as it comes up in a networking conversation. </li>
						<li>Learn how to address a looming doubt in the mind of your interviewer.</li>
				<?php } ?>
			</ul>

			<?php if ($k === 0): ?>
				<p><strong>+ TUTORIAL #<?php echo $k + 1; ?>:</strong> How to Leverage LinkedIn for More Clarity On The Best Jobs For You.</p>
			<?php endif; ?>

		</div> <!-- /.text -->
	</div>
	<?php if ($k > 0): ?>
		"After Ashley taught me her elevator pitch formula, I went to a networking event, and tested it out. Right when I was asked 'tell me about yourself,' I used her formula to answer it, and landed a job interview on my first try! This translated into a job offer. I could not believe it."

		Adam Azoff,
		Washington, DC
	<?php endif; ?>
	<?php
}

/**
 * Flush out the transients used in ashley_limitless_categorized_blog.
 */
function ashley_limitless_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'ashley_limitless_categories' );
}
add_action( 'edit_category', 'ashley_limitless_category_transient_flusher' );
add_action( 'save_post',     'ashley_limitless_category_transient_flusher' );
