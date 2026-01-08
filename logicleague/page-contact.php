<?php
/**
 * Template Name: Contact
 *
 * @package LogicLeague
 */

get_header();

// Handle form submission result
$submission_result = '';
if (isset($_GET['submitted'])) {
    if ($_GET['submitted'] === 'success') {
        $submission_result = '<div class="contact-message success">✓ Thank you for your message! We\'ll get back to you within 24-48 hours.</div>';
    } elseif ($_GET['submitted'] === 'error') {
        $submission_result = '<div class="contact-message error">✗ Sorry, there was an error sending your message. Please try again.</div>';
    } elseif ($_GET['submitted'] === 'spam') {
        $submission_result = '<div class="contact-message error">✗ Your submission was flagged as spam. Please try again.</div>';
    } elseif ($_GET['submitted'] === 'rate_limit') {
        $submission_result = '<div class="contact-message error">✗ Too many submissions. Please wait 15 minutes before trying again.</div>';
    }
}
?>

<div class="legal-page-container contact-page">
    <div class="container legal-content">
        <article class="legal-article">
            <header class="legal-header">
                <h1 class="legal-title">Contact Us</h1>
                <p class="legal-subtitle">Have a question, suggestion, or feedback? We'd love to hear from you!</p>
            </header>

            <div class="contact-content">
                <?php echo $submission_result; ?>

                <div class="contact-grid">
                    <!-- Contact Form -->
                    <div class="contact-form-section">
                        <h2>Send Us a Message</h2>
                        <form id="contactForm" class="contact-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="logicleague_contact_form">
                            <?php wp_nonce_field('logicleague_contact_form', 'contact_nonce'); ?>

                            <div class="form-group">
                                <label for="contact_name">Your Name *</label>
                                <input
                                    type="text"
                                    id="contact_name"
                                    name="contact_name"
                                    required
                                    maxlength="100"
                                    placeholder="John Doe"
                                >
                            </div>

                            <div class="form-group">
                                <label for="contact_email">Your Email *</label>
                                <input
                                    type="email"
                                    id="contact_email"
                                    name="contact_email"
                                    required
                                    maxlength="100"
                                    placeholder="john@example.com"
                                >
                            </div>

                            <div class="form-group">
                                <label for="contact_subject">Subject *</label>
                                <select id="contact_subject" name="contact_subject" required>
                                    <option value="">Select a subject...</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Technical Issue">Technical Issue</option>
                                    <option value="Quiz Content">Quiz Content / Suggestions</option>
                                    <option value="Account Issue">Account Issue</option>
                                    <option value="Privacy Concern">Privacy Concern</option>
                                    <option value="Bug Report">Bug Report</option>
                                    <option value="Partnership">Partnership / Business</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contact_message">Your Message *</label>
                                <textarea
                                    id="contact_message"
                                    name="contact_message"
                                    required
                                    rows="6"
                                    maxlength="2000"
                                    placeholder="Tell us more about your inquiry..."
                                ></textarea>
                                <small class="char-counter">Max 2000 characters</small>
                            </div>

                            <div class="form-group gdpr-consent">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="contact_consent" name="contact_consent" required>
                                    <span>I agree to the processing of my personal data as described in the <a href="<?php echo home_url('/privacy-policy'); ?>" target="_blank">Privacy Policy</a> *</span>
                                </label>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    Send Message
                                </button>
                            </div>

                            <p class="form-note">Fields marked with * are required</p>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info-section">
                        <h2>Other Ways to Reach Us</h2>

                        <div class="contact-info-card">
                            <div class="info-icon">📧</div>
                            <h3>Email</h3>
                            <p><a href="mailto:info@logicleague.com">info@logicleague.com</a></p>
                            <p class="info-note">We typically respond within 24-48 hours</p>
                        </div>

                        <div class="contact-info-card">
                            <div class="info-icon">🕐</div>
                            <h3>Response Time</h3>
                            <p><strong>Monday - Friday:</strong> Within 24 hours</p>
                            <p><strong>Weekends:</strong> Within 48 hours</p>
                        </div>

                        <div class="contact-info-card">
                            <div class="info-icon">🌐</div>
                            <h3>Social Media</h3>
                            <p>Follow us for updates and announcements:</p>
                            <div class="social-links">
                                <a href="#" class="social-link">Facebook</a>
                                <a href="#" class="social-link">Twitter</a>
                                <a href="#" class="social-link">Instagram</a>
                            </div>
                        </div>

                        <div class="contact-info-card">
                            <div class="info-icon">❓</div>
                            <h3>FAQ</h3>
                            <p>Before contacting us, check our FAQ section for quick answers to common questions.</p>
                            <a href="<?php echo home_url('/blog'); ?>" class="btn-link">Visit FAQ →</a>
                        </div>

                        <div class="contact-info-card privacy-note">
                            <div class="info-icon">🔒</div>
                            <h3>Your Privacy</h3>
                            <p>We take your privacy seriously. All information submitted through this form is handled in accordance with our Privacy Policy. We will never share your personal information with third parties without your consent.</p>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="legal-footer">
                <div class="legal-nav">
                    <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a>
                    <a href="<?php echo home_url('/terms-of-service'); ?>">Terms of Service</a>
                    <a href="<?php echo home_url('/disclaimer'); ?>">Disclaimer</a>
                </div>
            </footer>
        </article>
    </div>
</div>

<script>
// Character counter for message textarea
document.addEventListener('DOMContentLoaded', function() {
    const messageTextarea = document.getElementById('contact_message');
    const charCounter = document.querySelector('.char-counter');

    if (messageTextarea && charCounter) {
        messageTextarea.addEventListener('input', function() {
            const length = this.value.length;
            const maxLength = this.getAttribute('maxlength');
            charCounter.textContent = `${length} / ${maxLength} characters`;

            if (length > maxLength * 0.9) {
                charCounter.style.color = '#EF4444';
            } else {
                charCounter.style.color = '#6B7280';
            }
        });
    }
});
</script>

<?php
get_footer();
