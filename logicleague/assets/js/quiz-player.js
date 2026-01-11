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
        this.timerStarted = false;

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

        // Start quiz immediately
        this.startQuiz();
    }

    showNoQuestionsMessage() {
        const player = document.getElementById('quizPlayer');
        if (player) {
            player.innerHTML = '<div class="quiz-error-message" style="background: #fee; border: 2px solid #f00; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;"><h4 style="color: #c00; margin-top: 0;">⚠️ No Questions Available</h4><p>This quiz currently has no questions. Please check back later!</p></div>';
        }
    }

    bindEvents() {
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
        // Load first question
        this.loadQuestion(0);

        // Timer will be started by observeAnswersVisibility() when all answers are visible
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

        // Force clear any existing selections/focus before loading new question
        const existingOptions = document.querySelectorAll('.answer-option');
        existingOptions.forEach(opt => {
            opt.classList.remove('selected', 'correct', 'incorrect');
            opt.blur();
        });

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
                    <div class="answer-option ${optionClass}" data-answer="${option}" tabindex="-1">
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

        // Clear any lingering focus
        if (document.activeElement && document.activeElement !== document.body) {
            document.activeElement.blur();
        }

        // If question was already answered, disable options
        if (this.answers[index] !== null) {
            const questionCard = container.querySelector('.question-card');
            questionCard.classList.add('answered');

            container.querySelectorAll('.answer-option').forEach(option => {
                option.style.pointerEvents = 'none';
                option.blur();
            });
        } else {
            // Add click events to answers for new questions
            container.querySelectorAll('.answer-option').forEach(option => {
                option.addEventListener('click', () => this.selectAnswer(option));
                // Prevent any default focus behavior
                option.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                });
            });

            // Start timer when all answers are visible (only on first question)
            if (!this.timerStarted) {
                this.observeAnswersVisibility(container);
            }
        }

    }

    observeAnswersVisibility(container) {
        // Find the last answer option (4th one)
        const answerOptions = container.querySelectorAll('.answer-option');
        const lastAnswer = answerOptions[answerOptions.length - 1];

        if (!lastAnswer) return;

        // Create intersection observer to detect when 50% of last answer is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // Start timer when at least 50% of the last answer is visible
                if (entry.isIntersecting && entry.intersectionRatio >= 0.5 && !this.timerStarted) {
                    this.timerStarted = true;
                    this.startTime = Date.now();
                    this.startTimer();
                    observer.disconnect(); // Stop observing after timer starts
                }
            });
        }, {
            threshold: 0.5 // Trigger when 50% visible
        });

        observer.observe(lastAnswer);
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

        // Show immediate visual feedback
        if (isCorrect) {
            option.classList.add('correct');
        } else {
            option.classList.add('incorrect');
            // Also highlight the correct answer
            const correctOption = document.querySelector(`.answer-option[data-answer="${correctAnswer}"]`);
            if (correctOption) {
                correctOption.classList.add('correct');
            }
        }

        // Disable all answer options and remove focus
        const options = document.querySelectorAll('.answer-option');
        options.forEach(opt => {
            opt.style.pointerEvents = 'none';
            opt.blur(); // Remove focus from all options
        });

        // Remove focus from the selected option
        option.blur();

        // Check if this is the last question
        if (this.currentQuestionIndex === this.questions.length - 1) {
            // Auto-submit after 2 seconds
            setTimeout(() => {
                this.submitQuiz();
            }, 2000);
        } else {
            // Auto-advance to next question after 1 second
            setTimeout(() => {
                this.nextQuestion();
            }, 1000);
        }
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

        // Save results to user account via AJAX
        this.saveResults();

        // Show results
        this.showResults();
    }

    saveResults() {
        // Only save if user is logged in and we have quiz data
        if (typeof quizPlayerData === 'undefined' || !quizPlayerData.isLoggedIn) {
            return;
        }

        // Calculate time taken in seconds
        const timeTaken = Math.floor((Date.now() - this.startTime) / 1000);

        const data = {
            action: 'save_quiz_result',
            nonce: quizPlayerData.nonce,
            quiz_id: quizPlayerData.quizId,
            score: this.score,
            total_questions: this.questions.length,
            time_taken: timeTaken
        };

        // Send AJAX request
        fetch(quizPlayerData.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('Quiz results saved!', result.data);
                // Optionally show points earned notification
                this.showPointsEarned(result.data);
            } else {
                console.error('Failed to save results:', result.data);
            }
        })
        .catch(error => {
            console.error('Error saving results:', error);
        });
    }

    showPointsEarned(data) {
        // Add points notification to results modal
        const resultsMessage = document.getElementById('resultsMessage');
        if (resultsMessage && data.points_earned) {
            const pointsNotification = document.createElement('div');
            pointsNotification.className = 'points-notification';
            pointsNotification.innerHTML = `
                <div class="points-earned-badge">
                    <span class="points-icon">🏆</span>
                    <div class="points-info">
                        <strong>+${data.points_earned} Points Earned!</strong>
                        <small>Total: ${data.total_points} | Level ${data.level}</small>
                    </div>
                </div>
                ${data.quiz_rank ? `
                <div class="quiz-rank-info">
                    <div class="rank-item">
                        <span class="rank-label">Quiz Rank:</span>
                        <span class="rank-value">#${data.quiz_rank} of ${data.total_players}</span>
                    </div>
                    <div class="rank-item">
                        <span class="rank-label">Global Rank:</span>
                        <span class="rank-value">#${data.global_rank}</span>
                    </div>
                </div>
                ` : ''}
            `;
            resultsMessage.appendChild(pointsNotification);
        }
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
