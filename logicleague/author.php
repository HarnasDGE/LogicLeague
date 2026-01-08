<?php
/**
 * Author Archive Template
 *
 * Displays author profile with E-E-A-T optimization
 *
 * @package LogicLeague
 */

get_header();

// Get author data
$author_id = get_queried_object_id();
$author = get_queried_object();
$author_name = get_the_author_meta('display_name', $author_id);
$author_bio = get_the_author_meta('description', $author_id);
$author_url = get_author_posts_url($author_id);
$author_email = get_the_author_meta('user_email', $author_id);

// Custom meta fields
$author_role = get_user_meta($author_id, 'author_role', true);
$author_experience = get_user_meta($author_id, 'author_experience', true);
$author_expertise = get_user_meta($author_id, 'author_expertise', true);
$author_credentials = get_user_meta($author_id, 'author_credentials', true);
$author_twitter = get_user_meta($author_id, 'twitter', true);
$author_linkedin = get_user_meta($author_id, 'linkedin', true);
$author_website = get_the_author_meta('user_url', $author_id);

// Get quiz count
$args = array(
    'post_type' => 'quiz',
    'author' => $author_id,
    'posts_per_page' => -1,
);
$author_quizzes = new WP_Query($args);
$quiz_count = $author_quizzes->found_posts;
wp_reset_postdata();

// Get blog post count
$post_count = count_user_posts($author_id, 'post');

// Calculate total content
$total_content = $quiz_count + $post_count;
?>

<div class="author-archive">
    <!-- Author Hero Section -->
    <section class="author-hero">
        <div class="container">
            <div class="author-hero-content">
                <div class="author-hero-avatar">
                    <?php echo get_avatar($author_id, 150); ?>
                </div>
                <div class="author-hero-info">
                    <h1 class="author-hero-name"><?php echo esc_html($author_name); ?></h1>
                    <?php if ($author_role) : ?>
                        <p class="author-hero-role"><?php echo esc_html($author_role); ?></p>
                    <?php endif; ?>
                    <?php if ($author_bio) : ?>
                        <p class="author-hero-bio"><?php echo esc_html($author_bio); ?></p>
                    <?php endif; ?>

                    <div class="author-hero-stats">
                        <?php if ($quiz_count > 0) : ?>
                            <div class="author-stat-item">
                                <span class="stat-number"><?php echo $quiz_count; ?></span>
                                <span class="stat-label">Quizzes</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($post_count > 0) : ?>
                            <div class="author-stat-item">
                                <span class="stat-number"><?php echo $post_count; ?></span>
                                <span class="stat-label">Articles</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($author_experience) : ?>
                            <div class="author-stat-item">
                                <span class="stat-number"><?php echo esc_html($author_experience); ?></span>
                                <span class="stat-label">Experience</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($author_twitter || $author_linkedin || $author_website) : ?>
                        <div class="author-hero-social">
                            <?php if ($author_twitter) : ?>
                                <a href="<?php echo esc_url($author_twitter); ?>" class="author-social-btn" target="_blank" rel="noopener" aria-label="Twitter">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                    Twitter
                                </a>
                            <?php endif; ?>
                            <?php if ($author_linkedin) : ?>
                                <a href="<?php echo esc_url($author_linkedin); ?>" class="author-social-btn" target="_blank" rel="noopener" aria-label="LinkedIn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                    LinkedIn
                                </a>
                            <?php endif; ?>
                            <?php if ($author_website) : ?>
                                <a href="<?php echo esc_url($author_website); ?>" class="author-social-btn" target="_blank" rel="noopener" aria-label="Website">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 16.057v-3.057h2.994c-.059 1.143-.212 2.24-.456 3.279-.823-.12-1.674-.188-2.538-.222zm1.957 2.162c-.499 1.33-1.159 2.497-1.957 3.456v-3.62c.666.028 1.319.081 1.957.164zm-1.957-7.219v-3.015c.868-.034 1.721-.103 2.548-.224.238 1.027.389 2.111.446 3.239h-2.994zm0-5.014v-3.661c.806.969 1.471 2.15 1.971 3.496-.642.084-1.3.137-1.971.165zm2.703-3.267c1.237.496 2.354 1.228 3.29 2.146-.642.234-1.311.442-2.019.607-.344-.992-.775-1.91-1.271-2.753zm-7.241 13.56c-.244-1.039-.398-2.136-.456-3.279h2.994v3.057c-.865.034-1.714.102-2.538.222zm2.538 1.776v3.62c-.798-.959-1.458-2.126-1.957-3.456.638-.083 1.291-.136 1.957-.164zm-2.994-7.055c.057-1.128.207-2.212.446-3.239.827.121 1.68.19 2.548.224v3.015h-2.994zm1.024-5.179c.5-1.346 1.165-2.527 1.97-3.496v3.661c-.671-.028-1.329-.081-1.97-.165zm-2.005-.35c-.708-.165-1.377-.373-2.018-.607.937-.918 2.053-1.65 3.29-2.146-.496.844-.927 1.762-1.272 2.753zm-.549 1.918c-.264 1.151-.434 2.36-.492 3.611h-3.933c.165-1.658.739-3.197 1.617-4.518.88.361 1.816.67 2.808.907zm.009 9.262c-.988.236-1.92.542-2.797.9-.89-1.328-1.471-2.879-1.637-4.551h3.934c.058 1.265.231 2.488.5 3.651zm.553 1.917c.342.976.768 1.881 1.257 2.712-1.223-.49-2.326-1.211-3.256-2.115.636-.229 1.299-.435 1.999-.597zm9.924 0c.7.163 1.362.367 1.999.597-.931.903-2.034 1.625-3.257 2.116.489-.832.915-1.737 1.258-2.713zm.553-1.917c.27-1.163.442-2.386.501-3.651h3.934c-.167 1.672-.748 3.223-1.638 4.551-.877-.358-1.81-.664-2.797-.9zm.501-5.651c-.058-1.251-.229-2.46-.492-3.611.992-.237 1.929-.546 2.809-.907.877 1.321 1.451 2.86 1.616 4.518h-3.933z"/>
                                    </svg>
                                    Website
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="author-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Author Details Section -->
    <section class="author-details">
        <div class="container">
            <div class="author-details-grid">
                <?php if ($author_expertise || $author_credentials) : ?>
                    <div class="author-expertise-card">
                        <h2>Expertise & Credentials</h2>

                        <?php if ($author_expertise) : ?>
                            <div class="expertise-item">
                                <h3>Areas of Expertise</h3>
                                <p><?php echo esc_html($author_expertise); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($author_credentials) : ?>
                            <div class="credentials-item">
                                <h3>Credentials</h3>
                                <p><?php echo esc_html($author_credentials); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="author-activity-card">
                    <h2>Content Contributions</h2>
                    <div class="activity-stats">
                        <div class="activity-stat">
                            <div class="activity-icon">🎯</div>
                            <div class="activity-info">
                                <span class="activity-number"><?php echo $quiz_count; ?></span>
                                <span class="activity-label">Quiz<?php echo $quiz_count !== 1 ? 'zes' : ''; ?> Created</span>
                            </div>
                        </div>
                        <div class="activity-stat">
                            <div class="activity-icon">📝</div>
                            <div class="activity-info">
                                <span class="activity-number"><?php echo $post_count; ?></span>
                                <span class="activity-label">Article<?php echo $post_count !== 1 ? 's' : ''; ?> Written</span>
                            </div>
                        </div>
                        <div class="activity-stat">
                            <div class="activity-icon">🏆</div>
                            <div class="activity-info">
                                <span class="activity-number"><?php echo $total_content; ?></span>
                                <span class="activity-label">Total Contributions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Author Content Section -->
    <section class="author-content">
        <div class="container">
            <h2 class="section-title">Content by <?php echo esc_html($author_name); ?></h2>

            <?php if ($quiz_count > 0) : ?>
                <div class="author-quizzes">
                    <h3 class="subsection-title">Quizzes (<?php echo $quiz_count; ?>)</h3>
                    <div class="quiz-grid">
                        <?php
                        $quiz_args = array(
                            'post_type' => 'quiz',
                            'author' => $author_id,
                            'posts_per_page' => 6,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        );
                        $quizzes = new WP_Query($quiz_args);

                        if ($quizzes->have_posts()) :
                            while ($quizzes->have_posts()) : $quizzes->the_post();
                                get_template_part('template-parts/quiz-card');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    <?php if ($quiz_count > 6) : ?>
                        <div class="view-more">
                            <a href="<?php echo esc_url(add_query_arg('post_type', 'quiz', $author_url)); ?>" class="btn btn-outline">
                                View All Quizzes →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($post_count > 0) : ?>
                <div class="author-posts">
                    <h3 class="subsection-title">Articles (<?php echo $post_count; ?>)</h3>
                    <div class="post-grid">
                        <?php
                        $post_args = array(
                            'post_type' => 'post',
                            'author' => $author_id,
                            'posts_per_page' => 6,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        );
                        $posts = new WP_Query($post_args);

                        if ($posts->have_posts()) :
                            while ($posts->have_posts()) : $posts->the_post();
                                get_template_part('template-parts/content', 'excerpt');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    <?php if ($post_count > 6) : ?>
                        <div class="view-more">
                            <a href="<?php echo esc_url($author_url); ?>" class="btn btn-outline">
                                View All Articles →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
// Add Person schema markup for E-E-A-T
$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $author_name,
    'description' => $author_bio,
    'url' => $author_url,
    'image' => get_avatar_url($author_id, array('size' => 400)),
);

if ($author_role) {
    $schema['jobTitle'] = $author_role;
}

if ($author_expertise) {
    $schema['knowsAbout'] = $author_expertise;
}

if ($author_website) {
    $schema['sameAs'] = array($author_website);
    if ($author_twitter) {
        $schema['sameAs'][] = $author_twitter;
    }
    if ($author_linkedin) {
        $schema['sameAs'][] = $author_linkedin;
    }
} else if ($author_twitter || $author_linkedin) {
    $schema['sameAs'] = array();
    if ($author_twitter) {
        $schema['sameAs'][] = $author_twitter;
    }
    if ($author_linkedin) {
        $schema['sameAs'][] = $author_linkedin;
    }
}

echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
?>

<?php
get_footer();
