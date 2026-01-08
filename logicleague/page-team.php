<?php
/**
 * Template Name: Team
 *
 * Displays all team members and content creators
 *
 * @package LogicLeague
 */

get_header();

// Get all users who have published posts or quizzes
$args = array(
    'who' => 'authors',
    'orderby' => 'post_count',
    'order' => 'DESC',
    'number' => 50,
);
$authors = get_users($args);
?>

<div class="team-page">
    <!-- Team Hero Section -->
    <section class="team-hero">
        <div class="container">
            <div class="team-hero-content">
                <span class="team-label">Our Team</span>
                <h1 class="team-hero-title">Meet the Quiz Masters<br>Behind LogicLeague</h1>
                <p class="team-hero-description">
                    Our diverse team of quiz creators, educators, and trivia enthusiasts work tirelessly
                    to bring you engaging, accurate, and challenging content every day. Each member brings
                    unique expertise and passion to create the best learning experience possible.
                </p>
            </div>
        </div>
        <div class="team-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Team Stats Section -->
    <section class="team-stats-section">
        <div class="container">
            <div class="team-stats-grid">
                <div class="team-stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number"><?php echo count($authors); ?></div>
                    <div class="stat-label">Team Members</div>
                </div>
                <div class="team-stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-number">
                        <?php
                        $total_quizzes = wp_count_posts('quiz');
                        echo $total_quizzes->publish;
                        ?>
                    </div>
                    <div class="stat-label">Quizzes Created</div>
                </div>
                <div class="team-stat-card">
                    <div class="stat-icon">📝</div>
                    <div class="stat-number">
                        <?php
                        $total_posts = wp_count_posts('post');
                        echo $total_posts->publish;
                        ?>
                    </div>
                    <div class="stat-label">Articles Written</div>
                </div>
                <div class="team-stat-card">
                    <div class="stat-icon">🌟</div>
                    <div class="stat-number">
                        <?php
                        $years_active = date('Y') - 2024;
                        echo $years_active < 1 ? '1' : $years_active;
                        ?>
                    </div>
                    <div class="stat-label">Years Active</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Members Grid -->
    <section class="team-members-section">
        <div class="container">
            <div class="team-section-header">
                <h2 class="section-title">Our Content Creators</h2>
                <p class="section-description">
                    Every member of our team is dedicated to creating high-quality, engaging content
                    that makes learning fun and accessible to everyone.
                </p>
            </div>

            <?php if (!empty($authors)) : ?>
                <div class="team-members-grid">
                    <?php foreach ($authors as $author) : ?>
                        <?php
                        $author_id = $author->ID;
                        $author_name = $author->display_name;
                        $author_bio = get_user_meta($author_id, 'description', true);
                        $author_role = get_user_meta($author_id, 'author_role', true);
                        $author_expertise = get_user_meta($author_id, 'author_expertise', true);
                        $author_experience = get_user_meta($author_id, 'author_experience', true);
                        $author_url = get_author_posts_url($author_id);
                        $author_twitter = get_user_meta($author_id, 'twitter', true);
                        $author_linkedin = get_user_meta($author_id, 'linkedin', true);

                        // Get content counts
                        $quiz_count = count_user_posts($author_id, 'quiz');
                        $post_count = count_user_posts($author_id, 'post');
                        $total_content = $quiz_count + $post_count;

                        // Skip if no content
                        if ($total_content == 0) continue;
                        ?>

                        <div class="team-member-card">
                            <div class="member-card-header">
                                <div class="member-avatar">
                                    <a href="<?php echo esc_url($author_url); ?>">
                                        <?php echo get_avatar($author_id, 120); ?>
                                    </a>
                                </div>
                                <div class="member-info">
                                    <h3 class="member-name">
                                        <a href="<?php echo esc_url($author_url); ?>">
                                            <?php echo esc_html($author_name); ?>
                                        </a>
                                    </h3>
                                    <?php if ($author_role) : ?>
                                        <p class="member-role"><?php echo esc_html($author_role); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="member-card-body">
                                <?php if ($author_bio) : ?>
                                    <p class="member-bio"><?php echo esc_html(wp_trim_words($author_bio, 25, '...')); ?></p>
                                <?php endif; ?>

                                <?php if ($author_expertise) : ?>
                                    <div class="member-expertise">
                                        <strong>Expertise:</strong> <?php echo esc_html($author_expertise); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="member-stats">
                                    <?php if ($quiz_count > 0) : ?>
                                        <span class="member-stat">
                                            <span class="stat-icon">🎯</span>
                                            <span class="stat-value"><?php echo $quiz_count; ?></span>
                                            <span class="stat-text">Quiz<?php echo $quiz_count !== 1 ? 'zes' : ''; ?></span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($post_count > 0) : ?>
                                        <span class="member-stat">
                                            <span class="stat-icon">📝</span>
                                            <span class="stat-value"><?php echo $post_count; ?></span>
                                            <span class="stat-text">Article<?php echo $post_count !== 1 ? 's' : ''; ?></span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($author_experience) : ?>
                                        <span class="member-stat">
                                            <span class="stat-icon">⏱️</span>
                                            <span class="stat-value"><?php echo esc_html($author_experience); ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="member-card-footer">
                                <?php if ($author_twitter || $author_linkedin) : ?>
                                    <div class="member-social">
                                        <?php if ($author_twitter) : ?>
                                            <a href="<?php echo esc_url($author_twitter); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="Twitter">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($author_linkedin) : ?>
                                            <a href="<?php echo esc_url($author_linkedin); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="LinkedIn">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php echo esc_url($author_url); ?>" class="member-link">
                                    View Profile →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="no-team-members">
                    <p>No team members found.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Join Team CTA -->
    <section class="team-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Want to Join Our Team?</h2>
                <p>We're always looking for passionate quiz creators and educators to join our growing team!</p>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary btn-large">Get in Touch</a>
                    <a href="<?php echo home_url('/about'); ?>" class="btn btn-outline btn-large">Learn More</a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
