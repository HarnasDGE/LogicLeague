<?php
/**
 * Contact Form Handler
 *
 * Handles contact form submissions with validation, rate limiting, and database logging
 *
 * @package LogicLeague
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize contact form handler
 */
function logicleague_init_contact_form() {
    // Handle form submission
    add_action('admin_post_logicleague_contact_form', 'logicleague_handle_contact_form');
    add_action('admin_post_nopriv_logicleague_contact_form', 'logicleague_handle_contact_form');

    // Create database table on activation
    logicleague_create_contact_submissions_table();
}
add_action('init', 'logicleague_init_contact_form');

/**
 * Create database table for contact submissions
 */
function logicleague_create_contact_submissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();

    // Check if table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            subject varchar(255) NOT NULL,
            message text NOT NULL,
            ip_address varchar(45) NOT NULL,
            user_agent varchar(255),
            user_id bigint(20) DEFAULT NULL,
            status varchar(20) DEFAULT 'new',
            submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY email (email),
            KEY submitted_at (submitted_at),
            KEY ip_address (ip_address)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * Handle contact form submission
 */
function logicleague_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'logicleague_contact_form')) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Get IP address
    $ip_address = logicleague_get_client_ip();

    // Check rate limiting (5 submissions per 15 minutes per IP)
    if (logicleague_is_rate_limited($ip_address)) {
        wp_redirect(add_query_arg('submitted', 'rate_limit', wp_get_referer()));
        exit;
    }

    // Sanitize and validate inputs
    $name = isset($_POST['contact_name']) ? sanitize_text_field($_POST['contact_name']) : '';
    $email = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $subject = isset($_POST['contact_subject']) ? sanitize_text_field($_POST['contact_subject']) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';
    $consent = isset($_POST['contact_consent']) ? true : false;

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Validate email
    if (!is_email($email)) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Validate consent
    if (!$consent) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Validate message length
    if (strlen($message) > 2000) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Basic spam detection
    if (logicleague_is_spam($name, $email, $message)) {
        wp_redirect(add_query_arg('submitted', 'spam', wp_get_referer()));
        exit;
    }

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    $inserted = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'ip_address' => $ip_address,
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : '',
            'user_id' => get_current_user_id() ? get_current_user_id() : null,
            'status' => 'new',
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s')
    );

    if ($inserted === false) {
        wp_redirect(add_query_arg('submitted', 'error', wp_get_referer()));
        exit;
    }

    // Send email notification to admin
    logicleague_send_contact_notification($name, $email, $subject, $message);

    // Send confirmation email to user
    logicleague_send_contact_confirmation($name, $email);

    // Redirect with success message
    wp_redirect(add_query_arg('submitted', 'success', wp_get_referer()));
    exit;
}

/**
 * Get client IP address
 */
function logicleague_get_client_ip() {
    $ip_keys = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    );

    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }

    return '0.0.0.0';
}

/**
 * Check if IP is rate limited
 */
function logicleague_is_rate_limited($ip_address) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_submissions';

    // Check submissions in last 15 minutes
    $count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name
        WHERE ip_address = %s
        AND submitted_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)",
        $ip_address
    ));

    return ($count >= 5);
}

/**
 * Basic spam detection
 */
function logicleague_is_spam($name, $email, $message) {
    // Check for common spam patterns
    $spam_patterns = array(
        '/\b(viagra|cialis|casino|poker|loan|mortgage)\b/i',
        '/\b(buy now|click here|limited time)\b/i',
        '/<a\s+href/i', // HTML links in message
        '/\[url=/i', // BBCode links
    );

    $combined_text = $name . ' ' . $email . ' ' . $message;

    foreach ($spam_patterns as $pattern) {
        if (preg_match($pattern, $combined_text)) {
            return true;
        }
    }

    // Check for too many URLs
    if (substr_count($message, 'http://') + substr_count($message, 'https://') > 3) {
        return true;
    }

    // Check for suspicious email domains
    $spam_domains = array('tempmail.com', 'guerrillamail.com', 'mailinator.com', '10minutemail.com');
    foreach ($spam_domains as $domain) {
        if (strpos($email, $domain) !== false) {
            return true;
        }
    }

    return false;
}

/**
 * Send email notification to admin
 */
function logicleague_send_contact_notification($name, $email, $subject, $message) {
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');

    $email_subject = '[' . $site_name . '] New Contact Form Submission: ' . $subject;

    $email_body = "New contact form submission received:\n\n";
    $email_body .= "Name: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Subject: " . $subject . "\n\n";
    $email_body .= "Message:\n" . $message . "\n\n";
    $email_body .= "---\n";
    $email_body .= "Submitted at: " . current_time('mysql') . "\n";
    $email_body .= "IP Address: " . logicleague_get_client_ip() . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    wp_mail($admin_email, $email_subject, $email_body, $headers);
}

/**
 * Send confirmation email to user
 */
function logicleague_send_contact_confirmation($name, $email) {
    $site_name = get_bloginfo('name');
    $site_url = home_url();

    $email_subject = 'Thank you for contacting ' . $site_name;

    $email_body = "Hi " . $name . ",\n\n";
    $email_body .= "Thank you for reaching out to us! We've received your message and will get back to you within 24-48 hours.\n\n";
    $email_body .= "In the meantime, feel free to explore more quizzes and challenges on our website:\n";
    $email_body .= $site_url . "\n\n";
    $email_body .= "Best regards,\n";
    $email_body .= "The " . $site_name . " Team\n\n";
    $email_body .= "---\n";
    $email_body .= "This is an automated confirmation email. Please do not reply to this email.\n";
    $email_body .= "If you need immediate assistance, please visit: " . home_url('/contact');

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <noreply@logicleague.com>'
    );

    wp_mail($email, $email_subject, $email_body, $headers);
}
