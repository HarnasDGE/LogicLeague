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
                    <ul class="navbar-nav">
                        <!-- Kategorie Dropdown -->
                        <li class="nav-item nav-item-dropdown">
                            <a href="#" class="nav-link">
                                Kategorie <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">🎬 Filmy</a></li>
                                <li><a href="#">🌍 Geografia</a></li>
                                <li><a href="#">📜 Historia</a></li>
                                <li><a href="#">🧪 Science</a></li>
                                <li><a href="#">⚽ Sport</a></li>
                                <li><a href="<?php echo home_url('/sudoku'); ?>">🎲 Sudoku</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Ranking</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Wyzwania</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo home_url('/blog'); ?>" class="nav-link">Blog</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">O nas</a>
                        </li>
                    </ul>

                    <!-- Actions -->
                    <div class="navbar-actions">
                        <button class="btn-search" aria-label="Search">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </button>
                        <a href="#" class="btn btn-outline-purple">Zaloguj się</a>
                        <a href="#" class="btn btn-yellow">Dołącz do Ligi!</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="site-main">
