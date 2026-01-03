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
                        <span class="logo-icon">🧠</span>
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
                        <li class="nav-item">
                            <a href="<?php echo home_url('/'); ?>" class="nav-link">Home</a>
                        </li>

                        <!-- Games Dropdown -->
                        <li class="nav-item nav-item-dropdown">
                            <a href="#" class="nav-link">
                                Games <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo home_url('/sudoku'); ?>">Sudoku</a></li>
                            </ul>
                        </li>

                        <!-- Quiz Dropdown -->
                        <li class="nav-item nav-item-dropdown">
                            <a href="#" class="nav-link">
                                Quiz <span class="dropdown-arrow">▼</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Quizy Osobowościowe</a></li>
                                <li><a href="#">Quizy Tematyczne</a></li>
                                <li><a href="#">Quizy Naukowe</a></li>
                                <li><a href="#">Quizy Ogólne</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo home_url('/blog'); ?>" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">About Us</a>
                        </li>
                    </ul>

                    <!-- Login Button -->
                    <div class="navbar-actions">
                        <a href="#" class="btn btn-login">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="site-main">
