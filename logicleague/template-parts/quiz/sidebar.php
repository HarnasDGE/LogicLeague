<!-- Quiz Sidebar -->
<aside class="quiz-sidebar">

    <!-- Leaderboard -->
    <div class="sidebar-widget quiz-leaderboard">
        <h3 class="sidebar-widget-title">🏆 Top Scorers</h3>
        <div class="leaderboard-list">
            <?php
            // Get top 10 scores from database
            global $wpdb;
            $table_name = $wpdb->prefix . 'quiz_leaderboard';
            $quiz_id = get_the_ID();

            $leaderboard = $wpdb->get_results($wpdb->prepare(
                "SELECT
                    ql.user_id,
                    ql.score,
                    ql.total_questions,
                    ql.percentage,
                    ql.time_taken,
                    u.display_name
                FROM (
                    SELECT user_id, MAX(score) as max_score, MIN(time_taken) as best_time
                    FROM $table_name
                    WHERE quiz_id = %d
                    GROUP BY user_id
                ) as best_scores
                INNER JOIN $table_name ql ON ql.user_id = best_scores.user_id
                    AND ql.score = best_scores.max_score
                    AND ql.time_taken = best_scores.best_time
                    AND ql.quiz_id = %d
                LEFT JOIN {$wpdb->users} u ON ql.user_id = u.ID
                ORDER BY ql.score DESC, ql.time_taken ASC
                LIMIT 10",
                $quiz_id,
                $quiz_id
            ));

            if (!empty($leaderboard)):
                $current_user_id = get_current_user_id();
                foreach ($leaderboard as $index => $entry):
                    $is_current_user = $current_user_id && $entry->user_id == $current_user_id;
            ?>
            <div class="leaderboard-item <?php echo $is_current_user ? 'leaderboard-item-current' : ''; ?>">
                <span class="leaderboard-rank">
                    <?php
                    if ($index === 0) echo '🥇';
                    elseif ($index === 1) echo '🥈';
                    elseif ($index === 2) echo '🥉';
                    else echo ($index + 1) . '.';
                    ?>
                </span>
                <div class="leaderboard-info">
                    <span class="leaderboard-name">
                        <?php echo esc_html($entry->display_name ?: 'Anonymous'); ?>
                        <?php if ($is_current_user): ?>
                            <span class="you-badge">You</span>
                        <?php endif; ?>
                    </span>
                    <span class="leaderboard-meta">
                        <?php echo sprintf('%d/%d', $entry->score, $entry->total_questions); ?>
                        (<?php echo number_format($entry->percentage, 0); ?>%)
                    </span>
                </div>
                <span class="leaderboard-score"><?php echo $entry->score; ?>pts</span>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="no-scores">Be the first to score!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- AdSense Placement -->
    <div class="sidebar-widget sidebar-ad">
        <div class="ad-placeholder ad-sidebar">Advertisement</div>
    </div>

    <!-- Related Quizzes -->
    <div class="sidebar-widget sidebar-quizzes">
        <h3 class="sidebar-widget-title">📚 More Quizzes</h3>
        <div class="sidebar-quiz-list">
            <?php
            $current_quiz_id = get_the_ID();
            $terms = get_the_terms($current_quiz_id, 'quiz_category');
            $args = array(
                'post_type' => 'quiz',
                'posts_per_page' => 4,
                'post__not_in' => array($current_quiz_id),
            );

            if ($terms && !is_wp_error($terms)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'quiz_category',
                        'field' => 'term_id',
                        'terms' => $terms[0]->term_id,
                    )
                );
            }

            $related_quizzes = new WP_Query($args);

            if ($related_quizzes->have_posts()):
                while ($related_quizzes->have_posts()): $related_quizzes->the_post();
                    $questions = get_field('questions') ?: array();
                    $q_count = is_array($questions) ? count($questions) : 0;
            ?>
            <a href="<?php the_permalink(); ?>" class="sidebar-quiz-item">
                <?php if (has_post_thumbnail()): ?>
                <div class="sidebar-quiz-thumb">
                    <?php the_post_thumbnail('thumbnail'); ?>
                </div>
                <?php endif; ?>
                <div class="sidebar-quiz-content">
                    <h4><?php the_title(); ?></h4>
                    <span class="sidebar-quiz-meta"><?php echo $q_count; ?> Questions</span>
                </div>
            </a>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- Progress Tracker (if user is logged in) -->
    <?php if (is_user_logged_in()): ?>
    <div class="sidebar-widget user-progress">
        <h3 class="sidebar-widget-title">Your Progress</h3>
        <div class="progress-stats">
            <div class="progress-stat">
                <span class="progress-number">0</span>
                <span class="progress-label">Quizzes Taken</span>
            </div>
            <div class="progress-stat">
                <span class="progress-number">0</span>
                <span class="progress-label">Total Points</span>
            </div>
        </div>
    </div>
    <?php endif; ?>

</aside>
