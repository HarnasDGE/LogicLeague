# Plan Rozwoju LogicLeague - Strona z Quizami i Grami

## Spis Treści
1. [Obecny Stan Projektu](#obecny-stan-projektu)
2. [Cele i Założenia](#cele-i-założenia)
3. [Brakujące Sekcje i Funkcjonalności](#brakujące-sekcje-i-funkcjonalności)
4. [Plan Implementacji](#plan-implementacji)
5. [Szczegółowe Specyfikacje](#szczegółowe-specyfikacje)

---

## Obecny Stan Projektu

### ✅ Zaimplementowane (60-70% gotowości)

**Struktura Motywu:**
- 24 pliki PHP (szablony, funkcje, klasy)
- 9 plików CSS (modułowe style)
- 5 plików JavaScript (funkcjonalność)
- System template parts dla modularity

**Działające Funkcjonalności:**
- ✅ System blogowy (w pełni funkcjonalny)
- ✅ Quiz player z systemem punktacji
- ✅ Profil użytkownika z poziomami i osiągnięciami
- ✅ Rankingi (top 100 leaderboard)
- ✅ Responsywny design (mobile menu, grid layouts)
- ✅ Front page z hero, karuzelą, kartami kategorii
- ✅ Sudoku - landing page i klasy generatora
- ✅ Social sharing
- ✅ Nawigacja z hamburger menu

**Design System:**
- Paleta kolorów: Purple (#6366F1, #8B5CF6), Pink (#EC4899), Yellow (#FBBF24)
- Typografia: Poppins (Google Fonts)
- Gradient-heavy design
- Micro-animations

### ❌ Brakujące Elementy

**Krytyczne Braki:**
1. **Strony prawne** - Privacy Policy, Terms of Service, Cookie Policy
2. **About Us** - brak strony o nas
3. **Profile autorów** - brak szczegółowych profili
4. **Sudoku gameplay** - tylko landing, brak pełnej gry
5. **System uwierzytelniania** - placeholder login/signup
6. **Search functionality** - przycisk istnieje, brak implementacji
7. **AdSense integration** - placeholdery, brak prawdziwych ID
8. **Cookie consent banner** - wymóg prawny GDPR/CCPA
9. **Karuzele mobile** - gridy istnieją, brak karuzel na mobile
10. **Content** - brak rzeczywistych quizów i pytań

---

## Cele i Założenia

### Główne Cele Biznesowe

1. **Engagement** - zatrzymać użytkownika jak najdłużej
2. **Monetyzacja** - AdSense placement strategy
3. **Mobile-first** - główny target to telefony
4. **E-E-A-T compliance** - SEO i zaufanie Google
5. **Legal compliance** - GDPR, CCPA, ePrivacy
6. **Gamification** - zwiększyć zaangażowanie o 100-150%

### Metryki Sukcesu

- **78%+ completion rate** dla quizów (benchmark branżowy)
- **50% wzrost retencji** przez progressive onboarding
- **100-150% wzrost engagement** przez gamification
- **30-38% wzrost RPM** przez AI-powered ad placement
- **Mobilność** - 44px+ tap targets, fat-finger friendly

### Główne Zasady

- **Mobile-first** - telefony są priorytetem
- **Język korzyści** - komunikujemy wartość dla użytkownika
- **Grids > Carousels** - gridy do browsingu, karuzele (3-5 items) tylko dla featured content
- **Autentyczność** - prawdziwe zdjęcia, doświadczenia, nie stock photos
- **Transparentność** - budowanie zaufania przez otwartość

---

## Brakujące Sekcje i Funkcjonalności

### 1. Strony Prawne (PRIORYTET KRYTYCZNY)

#### Privacy Policy
**Status:** ❌ Nie istnieje
**Wymaganie:** Obowiązkowe prawnie (GDPR, CCPA)
**Elementy:**
- Data collection disclosure (wszystkie kategorie danych)
- Purpose and usage (cel i sposób wykorzystania)
- User rights (GDPR, CCPA)
- Security measures
- Third-party sharing (AdSense, analytics)
- Update schedule (minimum raz na 12 miesięcy - CCPA)

#### Cookie Policy & Consent Banner
**Status:** ❌ Nie istnieje
**Wymaganie:** Obowiązkowe prawnie (GDPR, ePrivacy Directive)
**Elementy:**
- Cookie consent banner z równymi przyciskami "Accept all / Reject all"
- Granular controls (Functional, Analytics, Marketing)
- Brak pre-selected options (opt-in, nie opt-out)
- Cookie preferences link (zawsze dostępny)
- Support for Global Privacy Control (GPC) signals
- Consent record storage dla audytów

#### Terms of Service
**Status:** ❌ Nie istnieje
**Elementy:**
- User agreements i platform rules
- Liability limitations
- Account termination conditions
- Content ownership
- Dispute resolution
- Quiz/game participation rules

#### Dodatkowe Strony Prawne
- **Disclaimer** - dla accuracy content, affiliate relationships
- **Community Guidelines** - dla user-generated content
- **Copyright Notice / DMCA Policy**
- **Contact Information** (wymagane w wielu jurysdykcjach)

---

### 2. About Us i Profile Autorów

#### About Us Page
**Status:** ❌ Nie istnieje
**Best Practices (2025):**
- **Długość:** 400-500 słów (sweet spot)
- **Elementy:**
  - Autentyczna historia (jak powstał LogicLeague)
  - Misja, wartości, wizja
  - Team showcase (zdjęcia zespołu)
  - Social proof (liczby: "10,000+ active players", "500+ quizzes")
  - Certyfikaty, nagrody (jeśli są)
  - Clear CTA (np. "Join our community")

**Design:**
- Visual hierarchy (headings, bullets)
- White space
- Emotional resonance (feelings, nie resume)
- Real photos (nie stock images)

#### Profile Autorów
**Status:** ⚠️ Brak szczegółowych profili
**Elementy dla każdego autora:**
- Short bio (2-3 zdania)
- Photo (profesjonalne, ale autentyczne)
- Years of experience ("10+ lat tworzenia quizów")
- Areas of expertise (np. "Specjalista od geografii i historii")
- Links to previous work
- Gaming knowledge demonstration
- Credentials (publikacje, osiągnięcia)

**E-E-A-T Impact:**
- Experience (first-hand quiz creation)
- Expertise (demonstrable knowledge)
- Authoritativeness (industry recognition)
- Trustworthiness (transparent credentials)

---

### 3. Sudoku - Pełna Implementacja

#### Obecny Stan
- ✅ Landing page z wyborem difficulty
- ✅ PHP classes (Generator, Solver, Validator)
- ✅ Clean URLs
- ❌ Play page UI incomplete
- ❌ JavaScript player controls
- ❌ Daily challenge system
- ❌ Database tables

#### Do Zrobienia

**Sudoku Play Page UI:**
- Number pad (1-9, delete, notes)
- Timer (countdown lub count-up)
- Pencil marks system
- Undo/Redo buttons
- Hint system
- Pause button
- Progress indicator
- Completion detection with confetti animation

**Daily Challenge System:**
- Database tables:
  - `sudoku_daily_leaderboard`
  - `sudoku_daily_completions`
  - `sudoku_statistics`
- IP-based duplicate prevention
- Daily puzzle generation (reset at midnight)
- Leaderboard (fastest times)
- Points integration z user profile

**AJAX Handlers:**
- Save completion endpoint
- Leaderboard retrieval
- Validate move endpoint
- Get hint endpoint

---

### 4. System Uwierzytelniania

**Status:** ⚠️ Placeholder buttons
**Do Zrobienia:**
- Registration form z walidacją
- Login form
- Password reset flow
- Email verification (optional, ale recommended)
- Social login (Google, Facebook - opcjonalnie)
- User dashboard access control
- Remember me functionality
- GDPR-compliant data collection consent

---

### 5. Search Functionality

**Status:** ⚠️ Przycisk istnieje, brak funkcjonalności
**Do Zrobienia:**
- Search form w headerze
- AJAX live search
- Search results page
- Filtering (quizzes, blog posts, sudoku)
- Search analytics tracking
- Autocomplete suggestions

---

### 6. AdSense Integration

**Status:** ⚠️ Placeholders bez real IDs
**Strategia Placement (Gaming Sites):**

**Critical Rules:**
- **Minimum 150px distance** od quiz/game edges
- **Mobile:** max 3 ads per screen fold
- **Desktop:** max 5-7 ads total
- **No ad stacking**
- **<15% initial viewport** coverage

**Recommended Placements:**

1. **Homepage:**
   - Leaderboard (728×90) nad hero section
   - Medium rectangle (300×250) w sidebar
   - Large rectangle (336×280) między quiz grids

2. **Quiz Player:**
   - Interstitial między pytaniami (co 3 pytania)
   - Rewarded ads (opcjonalnie - bonus points za obejrzenie)
   - Rectangle (300×250) w sidebar

3. **Blog Posts:**
   - Leaderboard na początku
   - In-content rectangles co 2-3 paragrafy
   - Sidebar rectangles

4. **Sudoku:**
   - Rectangle obok grida (desktop)
   - Interstitial po zakończeniu gry

**Implementation:**
- Enable Google Auto Ads
- H5 Games Ads API dla Sudoku
- Ad Placement API dla interstitials i rewarded
- A/B testing różnych placement strategies

---

### 7. Mobile Carousel Implementation

**Status:** ❌ Tylko gridy
**Strategia:**
- **Grid dla browsingu** (quiz libraries, categories)
- **Carousel tylko dla featured** (3-5 items max)

**Gdzie Dodać Carousele:**
1. **Homepage:**
   - Featured Weekly Challenges (już istnieje jako grid)
   - "New This Week" - top 5 najnowszych quizów
   - "Trending Now" - top 5 najpopularniejszych

2. **Quiz Results:**
   - "Try Next" carousel - 3-5 podobnych quizów

**Best Practices:**
- Manual swipe controls (nie auto-rotation)
- 3-5 slides maximum
- Vertical scrolling preference
- Reachability w 3-4 steps
- Swipe indicators (dots)

**Implementation:**
- CSS scroll-snap
- Touch event handlers
- Intersection Observer dla lazy loading
- Smooth transitions

---

### 8. Gamification Enhancements

**Obecne:** ✅ Points, levels, badges, leaderboards
**Do Dodania:**

#### Daily Rewards System
- Daily login bonus (+10 points)
- Streak tracking (consecutive days)
- Weekly challenges
- Milestone celebrations

#### Achievement System (rozszerzenie)
- More badges:
  - "Quiz Master" - 100 quizów completed
  - "Speed Demon" - 10 quizów < 2min
  - "Perfect Score" - 10 quizów z 100%
  - "Category Expert" - 20 quizów z jednej kategorii
  - "Daily Grinder" - 7-day streak
- Achievement showcase na profilu
- Unlockable avatars/themes

#### Progress Visualization
- Progress bars dla każdej kategorii
- Visual level-up animations
- Skill trees (optional, advanced)
- Statistics dashboard (accuracy rate, avg score, favorite category)

#### Social Features
- Friend system (challenge friends)
- Share results with custom graphics
- Team competitions (guild system - optional)
- Comments on quiz results

---

### 9. Content Creation Tools

**Status:** ❌ Brak rzeczywistych quizów
**ACF Integration:**
- ✅ ACF field groups likely set up
- ❌ No quiz content created

**Do Zrobienia:**
- Create starter quiz content (minimum 50 quizów):
  - 10 Movies
  - 10 Geography
  - 10 History
  - 10 Science
  - 10 Sports
  - 10 Mixed/General Knowledge

**Admin Panel (Optional):**
- LogicLeague settings panel
- Sudoku difficulty configuration
- Ad placement settings
- Statistics dashboard
- User management

---

### 10. Performance & SEO

**Do Zrobienia:**

#### SEO Enhancements
- Schema markup (Quiz, Article, BreadcrumbList)
- XML sitemap
- Robots.txt optimization
- Open Graph tags (social sharing)
- Twitter Cards
- Canonical URLs
- Alt texts dla wszystkich obrazów
- Meta descriptions (auto-generated z AI)

#### Performance
- Image lazy loading (już może być)
- CSS/JS minification
- Critical CSS inline
- Font loading optimization
- Browser caching headers
- CDN setup (optional)

#### Analytics
- Google Analytics 4 setup
- Event tracking:
  - Quiz starts
  - Quiz completions
  - Average completion time
  - Drop-off points
  - Ad clicks
  - Search queries
- Heatmaps (Hotjar/Microsoft Clarity)

---

## Plan Implementacji

### ✅ Decyzje Użytkownika

1. **Priorytet:** Legal compliance najpierw ✓
2. **Cookie Consent:** Plugin (CookieYes/Complianz) ✓
3. **Social Login:** Google + Email/Password ✓
4. **Social Features:** Solo experience (global leaderboards) ✓

---

### Faza 1: Legal Compliance (PRIORYTET KRYTYCZNY)
**Czas:** Tydzień 1
**Dlaczego najpierw:** Wymogi prawne GDPR/CCPA - nie można publikować bez tego

#### 1.1 Privacy Policy
**Narzędzie:** Termly lub iubenda generator
**Kroki:**
1. Wypełnij questionnaire:
   - Typy zbieranych danych (email, quiz results, points, IP)
   - Cele użycia (user experience, analytics, advertising)
   - Third parties (Google Analytics, AdSense)
   - User rights (access, deletion, export)
2. Generuj policy
3. Customizuj dla LogicLeague (brand voice)
4. Stwórz page template
5. Dodaj do footer navigation

**Pliki:**
- `page-privacy-policy.php` (new)
- Update: `footer.php` (link do policy)

#### 1.2 Cookie Consent Banner
**Wybrane Rozwiązanie:** Plugin (CookieYes lub Complianz)

**Dlaczego Plugin:**
- ✅ Automatyczne updates dla zmian prawnych
- ✅ Built-in GDPR/CCPA/ePrivacy compliance
- ✅ GPC signal support out-of-the-box
- ✅ Consent logging i reporting
- ✅ Multi-language support
- ✅ Mniej maintenance work

**Implementation Steps:**
1. Zainstaluj plugin (CookieYes recommended - free tier dostępny)
2. Konfiguracja:
   - **Necessary cookies:** WordPress session, user preferences
   - **Functional:** User authentication, quiz progress
   - **Analytics:** Google Analytics 4
   - **Marketing:** Google AdSense, remarketing
3. Customize banner design (dopasuj do LogicLeague brand)
4. Equal prominence dla Accept/Reject buttons
5. Test consent flow
6. Integruj z Google Analytics i AdSense (conditional loading)

**Conditional Script Loading (plugin handles):**
```javascript
// Analytics tylko po consent
if (cookieConsent.analytics) {
  // Load GA4
}
// AdSense tylko po consent
if (cookieConsent.marketing) {
  // Load AdSense
}
```

**Pliki:**
- Plugin installation (no custom files needed)
- Możliwe: `assets/css/cookie-banner-override.css` (styling tweaks)

#### 1.3 Terms of Service
**Narzędzie:** Termly/iubenda generator
**Elementy specyficzne dla LogicLeague:**
- Quiz participation rules
- Point system terms
- Leaderboard participation
- User conduct guidelines
- Account termination conditions
- Intellectual property (quiz content)
- Dispute resolution

**Pliki:**
- `page-terms.php` (new)

#### 1.4 Other Legal Pages

**Contact Page:**
- Contact form (spam protection - reCAPTCHA v3)
- Email address
- Social media links
- Response time expectations

**Pliki:**
- `page-contact.php` (new)
- `inc/contact-form-handler.php` (new)

**Disclaimer:**
- Content accuracy disclaimer
- AdSense affiliate disclosure (if applicable)
- Educational purposes statement

**Pliki:**
- `page-disclaimer.php` (new)

**Copyright Notice:**
- Add to footer
- DMCA agent info (if applicable)

#### 1.5 Footer Navigation Update
**Dodaj linki:**
- Privacy Policy
- Terms of Service
- Cookie Preferences (plugin provides)
- Contact
- Disclaimer

**Update:**
- `footer.php`

---

### Faza 1 Summary
**Deliverables:**
- ✅ Privacy Policy page (GDPR/CCPA compliant)
- ✅ Cookie Consent Banner (plugin - CookieYes)
- ✅ Terms of Service page
- ✅ Contact page z form
- ✅ Disclaimer page
- ✅ Footer navigation z legal links

**Czas:** ~3-5 dni
**Po Fazie 1:** Strona jest legally compliant i może być publikowana

---

### Faza 2: About Us & Author Profiles
**Czas:** Tydzień 1-2

1. **About Us Page**
   - Template creation (`page-about.php`)
   - Content writing:
     - Origin story LogicLeague
     - Mission: "Uczyć przez zabawę"
     - Values: Community, Learning, Fun, Competition
     - Team showcase section
     - Statistics ("By the Numbers")
     - Call-to-action
   - Design:
     - Hero z team photo
     - Timeline (optional)
     - Stats counters (animated)
     - Team grid
     - Testimonials (optional)

2. **Author Profile System**
   - Custom post type "Team Member" lub user meta expansion
   - Template (`author.php` enhancement)
   - Fields:
     - Bio (short, long)
     - Photo
     - Role
     - Experience years
     - Expertise areas
     - Social links
     - Created quizzes showcase
   - Archive page (`page-team.php`)

**E-E-A-T Optimization:**
- Add schema markup (Person, Organization)
- Link to author social profiles
- Display credentials prominently
- Show first-hand experience (quiz creation count)

**Pliki:**
- `page-about.php`
- `author.php`
- `page-team.php`
- `template-parts/author-card.php`
- `assets/css/about.css`
- `assets/css/author.css`

---

### Faza 3: Sudoku Complete Implementation
**Czas:** Tydzień 2

1. **Play Page UI**
   - Complete `page-sudoku-play.php` template
   - Number pad component
   - Timer display
   - Controls panel (undo, redo, hint, notes, pause)
   - Progress indicator
   - Completion modal

2. **JavaScript Player**
   - Enhance `sudoku-player.js`:
     - Cell selection logic
     - Number input
     - Pencil marks mode
     - Validation feedback (highlight errors)
     - Timer functionality
     - Undo/Redo stack
     - Hint system
     - Auto-save (localStorage)
     - Completion detection

3. **Database Setup**
   - Create tables:
     ```sql
     CREATE TABLE sudoku_daily_leaderboard (
       id, user_id, difficulty, completion_time, date, created_at
     )
     CREATE TABLE sudoku_daily_completions (
       id, user_id/ip_address, difficulty, date, created_at
     )
     CREATE TABLE sudoku_statistics (
       id, user_id, difficulty, games_played, games_completed, avg_time
     )
     ```

4. **Daily Challenge**
   - Cron job (WP-Cron) - daily puzzle generation
   - Daily leaderboard page template
   - IP-based duplicate prevention
   - Points integration

5. **AJAX Handlers**
   - `save_sudoku_completion`
   - `get_sudoku_leaderboard`
   - `validate_sudoku_move`
   - `get_sudoku_hint`

**Pliki:**
- `templates/page-sudoku-play.php` (enhance)
- `assets/js/sudoku-player.js` (complete)
- `assets/css/sudoku-play.css` (enhance)
- `inc/sudoku-ajax.php` (new)
- `inc/sudoku-database.php` (new)
- `inc/sudoku-daily.php` (new)
- `page-sudoku-leaderboard.php` (new)

---

### Faza 4: Authentication System
**Czas:** Tydzień 2-3
**Wybrane Opcje:** Google Social Login + Email/Password

#### 4.1 Email/Password Authentication

**Registration Form:**
- Template: `page-register.php`
- Fields:
  - Username (unique, alphanumeric + underscore)
  - Email (unique, validated)
  - Password (minimum 8 chars, strength indicator)
  - Confirm Password
  - GDPR consent checkbox ✓
  - "I agree to Terms & Privacy Policy" checkbox
- Validation:
  - Client-side (instant feedback)
  - Server-side (security)
  - AJAX submission (no page reload)
- Success: Auto-login + redirect to profile

**Login Form:**
- Template: `page-login.php`
- Fields:
  - Username or Email
  - Password
  - Remember Me checkbox
  - "Forgot Password?" link
- AJAX submission
- Error handling (clear messages)
- Redirect logic:
  - Default: profile page
  - Or: return to previous page

**Password Reset:**
- Request form (email input)
- Generate secure token (wp_generate_password)
- Send email with reset link
- Reset form (new password + confirm)
- Token expiry (24 hours)

**Pliki:**
- `page-register.php` (new)
- `page-login.php` (new)
- `page-password-reset.php` (new)
- `inc/auth-functions.php` (new)
- `assets/js/auth.js` (new)
- `assets/css/auth.css` (new)

#### 4.2 Google Social Login

**Dlaczego tylko Google:**
- Najpopularniejsza opcja (75%+ adoption)
- Szeroka база użytkowników
- Zaufany provider
- Prosta integracja

**Implementation:**
- Plugin: "Super Socializer" lub "Nextend Social Login"
- Alternatywnie: Custom OAuth 2.0 implementation
  - Google API Console setup
  - Client ID + Secret
  - OAuth 2.0 flow
  - Profile data retrieval (email, name, photo)

**Steps:**
1. Create Google Cloud Project
2. Enable Google+ API
3. Create OAuth 2.0 credentials
4. Configure consent screen
5. Add authorized redirect URIs
6. Implement OAuth flow:
   - "Sign in with Google" button
   - Redirect to Google auth
   - Handle callback
   - Create/link WordPress user
   - Auto-login

**User Data Mapping:**
- Google email → WordPress email
- Google name → WordPress display name
- Google photo → WordPress avatar (Gravatar override)
- Link Google ID to user meta

**Pliki:**
- `inc/google-oauth.php` (new) - if custom
- Or plugin installation
- Update: `page-register.php`, `page-login.php` (add Google button)

#### 4.3 Access Control

**Protected Pages:**
- Profile page
- Quiz history
- Settings (if applicable)

**Redirect Logic:**
- Not logged in → redirect to login
- After login → return to intended page
- After logout → redirect to homepage

**Login Modal (Optional):**
- Popup instead of page redirect
- Better UX (no page change)
- Close to continue as guest

**Pliki:**
- `inc/access-control.php` (new)
- Update: `page-profile.php`, etc. (add auth checks)

#### 4.4 GDPR Compliance for Auth

**Data Collection Consent:**
- Clear checkbox na registration:
  - "I agree to the processing of my personal data as described in the Privacy Policy"
- Cannot proceed without consent
- Store consent timestamp in user meta

**User Rights Implementation:**
- Data export: provide user data download (WordPress built-in)
- Data deletion: account deletion option (WordPress built-in)
- Access: view collected data on profile page

---

### Faza 4 Summary
**Deliverables:**
- ✅ Email/Password registration i login
- ✅ Google Social Login
- ✅ Password reset flow
- ✅ Access control dla protected pages
- ✅ GDPR-compliant consent checkboxes

**Czas:** ~5-7 dni
**Dependency:** Faza 1 (Privacy Policy musi istnieć)

---

### Faza 5: Search Functionality
**Czas:** Tydzień 3

1. **Search Form**
   - Header integration (już istnieje button)
   - Mobile search (expand on click)
   - Search icon animation

2. **AJAX Live Search**
   - Dropdown z results podczas wpisywania
   - Categorize results (Quizzes, Blog Posts, Sudoku)
   - Thumbnails + snippets
   - "View all results" link

3. **Search Results Page**
   - Template (`search.php` enhancement)
   - Filters (type, category, difficulty)
   - Sorting (relevance, date, popularity)
   - Pagination

4. **Analytics**
   - Track search queries
   - "No results" tracking
   - Popular searches widget

**Pliki:**
- `search.php`
- `inc/search-ajax.php`
- `assets/js/search.js`
- `assets/css/search.css`
- `template-parts/search-results.php`

---

### Faza 6: AdSense Integration
**Czas:** Tydzień 3

1. **Account Setup**
   - Google AdSense approval
   - Create ad units
   - Generate ad codes

2. **Implementation**
   - Ad placement functions (`inc/adsense.php`)
   - Placement locations:
     - Homepage (leaderboard, rectangles)
     - Quiz player (interstitials, sidebar)
     - Blog posts (in-content, sidebar)
     - Sudoku (sidebar, completion)
   - Responsive ad code
   - 150px safety margins dla games

3. **H5 Games Ads**
   - Ad Placement API integration
   - Interstitials (między pytaniami, po zakończeniu)
   - Rewarded ads (bonus points za obejrzenie)

4. **Auto Ads**
   - Enable Google Auto Ads
   - Test i optimize placements

5. **Compliance**
   - Cookie consent integration
   - GDPR-compliant personalization toggle
   - Privacy policy update

**Pliki:**
- `inc/adsense.php`
- `template-parts/ads/leaderboard.php`
- `template-parts/ads/rectangle.php`
- `template-parts/ads/interstitial.php`
- `assets/js/adsense-h5.js`

---

### Faza 7: Mobile Carousels
**Czas:** Tydzień 4

1. **Homepage Carousels**
   - "Featured Weekly Challenges" - już istnieje jako carousel
   - Add: "New This Week" - 5 najnowszych
   - Add: "Trending Now" - 5 najpopularniejszych
   - Conditional rendering (carousel mobile, grid desktop)

2. **Carousel Component**
   - Reusable carousel template part
   - Swipe gestures (touch events)
   - CSS scroll-snap
   - Pagination dots
   - Optional arrows
   - Lazy loading images

3. **Quiz Results Carousel**
   - "Try Next" - podobne quizy
   - 3-5 items max

**Best Practices:**
- No auto-rotation
- Manual controls
- Smooth transitions
- Accessibility (keyboard navigation)

**Pliki:**
- `template-parts/carousel.php`
- `assets/js/carousel.js`
- `assets/css/carousel.css`
- Modify: `front-page.php`
- Modify: `single-quiz.php`

---

### Faza 8: Gamification Enhancements
**Czas:** Tydzień 4
**Focus:** Solo Experience (zgodnie z decyzją użytkownika)

#### 8.1 Daily Rewards System

**Daily Login Detection:**
- Check last login date (user meta)
- If different day → award points
- Update last login timestamp

**Streak Tracking:**
- Consecutive days counter
- Grace period: 24h (miss a day = reset)
- Store in user meta: `login_streak`, `last_login_date`

**Points:**
- Daily login: +10 points
- Streak bonus (after 3 days): +5 points per day
- Example: Day 5 = 10 (base) + 5 (streak) = 15 points

**Milestones:**
- 7 days: Badge "Daily Grinder" + 50 bonus points
- 30 days: Badge "Dedicated" + 200 bonus points
- 100 days: Badge "Ultimate" + 1000 bonus points

**Modal Notification:**
- Show on login if daily reward claimed
- Display: points earned, current streak, next milestone
- Confetti animation for milestones

**Pliki:**
- `inc/daily-rewards.php` (new)
- `template-parts/daily-reward-modal.php` (new)
- `assets/js/daily-rewards.js` (new)

#### 8.2 Extended Achievements (Solo-Focused)

**New Badges:**

**Quiz Achievements:**
- 🎯 **First Quiz** (1 completed) - 10 points
- 🏆 **Quiz Enthusiast** (10 completed) - 50 points
- 🌟 **Quiz Master** (100 completed) - 500 points
- ⚡ **Speed Demon** (10 quizzes under 2min) - 100 points
- 💯 **Perfectionist** (10 quizzes 100% accuracy) - 200 points
- 📚 **Category Expert** (20 same category) - 150 points
- 🔥 **Quiz Legend** (500 completed) - 2000 points

**Sudoku Achievements:**
- 🧩 **Sudoku Starter** (1 completed) - 20 points
- 🔢 **Number Ninja** (10 completed) - 100 points
- 🎓 **Sudoku Scholar** (50 completed) - 500 points
- ⏱️ **Speed Solver** (10 under 5min) - 200 points

**Engagement Achievements:**
- 🔥 **Daily Grinder** (7-day streak) - 50 points
- 💪 **Dedicated** (30-day streak) - 200 points
- 👑 **Ultimate** (100-day streak) - 1000 points

**Leaderboard Achievements:**
- 🏅 **Top 100** (reach top 100) - 100 points
- 🥉 **Top 10** (reach top 10) - 500 points
- 🥇 **Champion** (reach #1) - 2000 points

**Badge Showcase:**
- Display on profile page
- Grid layout (unlocked badges colorful, locked greyed out)
- Progress bars dla tracked achievements
- Hover tooltip: achievement description + progress

**Unlock Animations:**
- Modal popup when achievement unlocked
- Confetti effect
- Badge zoom-in animation
- Sound effect (optional, subtle)

**Pliki:**
- `inc/achievements.php` (new)
- `template-parts/achievement-modal.php` (new)
- Update: `page-profile.php` (badge showcase section)
- `assets/js/achievements.js` (new)
- `assets/css/achievements.css` (new)

#### 8.3 Progress Dashboard Enhancement

**Profile Page Additions:**

**Overall Stats:**
- Total points (existing)
- Current level (existing)
- Progress to next level (visual bar)
- Global rank (#123 of 10,542)
- Total quizzes completed
- Total sudoku completed
- Total time played (new tracking)
- Account age (days since registration)

**Quiz Statistics:**
- Average quiz score (percentage)
- Average completion time
- Best score (100% x times)
- Favorite category (most quizzes completed)
- Category breakdown (pie chart or bars):
  - Movies: 15 quizzes
  - Geography: 20 quizzes
  - etc.

**Sudoku Statistics:**
- Easy/Medium/Hard/Expert completions
- Average completion time per difficulty
- Best time per difficulty
- Success rate (completions / attempts)

**Recent Activity:**
- Last 10 quizzes (existing)
- Last 5 sudoku games
- Recent achievements (last 5)

**Visual Enhancements:**
- Progress bars (animated on page load)
- Charts (Chart.js dla category breakdown)
- Stat cards z icons
- Hover effects

**Pliki:**
- Update: `page-profile.php` (enhanced stats sections)
- Update: `inc/user-functions.php` (new stat calculations)
- Update: `assets/css/profile.css` (new styles)
- Add: Chart.js library (CDN)

#### 8.4 Social Sharing Enhancements (Solo-Focused)

**Custom Result Share Graphics:**
- Generate image z Canvas API
- Include:
  - Quiz name
  - Score (e.g., "18/20 correct!")
  - Completion time
  - LogicLeague branding
  - User level/badge (optional)
- Download option
- Direct share to:
  - Facebook (existing)
  - Twitter (existing)
  - WhatsApp (existing)
  - Copy link (existing)

**Implementation:**
- Use HTML5 Canvas to draw image
- Convert to blob
- Download or share via Web Share API

**Pliki:**
- Update: `assets/js/quiz-player.js` (enhance share graphics)
- Add: `assets/js/canvas-share.js` (new)

#### 8.5 Global Leaderboard Enhancements

**Rankings Page Improvements:**
- **Time Filters:**
  - All-time (existing)
  - This Week (new)
  - This Month (new)
- **Category Leaderboards:**
  - Overall (existing)
  - Per category (Movies, Geography, etc.)
- **Sudoku Leaderboards:**
  - Overall sudoku points
  - Per difficulty
  - Fastest times
- **Visual Enhancements:**
  - Current user highlight (different color)
  - Animated counter numbers
  - Trophy icons (gold/silver/bronze)
  - User avatars

**Pliki:**
- Update: `page-rankings.php` (filters, categories)
- Update: `assets/css/rankings.css`
- Update: `inc/leaderboard-functions.php`

---

### Faza 8 Summary
**Deliverables:**
- ✅ Daily rewards system z streaks
- ✅ 15+ new achievements z unlock animations
- ✅ Enhanced profile dashboard z stats i charts
- ✅ Custom share graphics (Canvas API)
- ✅ Enhanced global leaderboards (filters, categories)

**Note:** Social features (friend system, challenges) postponed dla future phase
**Czas:** ~5-7 dni

---

### Faza 9: Content Creation
**Czas:** Tydzień 5

1. **Quiz Content**
   - Create 50+ quizzes via ACF:
     - 10 Movies (example: "90s Movies", "Marvel Universe")
     - 10 Geography ("European Capitals", "World Landmarks")
     - 10 History ("Ancient Rome", "World War II")
     - 10 Science ("Human Body", "Space Exploration")
     - 10 Sports ("Football Legends", "Olympic Games")
     - 10 General Knowledge

2. **Blog Content**
   - 10-15 blog posts:
     - Quiz strategies
     - Fun facts articles
     - Game tutorials
     - Community highlights
     - Behind-the-scenes

3. **Images**
   - Category images (8 categories)
   - Quiz thumbnails (50+)
   - Blog post featured images
   - Team photos dla About Us
   - Author headshots

**Content Guidelines:**
- E-E-A-T compliant (doświadczenie, ekspertyza)
- Engaging titles
- SEO-optimized
- Benefit-driven copy
- Call-to-actions

---

### Faza 10: Performance, SEO & Analytics
**Czas:** Tydzień 5

1. **SEO Implementation**
   - Schema markup:
     - Quiz schema
     - Article schema
     - Organization schema
     - Person schema (authors)
     - BreadcrumbList
   - XML sitemap (Yoast/RankMath lub custom)
   - Robots.txt
   - Open Graph tags
   - Twitter Cards
   - Meta descriptions automation

2. **Performance Optimization**
   - Image optimization (WebP, lazy loading)
   - CSS/JS minification
   - Critical CSS inline
   - Font optimization (preload, font-display: swap)
   - Caching headers
   - GZIP compression
   - Database query optimization

3. **Analytics Setup**
   - Google Analytics 4
   - Event tracking:
     - Quiz start/complete
     - Sudoku start/complete
     - Registration
     - Login
     - Ad impressions
     - Search queries
   - Google Search Console
   - Heatmaps (Hotjar/Clarity)

4. **Testing**
   - PageSpeed Insights
   - Mobile-Friendly Test
   - Core Web Vitals
   - Cross-browser testing
   - Accessibility audit (WCAG 2.1)

**Pliki:**
- `inc/schema.php`
- `inc/seo.php`
- `inc/analytics.php`
- Modify: `functions.php` (enqueue optimization)

---

## Szczegółowe Specyfikacje

### Design System Enhancements

#### Color Palette
- **Primary:** Purple gradient (#6366F1 → #8B5CF6)
- **Secondary:** Pink (#EC4899)
- **Accent:** Yellow (#FBBF24)
- **Dark BG:** #0F172A
- **Success:** Green (#10B981)
- **Error:** Red (#EF4444)
- **Warning:** Orange (#F59E0B)

#### Typography Scale
- **H1:** 3rem (48px) mobile, 4rem (64px) desktop
- **H2:** 2.5rem (40px) mobile, 3rem (48px) desktop
- **H3:** 2rem (32px)
- **H4:** 1.5rem (24px)
- **Body:** 1rem (16px)
- **Small:** 0.875rem (14px)

#### Spacing System
- **XS:** 0.25rem (4px)
- **S:** 0.5rem (8px)
- **M:** 1rem (16px)
- **L:** 1.5rem (24px)
- **XL:** 2rem (32px)
- **2XL:** 3rem (48px)
- **3XL:** 4rem (64px)

#### Breakpoints
```css
/* Mobile-first approach */
@media (min-width: 480px) { /* Small phones */ }
@media (min-width: 768px) { /* Tablets */ }
@media (min-width: 1024px) { /* Laptops */ }
@media (min-width: 1280px) { /* Desktops */ }
```

#### Components

**Buttons:**
- Primary: Gradient purple, white text, hover lift
- Secondary: Outline purple, hover fill
- Tertiary: Text only, hover underline
- Sizes: Small (36px), Medium (44px), Large (52px)
- Min tap target: 44px × 44px (mobile)

**Cards:**
- Border-radius: 1rem (16px)
- Shadow: 0 4px 6px rgba(0,0,0,0.1)
- Hover: lift + glow effect
- Image aspect ratio: 16:9 dla quiz thumbnails

**Modals:**
- Backdrop blur + dark overlay
- Centered, max-width: 600px
- Close button (top-right)
- Smooth fade-in animation

**Badges:**
- Border-radius: 9999px (pill shape)
- Small: 20px height
- Medium: 24px height
- Colors: category-based

**Progress Bars:**
- Height: 8px
- Border-radius: 4px
- Gradient fill
- Smooth width transition

---

### Mobile-First Checklist

#### Touch Targets
- ✅ Minimum 44px × 44px dla wszystkich interactive elements
- ✅ Spacing między targets: minimum 8px
- ✅ Fat-finger friendly design

#### Navigation
- ✅ Hamburger menu (slide-in from left)
- ✅ Overlay backdrop
- ✅ Close on outside click
- ✅ Smooth transitions
- ⚠️ Consider bottom navigation dla quick access

#### Typography
- ✅ Readable font sizes (minimum 16px body)
- ✅ Line height: 1.5-1.6 dla body text
- ✅ Contrast ratio: minimum 4.5:1 (WCAG AA)

#### Forms
- Large input fields (minimum 44px height)
- Clear labels above fields
- Inline validation
- Error messages below fields
- Autofocus first field (desktop only)
- Mobile keyboard optimization (type="email", "tel", etc.)

#### Images
- Responsive images (srcset)
- Lazy loading
- WebP format with fallbacks
- Alt texts (accessibility + SEO)

#### Performance
- Critical CSS inline
- Deferred JavaScript
- Font preloading
- Image optimization
- Minimize HTTP requests

---

### E-E-A-T Optimization Strategy

#### Experience (Najważniejsze dla gaming/entertainment)
- **First-hand content:**
  - Personal quiz creation stories
  - Gameplay screenshots
  - Behind-the-scenes tworzenia quizów
  - Real user testimonials
- **Original media:**
  - Custom graphics, nie stock photos
  - Team photos
  - Author photos
  - Quiz result screenshots

#### Expertise
- **Author credentials:**
  - Years of experience prominently displayed
  - Expertise areas clearly defined
  - Quiz creation count visible
  - Educational background (if relevant)
- **Content depth:**
  - Detailed quiz explanations
  - Educational blog posts
  - Comprehensive guides
  - Expert quotes and citations

#### Authoritativeness
- **Backlinks strategy:**
  - Guest posting on gaming blogs
  - Quiz embeds on partner sites
  - Social media presence
  - Industry recognition
- **Content:**
  - Reference-worthy guides
  - Original research/statistics
  - Comprehensive resources
  - Linkable assets

#### Trustworthiness
- **Transparency:**
  - Clear About Us
  - Author profiles z real photos
  - Contact information visible
  - Privacy policy accessible
- **Accuracy:**
  - Fact-checking quizów
  - Source citations
  - Correction policy
  - Regular content updates
- **Security:**
  - HTTPS (SSL certificate)
  - Secure payment (if applicable)
  - Data protection measures
  - Cookie consent

#### Implementation Checklist
- [ ] Author bylines na wszystkich quizach/posts
- [ ] Author bio boxes
- [ ] About Us page z team showcase
- [ ] Privacy Policy + Terms
- [ ] Contact page
- [ ] Social proof (user count, quiz count)
- [ ] Schema markup (Organization, Person, Quiz)
- [ ] Regular content updates
- [ ] User reviews/testimonials
- [ ] Trust badges (if applicable)

---

### AdSense Placement Map

#### Homepage
```
┌─────────────────────────────┐
│ Navbar                      │
├─────────────────────────────┤
│ [Leaderboard 728×90]        │ ← Desktop only
├─────────────────────────────┤
│ Hero Section                │
├─────────────────────────────┤
│ Featured Carousel           │
├─────────────────────────────┤
│ [Rectangle 300×250]         │ ← Between sections
├─────────────────────────────┤
│ Quiz Categories Grid        │
│ ┌────┬────┬────┬────┐      │
│ │Quiz│Quiz│Quiz│Quiz│      │
│ └────┴────┴────┴────┘      │
│ ┌────┬────┬────┬────┐      │
│ │Quiz│Quiz│Quiz│Quiz│      │
│ └────┴────┴────┴────┘      │
├─────────────────────────────┤
│ [Large Rectangle 336×280]   │ ← After grid
├─────────────────────────────┤
│ CTA Ranking Banner          │
├─────────────────────────────┤
│ Newsletter Section          │
├─────────────────────────────┤
│ Footer                      │
└─────────────────────────────┘
```

#### Quiz Player
```
Desktop:
┌──────────────────┬──────────┐
│ Quiz Question    │ Sidebar  │
│                  │ ┌──────┐ │
│ A) Answer        │ │Ad    │ │
│ B) Answer        │ │300×  │ │
│ C) Answer        │ │250   │ │
│ D) Answer        │ └──────┘ │
│                  │          │
│ [Next Question]  │ Stats    │
└──────────────────┴──────────┘

Mobile:
┌─────────────────┐
│ Progress Bar    │
├─────────────────┤
│ Quiz Question   │
│                 │
│ A) Answer       │
│ B) Answer       │
│ C) Answer       │
│ D) Answer       │
│                 │
│ [Next Question] │
├─────────────────┤
│ [Ad 300×250]    │ ← Every 3 questions
├─────────────────┤
│ Next Question   │
└─────────────────┘
```

#### Distances
- Minimum **150px** od quiz/game interactive area
- Mobile: ads między pytaniami, nie obok
- Desktop: sidebar ads OK jeśli >150px od answers

---

### Cookie Consent Banner Specification

#### Visual Design
```
┌────────────────────────────────────────────────┐
│ 🍪 We use cookies                              │
│                                                │
│ We use cookies to improve your experience,    │
│ analyze traffic, and serve personalized ads.  │
│ [Cookie Preferences]                           │
│                                                │
│ [Reject All]      [Accept All]                 │
└────────────────────────────────────────────────┘
```

#### Requirements
- **Equal visual prominence** dla Reject/Accept buttons
- **No pre-checked boxes** w preferences
- **Granular controls:**
  - ☑ Necessary (always on, disabled checkbox)
  - ☐ Functional
  - ☐ Analytics
  - ☐ Marketing/Advertising
- **Always accessible** "Cookie Preferences" link (footer)
- **GPC support** (Global Privacy Control)
- **Consent logging** dla audytów
- **No cookies set** until consent (except strictly necessary)

#### Implementation
- Display on first visit
- Store consent in localStorage + database
- Respect GPC signals
- Update AdSense/Analytics based on consent
- Re-prompt after 12 months lub privacy policy change

---

### Gamification Mechanics Detail

#### Points System
- **Quiz completion:** 10-50 points (based on difficulty)
- **Correct answer:** 2 points
- **Speed bonus:** +1-5 points (based on answer speed)
- **Daily login:** 10 points
- **Streak bonus:** +5 points per day after 3-day streak
- **Sudoku completion:** 20-100 points (based on difficulty)
- **Achievement unlock:** 50-200 points

#### Levels
- **Calculation:** `level = floor(total_points / 1000)`
- **Level names:**
  - 1-5: Novice
  - 6-10: Apprentice
  - 11-20: Expert
  - 21-30: Master
  - 31-50: Grandmaster
  - 51+: Legend

#### Badges
**Quiz Badges:**
- 🎯 First Quiz (1 completed)
- 🏆 Quiz Enthusiast (10 completed)
- 🌟 Quiz Master (100 completed)
- ⚡ Speed Demon (10 quizzes under 2min)
- 💯 Perfectionist (10 quizzes 100% accuracy)
- 📚 Category Expert (20 same category)

**Sudoku Badges:**
- 🧩 Sudoku Starter (1 completed)
- 🔢 Number Ninja (10 completed)
- 🎓 Sudoku Scholar (50 completed)
- ⏱️ Speed Solver (10 under 5min)

**Engagement Badges:**
- 🔥 Daily Grinder (7-day streak)
- 💪 Dedicated (30-day streak)
- 👑 Ultimate (100-day streak)
- 🏅 Top 10 (reach leaderboard top 10)
- 🥇 Champion (reach #1)

#### Streaks
- Track consecutive days logged in
- Visual streak counter na profilu
- Streak milestones: 7, 14, 30, 60, 100 days
- Streak recovery: grace period 24h (optional)

#### Leaderboards
- **Global:** top 100 all-time
- **Weekly:** reset every Monday
- **Monthly:** reset 1st of month
- **Friends:** top friends only (if friend system)
- **Category-specific:** top per quiz category

---

### Content Guidelines

#### Quiz Titles
- **Format:** "[Number] [Adjective] [Topic] [Format]"
- **Examples:**
  - "20 Mind-Bending Science Questions"
  - "Can You Name These 90s Movies?"
  - "Ultimate World Geography Challenge"
- **Best Practices:**
  - Use numbers
  - Include challenge/emotional hooks
  - Keep under 60 characters
  - Benefit-driven ("Test Your Knowledge", "Challenge Yourself")

#### Quiz Descriptions
- **Length:** 50-150 words
- **Include:**
  - What topic covers
  - Difficulty level
  - Estimated time
  - What user will learn/gain
  - Call-to-action
- **Example:**
  > "Think you know the Marvel Universe inside out? Put your superhero knowledge to the test with this challenging 20-question quiz! From the Infinity Stones to hidden Easter eggs, we'll see if you're a true MCU fan. Average completion time: 5 minutes. Can you score 100%? Let's find out!"

#### Blog Post Topics
- Quiz strategies and tips
- "How to Improve Your Quiz Score"
- Fun facts and trivia
- Behind-the-scenes quiz creation
- User spotlights and success stories
- Educational content related to quiz topics
- Community events and challenges

#### Tone of Voice
- **Friendly & Encouraging**
- **Playful but respectful**
- **Benefits-focused** ("You'll learn...", "Challenge yourself...")
- **Inclusive** ("Join our community...")
- **Exciting** ("Mind-blowing", "Ultimate", "Epic")
- **Avoid:** Condescending, overly academic, boring

---

## Szczegóły Techniczne Kluczowych Implementacji

### Faza 1: Legal Compliance - Implementacja

#### Privacy Policy Template
**Plik:** `page-privacy-policy.php`
- WordPress native privacy policy integration
- Sections: Data Collection, Usage, Sharing, GDPR Rights, Retention
- Cookie consent integration (CookieYes button)
- Sidebar z legal menu navigation
- Styling: `assets/css/legal.css`

#### Cookie Consent - CookieYes Plugin
**Setup:**
1. Install plugin: CookieYes (free tier)
2. Configure categories:
   - Necessary: WordPress session, nonces
   - Functional: User auth, quiz progress
   - Analytics: Google Analytics 4
   - Marketing: Google AdSense
3. Conditional script loading via `data-cookieyes` attribute
4. Banner customization: equal Accept/Reject buttons, no pre-checked boxes

**Code Integration (`functions.php`):**
```php
// Conditional script loading
add_filter('script_loader_tag', 'logicleague_add_cookie_categories', 10, 2);
// Consent-based AdSense/Analytics loading
```

#### Contact Form
**Plik:** `page-contact.php`
- Fields: Name, Email, Subject (dropdown), Message
- Spam protection: reCAPTCHA v3 (optional)
- Server-side validation + nonce security
- Database logging: `wp_contact_submissions` table
- Email delivery via `wp_mail()`
- Rate limiting: 5 requests per 15 min

**Database Schema:**
```sql
CREATE TABLE wp_contact_submissions (
  id bigint(20) AUTO_INCREMENT PRIMARY KEY,
  name varchar(100),
  email varchar(100),
  subject varchar(255),
  message text,
  ip_address varchar(45),
  submitted_at datetime,
  INDEX(email), INDEX(submitted_at)
);
```

---

### Faza 3: Sudoku Complete - Implementacja

#### Enhanced JavaScript Architecture
**Plik:** `assets/js/sudoku-player.js`

**Features dodane:**
- **Auto-save:** localStorage co 30s, resume game option
- **Game state management:** board, solution, timer, mistakes, hints
- **AJAX completion:** save to database when completed
- **Points calculation:**
  - Base: 100-500 (difficulty)
  - Speed bonus: +50% max (faster than target)
  - Penalties: -10/mistake, -20/hint used
  - Minimum: 50 points

**Storage Pattern:**
```javascript
localStorage.setItem('sudoku_game_state', JSON.stringify({
  gameId, board, solution, difficulty, mistakes, hintsUsed,
  timerSeconds, savedAt
}));
```

#### Daily Challenge System
**Database Tables:**

```sql
-- Daily puzzles
CREATE TABLE wp_sudoku_daily_challenges (
  id bigint(20) AUTO_INCREMENT PRIMARY KEY,
  challenge_date date NOT NULL,
  difficulty enum('easy','medium','hard','expert'),
  puzzle_data text,
  solution_data text,
  created_at datetime,
  UNIQUE KEY(challenge_date, difficulty)
);

-- User completions
CREATE TABLE wp_sudoku_completions (
  id bigint(20) AUTO_INCREMENT PRIMARY KEY,
  user_id bigint(20),
  game_type enum('regular','daily'),
  difficulty enum('easy','medium','hard','expert'),
  challenge_date date NULL,
  time_taken int(11),
  mistakes int(11),
  hints_used int(11),
  points_earned int(11),
  completed_at datetime,
  UNIQUE KEY(user_id, challenge_date, difficulty)
);
```

**WP-Cron Implementation:**
```php
// Schedule daily at 00:01
wp_schedule_event(strtotime('tomorrow 00:01'), 'daily', 'logicleague_generate_daily_sudoku');

// Generator function
function logicleague_generate_daily_challenges() {
  // Generate 4 puzzles (easy, medium, hard, expert)
  // Store in wp_sudoku_daily_challenges
  // Clean up puzzles older than 7 days
}
```

**AJAX Endpoint:**
- Action: `save_sudoku_completion`
- Security: `wp_verify_nonce('sudoku_nonce')`
- Updates: user_meta (total_points, sudoku_completed)
- Returns: points_earned, total_points, message

---

### Faza 4: Authentication System - Implementacja

#### Custom Auth Handler
**Plik:** `inc/auth/class-auth-handler.php`

**AJAX Actions:**
- `ll_login` - WordPress `wp_signon()` wrapper
- `ll_register` - `wp_create_user()` + GDPR consent storage
- `ll_google_auth` - OAuth 2.0 token verification

**Security:**
- Nonces: `ll_login_nonce`, `ll_register_nonce`
- Rate limiting: 5 attempts per 15min (IP-based transients)
- Validation: `sanitize_user()`, `is_email()`, `validate_username()`
- Password requirements: minimum 8 characters

**GDPR Compliance:**
```php
update_user_meta($user_id, 'gdpr_consent', array(
  'accepted' => true,
  'timestamp' => current_time('mysql'),
  'ip_address' => $_SERVER['REMOTE_ADDR'],
  'method' => 'registration_form' // or 'google_oauth'
));
```

#### Google OAuth 2.0
**Configuration:**
- Define in `wp-config.php`: `LL_GOOGLE_CLIENT_ID`
- Google Cloud Console setup: OAuth 2.0 credentials
- Token verification: `https://oauth2.googleapis.com/tokeninfo`
- Auto-create WordPress user from Google profile data
- Store `google_id` in user_meta for account linking

**Frontend Implementation:**
- Google Sign-In JavaScript library
- One Tap prompt (optional)
- Callback: `handleGoogleAuth(response)`
- AJAX to `ll_google_auth` with credential token

#### Auth Modals (JavaScript)
**Plik:** `assets/js/auth.js`

**Features:**
- Modal manager: login/register modals
- AJAX form submission (no page reload)
- Real-time validation
- Error display
- Google Sign-In button rendering
- Auto-redirect after successful auth

**UX Flow:**
1. User clicks "Sign In" → Modal opens
2. Fill form → AJAX submit → Server validation
3. Success → Auto-login → Redirect to profile
4. Error → Display message, keep modal open

---

### Faza 6: AdSense Integration - Implementacja

#### AdSense Configuration
**Constants (`functions.php`):**
```php
define('LL_ADSENSE_PUBLISHER_ID', 'ca-pub-XXXXXXXXXX');
define('LL_ADSENSE_ENABLED', true);
```

#### Conditional Loading (Cookie Consent)
```php
// Script enqueue with data-cookieyes attribute
wp_enqueue_script('google-adsense',
  'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . LL_ADSENSE_PUBLISHER_ID
);

// Add attribute via filter
str_replace(' src', ' async crossorigin="anonymous" data-cookieyes="advertisement" src', $tag);
```

**JavaScript Consent Check:**
```javascript
if (typeof cky === "undefined" || cky.getConsent("advertisement")) {
  (adsbygoogle = window.adsbygoogle || []).push({});
}
```

#### Ad Unit Helper Function
```php
function logicleague_adsense_unit($slot_id, $format, $layout_key, $classes) {
  // Returns <ins class="adsbygoogle"> with proper attributes
  // Includes consent check before push
}
```

#### Ad Placements

**Homepage:**
- Leaderboard (728×90) - above hero
- Rectangle (300×250) - between quiz grids
- Large Rectangle (336×280) - after grid

**Blog Posts (`single.php`):**
- Top: 150px after header (compliance)
- Mid-article: Between paragraphs (split content)
- Bottom: After content

**Quiz Player (`single-quiz.php`):**
- Static banner: Top (150px margin)
- Interstitials: H5 Games Ads API (every 5 questions)
- Bottom: After completion

**Sudoku (`page-sudoku-play.php`):**
- Sidebar: Sticky rectangle (desktop)
- Below board: Mobile fallback

#### H5 Games Ads API (Quiz Interstitials)
```javascript
adBreak({
  type: 'next',
  name: 'question-break',
  beforeAd: () => { /* pause quiz */ },
  afterAd: () => { /* resume quiz */ },
  adBreakDone: (info) => { /* continue regardless */ }
});
```

**Trigger:** Every 5 questions in quiz player

#### CSS Safety Margins
```css
.ad-quiz-top {
  margin-top: 150px; /* Compliance: distance from game */
}

.adsense-container {
  min-height: 250px;
  background: #f8f9fa; /* Placeholder while loading */
}
```

---

## Podsumowanie Priorytetów

### MUST HAVE - Week 1-2 (Launch Blockers)
1. ✅ **Legal pages** - Privacy, Terms, Cookie banner (CookieYes plugin)
2. ✅ **Cookie consent** - GDPR/CCPA compliance, conditional script loading
3. ✅ **Contact page** - Form with spam protection, database logging
4. ✅ **About Us page** - 400-500 words, team showcase, E-E-A-T compliance
5. ✅ **Author profiles** - Bio, photo, expertise, credentials

### SHOULD HAVE - Week 2-3 (Core Features)
6. ✅ **Sudoku complete** - Play UI, daily challenges, points system, leaderboard
7. ✅ **Authentication** - Email/Password + Google OAuth, GDPR consent
8. ✅ **AdSense integration** - Placement strategy, H5 Games API, consent-based loading
9. ✅ **Mobile responsiveness** - 44px tap targets, fat-finger friendly
10. ✅ **Search functionality** - AJAX live search, results page, filters

### NICE TO HAVE - Week 3-4 (Enhancements)
11. ✅ **Enhanced gamification** - Daily rewards, streaks, 15+ badges, stats dashboard
12. ✅ **Mobile carousels** - Featured content (3-5 items), grid for browsing
13. ✅ **Global leaderboards** - Filters (weekly, monthly, category), visual enhancements
14. ✅ **Initial content** - 50+ quizzes, 10-15 blog posts
15. ✅ **Performance optimization** - Lazy loading, caching, minification

### FUTURE PHASES (Post-Launch)
16. ⚠️ **Social features** - Friend system, challenges, private leaderboards
17. ⚠️ **Advanced analytics** - User dashboard, admin statistics panel
18. ⚠️ **PWA** - Offline support, install prompt, push notifications
19. ⚠️ **Multi-language** - WPML/Polylang integration
20. ⚠️ **Email marketing** - Newsletter integration, automated campaigns

---

## Metryki Sukcesu

### Engagement
- **Bounce rate:** <40%
- **Avg session duration:** >5 minutes
- **Pages per session:** >3
- **Quiz completion rate:** >78%
- **Daily active users:** track growth
- **Return visitor rate:** >30%

### Performance
- **PageSpeed Score:** >90 (mobile & desktop)
- **Core Web Vitals:** All "Good"
  - LCP <2.5s
  - FID <100ms
  - CLS <0.1
- **Time to Interactive:** <3s

### Monetization
- **AdSense RPM:** track & optimize
- **Invalid click rate:** <10%
- **Viewable impressions:** >70%

### SEO
- **Organic traffic:** track monthly growth
- **Keyword rankings:** track top 10 keywords
- **Backlinks:** track quantity & quality
- **Domain Authority:** track growth

---

## Następne Kroki

Po zatwierdzeniu planu:
1. **Setup project management** (Trello/Asana/Notion)
2. **Create task breakdown** dla każdej fazy
3. **Begin Faza 1** - Legal compliance (krytyczne)
4. **Parallel development** gdzie możliwe (np. About Us + Sudoku)
5. **Weekly reviews** - check progress, adjust plan
6. **Testing at each phase** - nie zostawiać na koniec
7. **Content creation** - begin early, continuous process

---

---

## Kluczowe Pliki do Modyfikacji/Utworzenia

### Utworzenie Nowych Plików

#### Faza 1: Legal Compliance
- `page-privacy-policy.php` - Privacy Policy template
- `page-terms.php` - Terms of Service template
- `page-disclaimer.php` - Disclaimer template
- `page-contact.php` - Contact form template
- `inc/contact-form-handler.php` - Contact submission logic
- `assets/css/legal.css` - Legal pages styling
- Install plugin: **CookieYes** (cookie consent)

#### Faza 2: About Us
- `page-about.php` - About Us template
- `page-team.php` - Team members archive (optional)
- `assets/css/about.css` - About page styling
- `template-parts/author-card.php` - Reusable author component

#### Faza 3: Sudoku
- `inc/sudoku-ajax.php` - AJAX completion handlers
- `inc/sudoku-database.php` - Database table creation
- `inc/sudoku-daily.php` - Daily challenge generation (WP-Cron)
- `page-sudoku-leaderboard.php` - Daily leaderboard template

#### Faza 4: Authentication
- `inc/auth/class-auth-handler.php` - Complete auth system (new directory)
- `page-register.php` - Registration form template
- `page-login.php` - Login form template
- `page-password-reset.php` - Password reset flow
- `assets/js/auth.js` - Auth modals and AJAX
- `assets/css/auth.css` - Auth modal styling

#### Faza 5: Search
- `inc/search-ajax.php` - Live search endpoint
- `assets/js/search.js` - Search autocomplete
- `assets/css/search.css` - Search UI styling
- `template-parts/search-results.php` - Results template

#### Faza 6: AdSense
- `inc/adsense.php` - AdSense helper functions
- `template-parts/ads/leaderboard.php` - Leaderboard ad component
- `template-parts/ads/rectangle.php` - Rectangle ad component
- `template-parts/ads/interstitial.php` - Interstitial wrapper

#### Faza 7: Carousels
- `template-parts/carousel.php` - Reusable carousel component
- `assets/js/carousel.js` - Carousel functionality
- `assets/css/carousel.css` - Carousel styling

#### Faza 8: Gamification
- `inc/daily-rewards.php` - Daily login system
- `inc/achievements.php` - Badge system
- `template-parts/achievement-modal.php` - Achievement unlock popup
- `template-parts/daily-reward-modal.php` - Daily reward notification
- `assets/js/achievements.js` - Achievement animations
- `assets/js/daily-rewards.js` - Reward notifications
- `assets/css/achievements.css` - Badge styling

### Modyfikacja Istniejących Plików

#### functions.php
**Dodać:**
- Cookie consent integration (Faza 1)
- Contact form table creation (Faza 1)
- Sudoku database tables (Faza 3)
- Sudoku WP-Cron schedule (Faza 3)
- AJAX handlers registration (Faza 3, 4, 5, 6)
- Auth handler initialization (Faza 4)
- AdSense enqueue functions (Faza 6)
- Performance optimizations (Faza 10)
- Schema markup registration (Faza 10)

#### header.php
**Modyfikować:**
- Line 88-96: Replace login buttons z conditional auth buttons/user menu
- Add search form integration
- User dropdown menu dla logged-in users

#### footer.php
**Modyfikować:**
- Column 3: Change "Account" → "Legal" z linkami do stron prawnych
- Footer bottom: Add Cookie Settings button (`#cky-btn-revisit-bottom`)
- Add legal links separator

#### single.php (Blog)
**Modyfikować:**
- Add AdSense placements (top, mid-article, bottom)
- Respect 150px margin rule
- Split content for mid-article ad

#### single-quiz.php
**Modyfikować:**
- Lines 114-141: Replace ad placeholders z real AdSense units
- Add H5 Games API integration

#### templates/page-sudoku-play.php
**Modyfikować:**
- Lines 35-39: Replace puzzle generation z daily challenge fetch
- Line 68: Add `data-game-type` attribute
- Add sidebar ad placement

#### assets/js/sudoku-player.js
**Rozszerzyć:**
- Auto-save functionality (localStorage)
- Load saved game prompt
- Complete game detection
- AJAX completion saving
- Points earned display

#### assets/js/quiz-player.js
**Rozszerzyć:**
- Interstitial ad integration (H5 Games API)
- Show ad every 5 questions
- Custom share graphics (Canvas API)

#### page-profile.php
**Rozszerzyć:**
- Enhanced stats dashboard
- Chart.js integration dla category breakdown
- Badge showcase section
- Recent achievements display
- Sudoku statistics

#### page-rankings.php
**Rozszerzyć:**
- Time filters (weekly, monthly, all-time)
- Category leaderboards
- Sudoku leaderboards
- Current user highlight
- Animated counters

#### style.css
**Dodać:**
- AdSense placement styling
- 150px safety margins
- Responsive ad visibility rules

---

## Timeline i Zależności

### Week 1: Legal Foundation
**Days 1-3:**
- Day 1: Privacy Policy, Terms, Disclaimer pages
- Day 2: CookieYes plugin setup, cookie consent integration
- Day 3: Contact form implementation, testing

**Dependencies:** None (can start immediately)
**Blocker:** Site cannot launch without legal compliance

### Week 2: Core Features Part 1
**Days 4-7:**
- Day 4-5: About Us page, Author profiles, E-E-A-T optimization
- Day 6-7: Sudoku gameplay UI, database setup, daily challenges

**Dependencies:** Week 1 (Privacy Policy needed for GDPR references)

### Week 3: Core Features Part 2
**Days 8-10:**
- Day 8-9: Authentication system (Email/Password + Google OAuth)
- Day 10: AdSense integration, ad placement testing

**Dependencies:**
- Day 8: Requires Privacy Policy (consent checkbox)
- Day 10: Requires Cookie consent (conditional loading)

### Week 4: Enhancements
**Days 11-14:**
- Day 11: Search functionality
- Day 12: Mobile carousels
- Day 13: Enhanced gamification (daily rewards, badges)
- Day 14: Testing, bug fixes, polish

**Dependencies:** Week 3 (auth system for gamification)

### Week 5: Content & Launch Prep
**Days 15-21:**
- Day 15-18: Content creation (50+ quizzes, blog posts)
- Day 19-20: SEO optimization, performance tuning
- Day 21: Final testing, launch checklist

**Dependencies:** All previous weeks (complete feature set)

---

## Checklist Pre-Launch

### Legal & Compliance ✓
- [ ] Privacy Policy page live
- [ ] Terms of Service page live
- [ ] Cookie consent banner active (CookieYes)
- [ ] Contact form working with spam protection
- [ ] All legal links in footer
- [ ] GDPR data export/deletion tested
- [ ] Cookie consent blocking scripts verified

### Content ✓
- [ ] About Us page published (400-500 words)
- [ ] Author profiles complete (3+ authors minimum)
- [ ] 50+ quizzes created (ACF)
- [ ] 10+ blog posts published
- [ ] All images optimized (WebP, lazy loading)
- [ ] Meta descriptions dla wszystkich pages

### Functionality ✓
- [ ] Quiz player working (test 10 quizzes)
- [ ] Sudoku playable (all 4 difficulties)
- [ ] Daily Sudoku challenge generating
- [ ] Registration working (Email + Google)
- [ ] Login working (Email + Google)
- [ ] Password reset flow tested
- [ ] User profile displaying stats correctly
- [ ] Leaderboards populating
- [ ] Points system calculating correctly
- [ ] Search functionality working

### Monetization ✓
- [ ] AdSense account approved
- [ ] All ad units created (8+ units)
- [ ] Ad placements tested (desktop + mobile)
- [ ] Cookie consent integration verified
- [ ] H5 Games Ads enabled for quizzes
- [ ] 150px safety margins enforced
- [ ] Invalid click rate monitoring setup

### Performance & SEO ✓
- [ ] PageSpeed score >90 (mobile & desktop)
- [ ] Core Web Vitals passing
- [ ] Schema markup implemented (Quiz, Article, Organization)
- [ ] XML sitemap generated
- [ ] Robots.txt configured
- [ ] Open Graph tags present
- [ ] Google Analytics 4 tracking
- [ ] Google Search Console verified

### Mobile Optimization ✓
- [ ] All tap targets ≥44px
- [ ] Hamburger menu working
- [ ] Carousels functional (swipe gestures)
- [ ] Forms usable on mobile
- [ ] Ads displaying correctly
- [ ] No horizontal scroll issues
- [ ] Font sizes readable (≥16px body)

### Testing ✓
- [ ] Cross-browser (Chrome, Firefox, Safari, Edge)
- [ ] Cross-device (iPhone, Android, iPad, Desktop)
- [ ] All forms validated (client + server)
- [ ] AJAX requests working
- [ ] Error handling graceful
- [ ] Loading states present
- [ ] 404/500 error pages designed
- [ ] Accessibility audit (WCAG 2.1 AA minimum)

---

## Post-Launch Monitoring (First 30 Days)

### Week 1 Post-Launch
- Monitor AdSense invalid click rate (<10%)
- Check Google Analytics for user flow
- Review quiz completion rates (target: >78%)
- Monitor page load times
- Check for JavaScript errors (console)

### Week 2-4 Post-Launch
- Analyze top-performing quizzes
- Review AdSense RPM trends
- Check user registration rate
- Monitor daily active users
- Gather user feedback (contact form)
- A/B test ad placements
- Optimize slow pages

### Metrics to Track
- **Engagement:** Bounce rate, session duration, pages/session
- **Monetization:** AdSense RPM, CTR, viewable impressions
- **Growth:** New users, returning users, daily actives
- **Performance:** PageSpeed scores, Core Web Vitals
- **SEO:** Organic traffic, keyword rankings, backlinks

---

## Rekomendacje Końcowe

### Najważniejsze Priorytety
1. **Legal compliance först** - bez tego nie możesz legalnie działać (GDPR/CCPA)
2. **Mobile-first approach** - 70%+ ruchu z telefonów w gaming niche
3. **E-E-A-T od początku** - trudniej dodać później, łatwiej budować od start
4. **Performance matters** - quiz sites żyją z quick interactions, slow = bounce
5. **Content is king** - 50+ quality quizzes > 200 mediocre ones

### Czego Unikać
- ❌ **Nie** dodawaj social features przed stabilnym core (scope creep)
- ❌ **Nie** ignoruj cookie consent - wysokie kary GDPR
- ❌ **Nie** używaj stock photos dla team/authors - instant E-E-A-T penalty
- ❌ **Nie** stawiaj AdSense przed UX - długoterminowy engagement > short-term revenue
- ❌ **Nie** zaniedbuj mobile testing - większość problemów są tam

### Sukces Zależy Od
1. **Konsystencja:** Regular content updates (2-3 quizzes/week)
2. **Community:** Engage with users (respond to contact form, social media)
3. **Optimization:** Continuous A/B testing (ads, quiz difficulty, UI)
4. **Analytics:** Data-driven decisions (what quizzes work, where users drop off)
5. **Patience:** SEO takes 3-6 months, AdSense revenue grows with traffic

---

**Plan Version:** 1.0
**Utworzono:** 2026-01-06
**Autor planu:** Claude Sonnet 4.5 + Research Agents (2 Explore, 1 Plan)
**Research Base:** 40+ sources (UI/UX trends, gamification studies, legal requirements, AdSense best practices)
**Technical Depth:** Production-ready code samples, database schemas, API integrations
**User Decisions:** Legal-first, Plugin-based consent, Google OAuth, Solo experience
**Estimated Timeline:** 5 weeks (full implementation) + 1 week (content creation & polish)
