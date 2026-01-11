<!-- All Quizzes Grid/Carousel Section -->
<section class="all-quizzes-section">
    <div class="container">
        <div class="section-header-center">
            <h2 class="section-title-main">
                <span class="quiz-icon-title">🎯</span> All Quizzes
            </h2>
            <p class="section-subtitle">Challenge yourself with our complete collection</p>
        </div>

        <?php
        $quizzes = new WP_Query(array(
            'post_type' => 'quiz',
            'posts_per_page' => 12,
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        if ($quizzes->have_posts()):
        ?>
        <div class="quiz-grid-wrapper">
            <div class="quiz-grid">
                <?php
                while ($quizzes->have_posts()): $quizzes->the_post();
                    $questions = get_field('questions') ?: array();
                    $question_count = is_array($questions) ? count($questions) : 0;
                    $difficulty = get_field('quiz_difficulty');
                    $terms = get_the_terms(get_the_ID(), 'quiz_category');
                    $category_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';

                    // Calculate difficulty percentage
                    $difficulty_percent = 50; // default
                    if ($difficulty) {
                        $diff_lower = strtolower($difficulty);
                        if (strpos($diff_lower, 'easy') !== false) {
                            $difficulty_percent = 30;
                        } elseif (strpos($diff_lower, 'medium') !== false) {
                            $difficulty_percent = 60;
                        } elseif (strpos($diff_lower, 'hard') !== false) {
                            $difficulty_percent = 90;
                        }
                    }

                    // Get player count from leaderboard
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'quiz_leaderboard';
                    $player_count = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(DISTINCT user_id) FROM $table_name WHERE quiz_id = %d",
                        get_the_ID()
                    ));
                    $player_count = $player_count ? $player_count : 0;
                ?>
                <article class="quiz-grid-card">
                    <a href="<?php the_permalink(); ?>" class="quiz-grid-card-link">
                        <?php if ($category_name): ?>
                        <div class="quiz-grid-badge"><?php echo esc_html($category_name); ?></div>
                        <?php endif; ?>

                        <div class="quiz-grid-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                            <?php else: ?>
                                <div class="quiz-grid-placeholder">
                                    <span class="quiz-placeholder-icon">🎯</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="quiz-grid-content">
                            <h3 class="quiz-grid-title"><?php the_title(); ?></h3>

                            <?php if (has_excerpt()): ?>
                            <p class="quiz-grid-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                            <?php endif; ?>

                            <div class="quiz-grid-stats">
                                <div class="quiz-stat">
                                    <span class="stat-icon">📝</span>
                                    <span class="stat-text"><?php echo $question_count; ?> Questions</span>
                                </div>
                                <?php if ($player_count > 0): ?>
                                <div class="quiz-stat">
                                    <span class="stat-icon">👥</span>
                                    <span class="stat-text"><?php echo number_format($player_count); ?> Players</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($difficulty): ?>
                            <div class="quiz-grid-difficulty">
                                <span class="difficulty-label">Difficulty</span>
                                <div class="difficulty-bar">
                                    <div class="difficulty-fill" style="width: <?php echo $difficulty_percent; ?>%"></div>
                                </div>
                                <span class="difficulty-text"><?php echo esc_html($difficulty); ?></span>
                            </div>
                            <?php endif; ?>

                            <div class="quiz-grid-cta">
                                <span class="cta-text">Start Quiz</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </article>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>

        <!-- Navigation hints for mobile -->
        <div class="quiz-grid-nav-hint" role="status" aria-live="polite">
            <span class="nav-hint-icon">👆</span>
            <span class="nav-hint-text">Swipe to browse more quizzes</span>
        </div>

        <?php else: ?>
        <p class="no-quizzes">No quizzes available yet. Check back soon!</p>
        <?php endif; ?>
    </div>
</section>
