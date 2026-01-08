<?php
/**
 * Author Card Template Part
 *
 * Displays an author card with photo, bio, and stats
 *
 * @package LogicLeague
 */

// Get author data
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio = get_the_author_meta('description');
$author_url = get_author_posts_url($author_id);

// Custom meta fields (will be added later if needed)
$author_role = get_user_meta($author_id, 'author_role', true);
$author_experience = get_user_meta($author_id, 'author_experience', true);
$author_expertise = get_user_meta($author_id, 'author_expertise', true);
$author_twitter = get_user_meta($author_id, 'twitter', true);
$author_linkedin = get_user_meta($author_id, 'linkedin', true);

// Get quiz count by author
$args = array(
    'post_type' => 'quiz',
    'author' => $author_id,
    'posts_per_page' => -1,
);
$author_quizzes = new WP_Query($args);
$quiz_count = $author_quizzes->found_posts;
wp_reset_postdata();
?>

<div class="author-card">
    <div class="author-card-avatar">
        <a href="<?php echo esc_url($author_url); ?>">
            <?php echo get_avatar($author_id, 120); ?>
        </a>
    </div>

    <div class="author-card-content">
        <h3 class="author-card-name">
            <a href="<?php echo esc_url($author_url); ?>"><?php echo esc_html($author_name); ?></a>
        </h3>

        <?php if ($author_role) : ?>
            <p class="author-card-role"><?php echo esc_html($author_role); ?></p>
        <?php endif; ?>

        <?php if ($author_bio) : ?>
            <p class="author-card-bio"><?php echo esc_html($author_bio); ?></p>
        <?php endif; ?>

        <?php if ($author_expertise) : ?>
            <div class="author-card-expertise">
                <strong>Expertise:</strong> <?php echo esc_html($author_expertise); ?>
            </div>
        <?php endif; ?>

        <div class="author-card-stats">
            <?php if ($quiz_count > 0) : ?>
                <span class="author-stat">
                    <span class="stat-icon">🎯</span>
                    <span class="stat-value"><?php echo $quiz_count; ?></span>
                    <span class="stat-label">Quizzes</span>
                </span>
            <?php endif; ?>

            <?php if ($author_experience) : ?>
                <span class="author-stat">
                    <span class="stat-icon">⏱️</span>
                    <span class="stat-value"><?php echo esc_html($author_experience); ?></span>
                    <span class="stat-label">Experience</span>
                </span>
            <?php endif; ?>
        </div>

        <?php if ($author_twitter || $author_linkedin) : ?>
            <div class="author-card-social">
                <?php if ($author_twitter) : ?>
                    <a href="<?php echo esc_url($author_twitter); ?>" class="author-social-link" target="_blank" rel="noopener" aria-label="Twitter">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if ($author_linkedin) : ?>
                    <a href="<?php echo esc_url($author_linkedin); ?>" class="author-social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a href="<?php echo esc_url($author_url); ?>" class="author-card-link">
            View All Posts →
        </a>
    </div>
</div>
