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

<div class="legal-page contact-page">
    <div class="container">
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
                                <a href="#" class="social-link-icon" aria-label="Facebook">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                                    </svg>
                                    <span>Facebook</span>
                                </a>
                                <a href="#" class="social-link-icon" aria-label="Twitter">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                    <span>Twitter</span>
                                </a>
                                <a href="#" class="social-link-icon" aria-label="Instagram">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span>Instagram</span>
                                </a>
                                <a href="#" class="social-link-icon" aria-label="YouTube">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                    <span>YouTube</span>
                                </a>
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
