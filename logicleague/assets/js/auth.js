/**
 * Auth Modals JavaScript - LogicLeague
 * Handles login and register modals and form submissions
 */

// Modal Functions
function openLoginModal() {
    document.getElementById('loginModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLoginModal() {
    document.getElementById('loginModal').style.display = 'none';
    document.body.style.overflow = '';
    // Clear form
    document.getElementById('mainLoginForm').reset();
    document.getElementById('mainLoginError').style.display = 'none';
}

function openRegisterModal() {
    document.getElementById('registerModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    document.getElementById('registerModal').style.display = 'none';
    document.body.style.overflow = '';
    // Clear form
    document.getElementById('mainRegisterForm').reset();
    document.getElementById('mainRegisterError').style.display = 'none';
    document.getElementById('mainRegisterSuccess').style.display = 'none';
}

// Quiz Login Form Handler
document.addEventListener('DOMContentLoaded', function() {
    // Main Login Form
    const mainLoginForm = document.getElementById('mainLoginForm');
    if (mainLoginForm) {
        mainLoginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin(this, 'mainLoginError');
        });
    }

    // Quiz Login Form (in results modal)
    const quizLoginForm = document.getElementById('quizLoginForm');
    if (quizLoginForm) {
        quizLoginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin(this, 'quizLoginError');
        });
    }

    // Main Register Form
    const mainRegisterForm = document.getElementById('mainRegisterForm');
    if (mainRegisterForm) {
        mainRegisterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleRegister(this);
        });
    }

    // Open Register Modal Link
    const openRegisterLink = document.getElementById('openRegisterModal');
    if (openRegisterLink) {
        openRegisterLink.addEventListener('click', function(e) {
            e.preventDefault();
            openRegisterModal();
        });
    }

    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLoginModal();
            closeRegisterModal();
        }
    });
});

// Handle Login
function handleLogin(form, errorElementId) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const errorElement = document.getElementById(errorElementId);

    // Show loader
    btnText.style.display = 'none';
    btnLoader.style.display = 'inline-block';
    submitBtn.disabled = true;
    errorElement.style.display = 'none';

    const formData = new FormData(form);
    formData.append('action', 'logicleague_login');
    formData.append('nonce', authData.nonce);

    fetch(authData.ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
        submitBtn.disabled = false;

        if (data.success) {
            // Success - reload page
            window.location.reload();
        } else {
            // Show error
            errorElement.textContent = data.data || 'Login failed. Please try again.';
            errorElement.style.display = 'block';
        }
    })
    .catch(error => {
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
        submitBtn.disabled = false;
        errorElement.textContent = 'An error occurred. Please try again.';
        errorElement.style.display = 'block';
        console.error('Login error:', error);
    });
}

// Handle Register
function handleRegister(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    const errorElement = document.getElementById('mainRegisterError');
    const successElement = document.getElementById('mainRegisterSuccess');

    // Show loader
    btnText.style.display = 'none';
    btnLoader.style.display = 'inline-block';
    submitBtn.disabled = true;
    errorElement.style.display = 'none';
    successElement.style.display = 'none';

    const formData = new FormData(form);
    formData.append('action', 'logicleague_register');
    formData.append('nonce', authData.nonce);

    fetch(authData.ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
        submitBtn.disabled = false;

        if (data.success) {
            // Show success message
            successElement.textContent = data.data || 'Account created! Redirecting...';
            successElement.style.display = 'block';
            form.reset();

            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            // Show error
            errorElement.textContent = data.data || 'Registration failed. Please try again.';
            errorElement.style.display = 'block';
        }
    })
    .catch(error => {
        btnText.style.display = 'inline-block';
        btnLoader.style.display = 'none';
        submitBtn.disabled = false;
        errorElement.textContent = 'An error occurred. Please try again.';
        errorElement.style.display = 'block';
        console.error('Register error:', error);
    });
}

// Social Login Functions (Placeholders - require OAuth setup)
function loginWithGoogle() {
    alert('Google login will be implemented. This requires OAuth 2.0 setup with Google Cloud Console.');
    // TODO: Implement Google OAuth
}

function loginWithApple() {
    alert('Apple login will be implemented. This requires Sign in with Apple setup.');
    // TODO: Implement Apple Sign In
}

function registerWithGoogle() {
    loginWithGoogle();
}

function registerWithApple() {
    loginWithApple();
}
