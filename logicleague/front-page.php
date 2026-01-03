<?php
/**
 * Szablon strony głównej
 *
 * @package LogicLeague
 */

get_header();
?>

<!-- Sekcja Hero -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="hero-text">
                <span class="hero-badge">Witaj w LogicLeague</span>
                <h1 class="hero-title">
                    Rozwijaj swoją logikę<br>
                    <span class="hero-highlight">Osiągaj więcej</span>
                </h1>
                <p class="hero-description">
                    Platforma stworzona dla ludzi, którzy chcą rozwijać swoje umiejętności logicznego myślenia,
                    rozwiązywania problemów i programowania. Dołącz do społeczności i rozpocznij swoją przygodę już dziś.
                </p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary">
                        <span>Rozpocznij teraz</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                    <a href="#" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                        <span>Zobacz więcej</span>
                    </a>
                </div>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Użytkowników</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Zadań</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Kursów</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dekoracyjne elementy -->
    <div class="hero-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
</section>

<!-- Sekcja z najnowszymi postami -->
<section class="recent-posts">
    <div class="container">
        <h2 class="section-title">Najnowsze wpisy</h2>

        <div class="posts-grid">
            <?php
            $recent_posts = new WP_Query( array(
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ) );

            if ( $recent_posts->have_posts() ) :
                while ( $recent_posts->have_posts() ) :
                    $recent_posts->the_post();
                    ?>
                    <article class="post-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-author">przez <?php the_author(); ?></span>
                            </div>

                            <h3 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more">
                                Czytaj więcej →
                            </a>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p>Brak wpisów do wyświetlenia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
