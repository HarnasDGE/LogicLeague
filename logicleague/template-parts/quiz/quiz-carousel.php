<!-- Quiz Carousel Section -->
<section class="quiz-carousel-section">
    <div class="container">
        <div class="section-header">
            <h2>Explore More Quizzes</h2>
            <p>Test your knowledge across different categories</p>
        </div>

        <div class="quiz-carousel">
            <?php
            $quizzes = new WP_Query(array(
                'post_type' => 'quiz',
                'posts_per_page' => 6,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            ));

            if ($quizzes->have_posts()):
                while ($quizzes->have_posts()): $quizzes->the_post();
                    $questions = get_field('questions') ?: array();
                    $question_count = is_array($questions) ? count($questions) : 0;
                    $difficulty = get_field('quiz_difficulty');
                    $terms = get_the_terms(get_the_ID(), 'quiz_category');
            ?>
            <div class="quiz-card">
                <?php if (has_post_thumbnail()): ?>
                <div class="quiz-card-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                    <?php if ($terms && !is_wp_error($terms)): ?>
                    <span class="quiz-card-category"><?php echo esc_html($terms[0]->name); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="quiz-card-content">
                    <h3 class="quiz-card-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>

                    <?php if (has_excerpt()): ?>
                    <p class="quiz-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    <?php endif; ?>

                    <div class="quiz-card-meta">
                        <span class="quiz-meta-badge">
                            <span class="meta-icon">📝</span>
                            <?php echo $question_count; ?> Questions
                        </span>
                        <?php if ($difficulty): ?>
                        <span class="quiz-meta-badge">
                            <span class="meta-icon">⭐</span>
                            <?php echo esc_html($difficulty); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <a href="<?php the_permalink(); ?>" class="btn btn-quiz-start">
                        Start Quiz →
                    </a>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>
