<?php
/**
 * Comments Template
 *
 * @package LogicLeague
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()): ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ($comment_count === 1) {
                echo '1 Comment';
            } else {
                echo $comment_count . ' Comments';
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'logicleague_comment_callback'
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '← Older Comments',
            'next_text' => 'Newer Comments →',
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')): ?>
        <p class="no-comments">Comments are closed.</p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after' => '</h3>',
        'title_reply' => 'Leave a Comment',
        'comment_field' => '<p class="comment-form-comment"><label for="comment">Comment *</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
        'fields' => array(
            'author' => '<p class="comment-form-author"><label for="author">Name *</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" required /></p>',
            'email' => '<p class="comment-form-email"><label for="email">Email *</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" required /></p>',
            'url' => '<p class="comment-form-url"><label for="url">Website</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" /></p>',
        ),
        'class_submit' => 'submit',
        'submit_button' => '<button type="submit" class="submit">Post Comment</button>',
        'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
    ));
    ?>

</div>
