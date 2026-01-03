<?php
/**
 * Archive Template - Blog Posts Listing
 *
 * @package LogicLeague
 */

get_header();
?>

<div class="blog-archive">
    <!-- Blog Hero -->
    <section class="blog-hero">
        <div class="container">
            <h1 class="blog-hero-title">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    echo 'Posts by ' . get_the_author();
                } elseif (is_day()) {
                    echo 'Archive: ' . get_the_date();
                } elseif (is_month()) {
                    echo 'Archive: ' . get_the_date('F Y');
                } elseif (is_year()) {
                    echo 'Archive: ' . get_the_date('Y');
                } else {
                    echo 'Blog';
                }
                ?>
            </h1>
            <?php if (category_description() || tag_description()): ?>
            <p class="blog-hero-description">
                <?php echo category_description() ?: tag_description(); ?>
            </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="blog-content">
        <div class="container">
            <div class="blog-layout">
                <!-- Main Content -->
                <main class="blog-main">
                    <?php if (have_posts()): ?>
                    <div class="posts-grid">
                        <?php while (have_posts()): the_post(); ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()): ?>
                            <a href="<?php the_permalink(); ?>" class="post-card-image">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                            <?php endif; ?>

                            <div class="post-card-content">
                                <div class="post-card-meta">
                                    <span class="post-card-date">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)): ?>
                                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"
                                       class="post-card-category">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>

                                <h2 class="post-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <p class="post-card-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>

                                <a href="<?php the_permalink(); ?>" class="post-card-link">
                                    Read More →
                                </a>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ));
                    ?>

                    <?php else: ?>
                    <div class="no-posts">
                        <h2>No posts found</h2>
                        <p>Sorry, no posts were found. Try browsing other categories or return to the homepage.</p>
                        <a href="<?php echo home_url(); ?>" class="btn btn-primary">Go Home</a>
                    </div>
                    <?php endif; ?>
                </main>

                <!-- Sidebar -->
                <?php get_template_part('template-parts/blog/sidebar'); ?>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
