<!-- Related Posts Carousel Section -->
<section class="posts-carousel-section">
    <div class="container">
        <div class="section-header">
            <h2>Related Articles</h2>
            <p>Continue exploring our brain-boosting content</p>
        </div>

        <div class="posts-carousel">
            <?php
            // Get current post ID
            $current_post_id = get_the_ID();

            // Get current post categories
            $categories = get_the_category($current_post_id);
            $category_ids = array();

            if ($categories) {
                foreach ($categories as $category) {
                    $category_ids[] = $category->term_id;
                }
            }

            // Query for related posts
            $related_posts_args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => array($current_post_id),
                'orderby' => 'rand'
            );

            // If we have categories, get posts from same categories
            if (!empty($category_ids)) {
                $related_posts_args['category__in'] = $category_ids;
            }

            $related_posts = new WP_Query($related_posts_args);

            if ($related_posts->have_posts()):
                while ($related_posts->have_posts()): $related_posts->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="post-carousel-card">
                <?php if (has_post_thumbnail()): ?>
                <div class="post-carousel-image">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
                <?php else: ?>
                <div class="post-carousel-image" style="background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);"></div>
                <?php endif; ?>

                <div class="post-carousel-content">
                    <div class="post-carousel-meta">
                        <span class="post-carousel-date"><?php echo get_the_date(); ?></span>
                        <?php
                        $post_categories = get_the_category();
                        if (!empty($post_categories)): ?>
                        <span class="post-carousel-category">
                            <?php echo esc_html($post_categories[0]->name); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <h3><?php the_title(); ?></h3>

                    <p class="post-carousel-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                    </p>
                </div>
            </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else:
                // If no related posts, show latest posts
                $latest_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                    'post__not_in' => array($current_post_id)
                ));

                if ($latest_posts->have_posts()):
                    while ($latest_posts->have_posts()): $latest_posts->the_post();
            ?>
            <a href="<?php the_permalink(); ?>" class="post-carousel-card">
                <?php if (has_post_thumbnail()): ?>
                <div class="post-carousel-image">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
                <?php else: ?>
                <div class="post-carousel-image" style="background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);"></div>
                <?php endif; ?>

                <div class="post-carousel-content">
                    <div class="post-carousel-meta">
                        <span class="post-carousel-date"><?php echo get_the_date(); ?></span>
                        <?php
                        $post_categories = get_the_category();
                        if (!empty($post_categories)): ?>
                        <span class="post-carousel-category">
                            <?php echo esc_html($post_categories[0]->name); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <h3><?php the_title(); ?></h3>

                    <p class="post-carousel-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                    </p>
                </div>
            </a>
            <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            endif;
            ?>
        </div>
    </div>
</section>
