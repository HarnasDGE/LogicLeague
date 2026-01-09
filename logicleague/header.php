<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <!-- Logo -->
                <div class="navbar-brand">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
                        <div class="logo-icon-shield">
                            <span class="logo-icon">🧠</span>
                        </div>
                        <span class="logo-text">LogicLeague</span>
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Navigation Menu -->
                <div class="navbar-menu" id="navbarMenu">
                    <!-- Mobile Menu Logo -->
                    <div class="mobile-menu-logo">
                        <div class="logo-icon-shield">
                            <span class="logo-icon">🧠</span>
                        </div>
                        <span class="logo-text">LogicLeague</span>
                    </div>

                    <ul class="navbar-nav">
                        <!-- Categories Dropdown -->
                        <li class="nav-item nav-item-dropdown">
                            <a href="#" class="nav-link">
                                📚 Categories <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">🎬 Movies</a></li>
                                <li><a href="#">🌍 Geography</a></li>
                                <li><a href="#">📜 History</a></li>
                                <li><a href="#">🧪 Science</a></li>
                                <li><a href="#">⚽ Sports</a></li>
                            </ul>
                        </li>

                        <!-- Games Dropdown -->
                        <li class="nav-item nav-item-dropdown">
                            <a href="#" class="nav-link">
                                🎮 Games <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo home_url('/sudoku'); ?>">🎲 Sudoku</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">🏆 Rankings</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">⚡ Challenges</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo home_url('/blog'); ?>" class="nav-link">📝 Blog</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">ℹ️ About Us</a>
                        </li>
                    </ul>

                    <!-- Actions -->
                    <div class="navbar-actions">
                        <?php if ( is_user_logged_in() ) : ?>
                            <?php
                                $current_user = wp_get_current_user();
                                $user_name = $current_user->display_name;
                                $user_email = $current_user->user_email;
                                $avatar_url = get_avatar_url( $current_user->ID, array( 'size' => 40 ) );
                            ?>
                            <div class="user-menu-dropdown">
                                <button class="user-menu-trigger" aria-label="User menu" aria-expanded="false">
                                    <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $user_name ); ?>" class="user-avatar">
                                    <span class="user-name"><?php echo esc_html( $user_name ); ?></span>
                                    <svg class="dropdown-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                                <div class="user-menu-content">
                                    <div class="user-menu-header">
                                        <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $user_name ); ?>" class="user-avatar-large">
                                        <div class="user-info">
                                            <div class="user-display-name"><?php echo esc_html( $user_name ); ?></div>
                                            <div class="user-email"><?php echo esc_html( $user_email ); ?></div>
                                        </div>
                                    </div>
                                    <div class="user-menu-divider"></div>
                                    <ul class="user-menu-list">
                                        <li><a href="<?php echo esc_url( home_url( '/profile' ) ); ?>" class="user-menu-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            My Profile
                                        </a></li>
                                        <li><a href="<?php echo esc_url( home_url( '/rankings' ) ); ?>" class="user-menu-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M16 16v6m-4-6v6m-4-6v6M3 3h18v8H3z"></path>
                                                <path d="M3 11h18"></path>
                                            </svg>
                                            My Rankings
                                        </a></li>
                                        <li><a href="<?php echo esc_url( home_url( '/settings' ) ); ?>" class="user-menu-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path d="M12 1v6m0 6v6M5.64 5.64l4.24 4.24m4.24 4.24l4.24 4.24M1 12h6m6 0h6M5.64 18.36l4.24-4.24m4.24-4.24l4.24-4.24"></path>
                                            </svg>
                                            Settings
                                        </a></li>
                                    </ul>
                                    <div class="user-menu-divider"></div>
                                    <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="user-menu-item user-menu-logout">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        Log Out
                                    </a>
                                </div>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo esc_url( wp_login_url( home_url() ) ); ?>" class="btn btn-yellow">Join Now!</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="site-main">
