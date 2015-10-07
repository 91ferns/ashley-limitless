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
					<?php break;
					case 2: ?>
						<li>Discover a proven step-by-step formula to create a world-class resume that stands out from the rest.</li>
						<li>Avoid the biggest mistakes that will send your resume straight to the trash. </li>
						<li>Learn to write like a professional resume writer – including timeless tips and current best practices.</li>
						<li>Position yourself as a thought leader and a high performer (in a way that translates into more $$$ in your bank account).</li>
					<?php break;
					case 3: ?>
						<li>Understand the 2 types of cover letters (and which one you should include with your application). </li>
						<li>See examples of each type of cover letter + how to structure each paragraph. </li>
						<li>Learn common grammar, content &amp; style mistakes to avoid. </li>
						<li>Discover what to do BEFORE you start writing, that can “make” or “break” your application. </li>
					<?php break;
					case 4: ?>
						<li>Learn how to target your networking (hint: talking to family and friends of friends is only scratching the surface!).</li>
						<li>Discover networking strategies that are PROVEN to help you get job offers.</li>
						<li>Want to move to a new city/country? Learn how to land that “destination dream job” without even leaving home.</li>
					<?php break;
					case 5: ?>
						<li>Get scripts and templates for exactly what to write in your “cold” emails to hiring managers and human resources employees. </li>
						<li>Understand the art of effectively following up. </li>
						<li>Learn the structure/formula for writing your own cold emails (when you come across a new type of outreach situation). </li>
						<li>Learn how to leverage your college alumni network, even years after you’ve graduated. </li>
						<li>Land meetings with hiring managers who offer you job opportunities on the spot. </li>
						<li>Learn how to write an effective “thank you” email. </li>
					<?php break;
					case 6: ?>
						<li>Inspire your interviewer and stand out from the crowd.</li>
						<li>Talk about your biggest weaknesses in a way that is honest AND positions you as a strong candidate. </li>
						<li>Answer interview questions about salary expectations with ease & grace. </li>
						<li>Learn how to prepare as effectively as possible.</li>
						<li>Navigate phone or Skype interviews like a pro. </li>
						<li>Secrets on how to tactfully follow up.</li>
					<?php break;
					case 7: ?>
						<li>Negotiate a 20% salary bump before you sign the dotted line.</li>
						<li>Find out what employers are paying in your industry (this can make all the difference in the negotiation process).</li>
						<li>Get a raise – even when the employer tells you the number “isn’t flexible.”</li>
						<li>Learn how to make it a win-win negotiation every time. </li>
				<?php } ?>
			</ul>

			<?php if ($k === 0): ?>
				<p><strong>+ TUTORIAL #1:</strong> How to Leverage LinkedIn for More Clarity On The Best Jobs For You.</p>
			<?php endif; ?>
			<?php if ($k === 4): ?>
				<p><strong>+ TUTORIAL #2:</strong> LinkedIn Secrets to Target Your Networking Efforts.</p>
			<?php endif; ?>
			<?php if ($k === 5): ?>
				<p><strong>TUTORIAL #3:</strong> Use Twitter to Brand Yourself As A Thought Leader & Connect With Contacts Who Seem Inaccessible.. </p>
			<?php endif; ?>

		</div> <!-- /.text -->
	</div>

	<div class="clearfix extended-testimonial">
		<?php if ($k === 1): ?>
			<div class="pull-right">
				<img src="<?php ashley_limitless_image("testimonial-adam.png"); ?>" width="214" height="214">
			</div>

			<blockquote>
				"After Ashley taught me her elevator pitch formula, I went to a networking event, and tested it out. Right when I was asked 'tell me about yourself,' I used her formula to answer it, and landed a job interview on my first try! This translated into a job offer. I could not believe it."
			</blockquote>

			<div class="author">
				Adam Azoff,<br>
				Washington, DC
			</div>
		<?php elseif ($k === 2): ?>

			<blockquote>
				"My son graduated from college but couldn't find a job for a long time. After rewriting his resume with Ashley's system, the results came pretty quickly, and he started getting interviews left and right. I'm elated to say that he finally got a job offer last Friday, paying him more than he expected!"
			</blockquote>

			<div class="author">
				Raffi S.<br>
				Santa Monica, CA
			</div>
		<?php elseif ($k === 5): ?>
			<div class="pull-right">
				<img src="<?php ashley_limitless_image("testimonial-sterling.png"); ?>">
			</div>

			<blockquote>
				"In three weeks, I used Ashley's cold networking strategies to land multiple job offers. We were even featured in the Washington Post for our success!"
			</blockquote>

			<div class="author">
				Sterling Hardaway<br>
				New York, NY
			</div>
		<?php elseif ($k === 6): ?>
			<blockquote>"I'll admit that, going in, I was a bit skeptical about working with a career coach. Ashley saved me a whole lot of time by giving me amazing pointers regarding how to conduct myself during interviews and professional interactions. It's nearly a year since I worked with Ashley and I have a job I didn't think I would ever get."</blockquote>

			<div class="author">Oren S.<br>
			New York, NY</div>
		<?php elseif ($k === 7): ?>
			<div class="pull-right">
				<img src="<?php ashley_limitless_image("testimonial-alex.jpg"); ?>" width="214" height="214">
			</div>

			<blockquote>
				"Ashley's salary negotiation strategy helped me go from $38k to $60k in less than 8 weeks."
			</blockquote>

			<div class="author">Alexandra Makowka<br>Los Angeles, CA</div>
		<?php endif; ?>
	</div>
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
