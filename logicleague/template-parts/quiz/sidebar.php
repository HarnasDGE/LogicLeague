<!-- Quiz Sidebar -->
<aside class="quiz-sidebar">

    <!-- Leaderboard -->
    <div class="sidebar-widget quiz-leaderboard">
        <h3 class="sidebar-widget-title">🏆 Top Scorers</h3>
        <div class="leaderboard-list">
            <?php
            // Get top 5 quiz scores
            $leaderboard = get_option('quiz_leaderboard_' . get_the_ID(), array());
            if (!empty($leaderboard)):
                $top_scores = array_slice($leaderboard, 0, 5);
                foreach ($top_scores as $index => $entry):
            ?>
            <div class="leaderboard-item">
                <span class="leaderboard-rank">
                    <?php
                    if ($index === 0) echo '🥇';
                    elseif ($index === 1) echo '🥈';
                    elseif ($index === 2) echo '🥉';
                    else echo ($index + 1) . '.';
                    ?>
                </span>
                <div class="leaderboard-info">
                    <span class="leaderboard-name"><?php echo esc_html($entry['name']); ?></span>
                    <span class="leaderboard-time"><?php echo esc_html($entry['time']); ?></span>
                </div>
                <span class="leaderboard-score"><?php echo esc_html($entry['score']); ?>pts</span>
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
                    $q_count = count(get_post_meta(get_the_ID(), 'quiz_question_ids', true) ?: array());
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

    <!-- CTA Box -->
    <div class="sidebar-widget sidebar-cta">
        <div class="cta-box cta-box-gradient">
            <div class="cta-box-icon">🎯</div>
            <h3>Try Sudoku</h3>
            <p>Challenge your logic with number puzzles!</p>
            <a href="<?php echo home_url('/sudoku'); ?>" class="btn btn-white">Play Now</a>
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
