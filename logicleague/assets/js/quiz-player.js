/**
 * Quiz Player JavaScript
 *
 * @package LogicLeague
 */

class QuizPlayer {
    constructor() {
        this.questions = [];
        this.currentQuestionIndex = 0;
        this.answers = [];
        this.startTime = null;
        this.timerInterval = null;
        this.score = 0;

        this.init();
    }

    init() {
        // Load questions from hidden JSON
        const questionsData = document.getElementById('quizQuestionsData');
        if (questionsData) {
            try {
                this.questions = JSON.parse(questionsData.textContent);
                console.log('Quiz loaded:', this.questions.length, 'questions');

                // Validate questions
                if (this.questions.length === 0) {
                    console.warn('No questions found in quiz data');
                    this.showNoQuestionsMessage();
                    return;
                }

                // Log first question for debugging
                console.log('First question:', this.questions[0]);

            } catch (e) {
                console.error('Failed to parse questions:', e);
                console.log('Raw data:', questionsData.textContent);
                return;
            }
        } else {
            console.error('Question data element not found');
            return;
        }

        // Initialize answers array
        this.answers = new Array(this.questions.length).fill(null);

        // Bind events
        this.bindEvents();
    }

    showNoQuestionsMessage() {
        const startBtn = document.getElementById('startQuizBtn');
        if (startBtn) {
            startBtn.disabled = true;
            startBtn.textContent = 'No Questions Available';
            startBtn.style.opacity = '0.5';
            startBtn.style.cursor = 'not-allowed';
        }

        const intro = document.getElementById('quizIntro');
        if (intro) {
            const warning = document.createElement('div');
            warning.className = 'quiz-error-message';
            warning.style.cssText = 'background: #fee; border: 2px solid #f00; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;';
            warning.innerHTML = '<h4 style="color: #c00; margin-top: 0;">⚠️ No Questions Available</h4><p>This quiz currently has no questions. Please check back later!</p>';
            intro.querySelector('.quiz-intro-content').appendChild(warning);
        }
    }

    bindEvents() {
        // Start quiz button
        const startBtn = document.getElementById('startQuizBtn');
        if (startBtn) {
            startBtn.addEventListener('click', () => this.startQuiz());
        }

        // Navigation buttons
        document.getElementById('prevBtn')?.addEventListener('click', () => this.previousQuestion());
        document.getElementById('nextBtn')?.addEventListener('click', () => this.nextQuestion());
        document.getElementById('submitBtn')?.addEventListener('click', () => this.submitQuiz());

        // Results modal buttons
        document.getElementById('retryBtn')?.addEventListener('click', () => this.retryQuiz());
        document.getElementById('copyLinkBtn')?.addEventListener('click', () => this.copyLink());
        document.getElementById('resultsOverlay')?.addEventListener('click', () => this.closeResults());

        // Share buttons
        document.querySelectorAll('.share-btn[data-network]').forEach(btn => {
            btn.addEventListener('click', (e) => this.shareResults(e.target.closest('[data-network]').dataset.network));
        });
    }

    startQuiz() {
        // Hide intro, show quiz player
        document.getElementById('quizIntro').style.display = 'none';
        document.getElementById('quizPlayer').style.display = 'block';

        // Start timer
        this.startTime = Date.now();
        this.startTimer();

        // Load first question
        this.loadQuestion(0);

        // Smooth scroll to quiz
        document.getElementById('quizPlayer').scrollIntoView({ behavior: 'smooth' });
    }

    startTimer() {
        this.timerInterval = setInterval(() => {
            const elapsed = Date.now() - this.startTime;
            const seconds = Math.floor(elapsed / 1000);
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;

            const timerEl = document.getElementById('quizTimer');
            if (timerEl) {
                timerEl.textContent = `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }
        }, 1000);
    }

    stopTimer() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
        }
    }

    loadQuestion(index) {
        this.currentQuestionIndex = index;
        const question = this.questions[index];

        if (!question) return;

        // Update progress
        this.updateProgress();

        // Update ad rotation (every 3 questions)
        this.updateAdRotation(index);

        // Build question HTML
        let questionHTML = `
            <div class="question-card">
                <h3 class="question-text">
                    ${question.question}
                </h3>
        `;

        // Add image if present
        if (question.image) {
            questionHTML += `
                <div class="question-image">
                    <img src="${question.image}" alt="Question image">
                </div>
            `;
        }

        // Add answer options
        questionHTML += '<div class="answer-options">';

        ['a', 'b', 'c', 'd'].forEach(option => {
            const answerKey = `answer_${option}`;
            if (question[answerKey]) {
                const isSelected = this.answers[index] === option;
                const correctAnswer = question.correct_answer;

                // If question was already answered, show the feedback
                let optionClass = isSelected ? 'selected' : '';
                if (this.answers[index] !== null) {
                    if (option === correctAnswer) {
                        optionClass += ' correct';
                    } else if (option === this.answers[index]) {
                        optionClass += ' incorrect';
                    }
                }

                questionHTML += `
                    <div class="answer-option ${optionClass}" data-answer="${option}">
                        <span class="answer-letter">${option.toUpperCase()}</span>
                        <span class="answer-text">${question[answerKey]}</span>
                    </div>
                `;
            }
        });

        questionHTML += '</div></div>';

        // Update container
        const container = document.getElementById('questionContainer');
        container.innerHTML = questionHTML;

        // If question was already answered, show feedback and disable options
        if (this.answers[index] !== null) {
            const questionCard = container.querySelector('.question-card');
            questionCard.classList.add('answered');

            const isCorrect = this.answers[index] === question.correct_answer;
            this.showFeedback(isCorrect);

            container.querySelectorAll('.answer-option').forEach(option => {
                option.style.pointerEvents = 'none';
            });
        } else {
            // Add click events to answers for new questions
            container.querySelectorAll('.answer-option').forEach(option => {
                option.addEventListener('click', () => this.selectAnswer(option));
            });
        }

        // Update navigation buttons
        this.updateNavigationButtons();
    }

    updateAdRotation(questionIndex) {
        // Calculate which ad to show (changes every 3 questions)
        // Questions 0-2: ad 1, Questions 3-5: ad 2, Questions 6-8: ad 3
        const adNumber = Math.floor(questionIndex / 3) + 1;

        const adSpace = document.getElementById('quizAdSpace');
        if (!adSpace) return;

        // Hide all ads
        const allAds = adSpace.querySelectorAll('.ad-placeholder');
        allAds.forEach(ad => {
            ad.style.display = 'none';
        });

        // Show current ad
        const currentAd = adSpace.querySelector(`[data-ad="${adNumber}"]`);
        if (currentAd) {
            currentAd.style.display = 'block';
        }
    }

    selectAnswer(option) {
        // Check if already answered this question
        if (option.closest('.question-card').classList.contains('answered')) {
            return;
        }

        // Mark question as answered
        option.closest('.question-card').classList.add('answered');

        // Get the selected answer
        const answer = option.dataset.answer;
        this.answers[this.currentQuestionIndex] = answer;

        // Get correct answer
        const correctAnswer = this.questions[this.currentQuestionIndex].correct_answer;

        // Mark selected option
        option.classList.add('selected');

        // Check if answer is correct
        const isCorrect = answer === correctAnswer;

        // Show immediate feedback
        if (isCorrect) {
            option.classList.add('correct');
            this.showFeedback(true);
        } else {
            option.classList.add('incorrect');
            // Also highlight the correct answer
            const correctOption = document.querySelector(`.answer-option[data-answer="${correctAnswer}"]`);
            if (correctOption) {
                correctOption.classList.add('correct');
            }
            this.showFeedback(false);
        }

        // Disable all answer options
        const options = document.querySelectorAll('.answer-option');
        options.forEach(opt => {
            opt.style.pointerEvents = 'none';
        });

        // Enable next button
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        if (this.currentQuestionIndex < this.questions.length - 1) {
            nextBtn.disabled = false;
            nextBtn.classList.add('pulse');
        } else {
            submitBtn.style.display = 'inline-block';
            submitBtn.classList.add('pulse');
        }
    }

    showFeedback(isCorrect) {
        // Remove existing feedback
        const existingFeedback = document.querySelector('.answer-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        // Create feedback element
        const feedback = document.createElement('div');
        feedback.className = `answer-feedback ${isCorrect ? 'correct' : 'incorrect'}`;

        if (isCorrect) {
            feedback.innerHTML = `
                <div class="feedback-icon">✓</div>
                <div class="feedback-text">
                    <strong>Correct!</strong>
                    <p>Great job! That's the right answer.</p>
                </div>
            `;
        } else {
            feedback.innerHTML = `
                <div class="feedback-icon">✗</div>
                <div class="feedback-text">
                    <strong>Incorrect</strong>
                    <p>The correct answer is highlighted in green.</p>
                </div>
            `;
        }

        // Insert feedback after question text
        const questionCard = document.querySelector('.question-card');
        const answerOptions = questionCard.querySelector('.answer-options');
        questionCard.insertBefore(feedback, answerOptions);
    }

    updateProgress() {
        // Update progress bar
        const progress = ((this.currentQuestionIndex + 1) / this.questions.length) * 100;
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            progressFill.style.width = `${progress}%`;
        }

        // Update text
        const currentQ = document.getElementById('currentQuestion');
        if (currentQ) {
            currentQ.textContent = this.currentQuestionIndex + 1;
        }

        const totalQ = document.getElementById('totalQuestions');
        if (totalQ) {
            totalQ.textContent = this.questions.length;
        }
    }

    updateNavigationButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Previous button
        if (prevBtn) {
            prevBtn.disabled = this.currentQuestionIndex === 0;
        }

        // Check if current question is answered
        const isAnswered = this.answers[this.currentQuestionIndex] !== null;

        // Next/Submit button logic
        const isLastQuestion = this.currentQuestionIndex === this.questions.length - 1;

        if (isLastQuestion) {
            nextBtn.style.display = 'none';
            submitBtn.style.display = isAnswered ? 'inline-block' : 'none';
            submitBtn.disabled = !isAnswered;
        } else {
            nextBtn.style.display = 'inline-block';
            submitBtn.style.display = 'none';
            nextBtn.disabled = !isAnswered;
        }

        // Remove pulse animation
        nextBtn.classList.remove('pulse');
        submitBtn.classList.remove('pulse');
    }

    previousQuestion() {
        if (this.currentQuestionIndex > 0) {
            this.loadQuestion(this.currentQuestionIndex - 1);
        }
    }

    nextQuestion() {
        if (this.currentQuestionIndex < this.questions.length - 1) {
            this.loadQuestion(this.currentQuestionIndex + 1);
        }
    }

    submitQuiz() {
        // Check if all questions answered
        const unanswered = this.answers.filter(a => a === null).length;

        if (unanswered > 0) {
            if (!confirm(`You have ${unanswered} unanswered questions. Submit anyway?`)) {
                return;
            }
        }

        // Stop timer
        this.stopTimer();

        // Calculate score
        this.calculateScore();

        // Show results
        this.showResults();
    }

    calculateScore() {
        this.score = 0;

        this.questions.forEach((question, index) => {
            if (this.answers[index] === question.correct_answer) {
                this.score++;
            }
        });
    }

    showResults() {
        const modal = document.getElementById('resultsModal');
        if (!modal) return;

        // Calculate stats
        const totalQuestions = this.questions.length;
        const correctAnswers = this.score;
        const accuracy = Math.round((correctAnswers / totalQuestions) * 100);
        const timeTaken = document.getElementById('quizTimer').textContent;

        // Update results display
        document.getElementById('scoreNumber').textContent = correctAnswers;
        document.getElementById('scoreTotal').textContent = totalQuestions;
        document.getElementById('correctAnswers').textContent = correctAnswers;
        document.getElementById('timeTaken').textContent = timeTaken;
        document.getElementById('accuracy').textContent = accuracy + '%';

        // Set message based on score
        const percentage = (correctAnswers / totalQuestions) * 100;
        let message = '';

        if (percentage === 100) {
            message = '🎉 Perfect Score! You\'re a genius!';
        } else if (percentage >= 80) {
            message = '🌟 Excellent! You really know your stuff!';
        } else if (percentage >= 60) {
            message = '👍 Good job! Keep practicing!';
        } else if (percentage >= 40) {
            message = '📚 Not bad! Try reviewing the material.';
        } else {
            message = '💪 Keep trying! Practice makes perfect!';
        }

        document.getElementById('resultsMessage').innerHTML = `<p class="results-message-text">${message}</p>`;

        // Load suggested quizzes
        this.loadSuggestedQuizzes();

        // Show modal
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    loadSuggestedQuizzes() {
        // This would typically load via AJAX, for now show placeholder
        const container = document.getElementById('suggestedQuizzes');
        if (container) {
            container.innerHTML = '<p class="loading">Loading quizzes...</p>';
        }
    }

    shareResults(network) {
        const score = this.score;
        const total = this.questions.length;
        const title = quizData.quizTitle || 'this quiz';
        const url = quizData.shareUrl || window.location.href;

        const text = `I scored ${score}/${total} on ${title}! Can you beat my score?`;

        let shareUrl = '';

        switch (network) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
                break;
        }

        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    }

    copyLink() {
        const url = quizData.shareUrl || window.location.href;

        navigator.clipboard.writeText(url).then(() => {
            const btn = document.getElementById('copyLinkBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="share-icon">✓</span> Copied!';
            btn.classList.add('copied');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('copied');
            }, 2000);
        });
    }

    retryQuiz() {
        // Reset quiz
        this.currentQuestionIndex = 0;
        this.answers = new Array(this.questions.length).fill(null);
        this.score = 0;

        // Hide results
        document.getElementById('resultsModal').style.display = 'none';
        document.body.style.overflow = '';

        // Restart
        this.startQuiz();
    }

    closeResults() {
        document.getElementById('resultsModal').style.display = 'none';
        document.body.style.overflow = '';
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.single-quiz')) {
        new QuizPlayer();
    }
});
