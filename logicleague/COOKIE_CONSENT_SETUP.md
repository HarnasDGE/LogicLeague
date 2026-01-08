# Cookie Consent Setup Instructions

## CookieYes Plugin Installation & Configuration

### Step 1: Install CookieYes Plugin

1. Log in to WordPress Admin Dashboard
2. Navigate to **Plugins → Add New**
3. Search for "**CookieYes**"
4. Click **Install Now** on "Cookie Notice & Compliance for GDPR / CCPA"
5. Click **Activate**

**Plugin URL:** https://wordpress.org/plugins/cookie-law-info/

---

### Step 2: Basic Configuration

After activation, you'll be redirected to CookieYes setup wizard:

#### 2.1 Select Your Region
- Choose: **Multiple Regions** (GDPR + CCPA support)
- Or select specific region if your audience is localized

#### 2.2 Cookie Scanning
- Allow CookieYes to scan your website for cookies
- This will automatically detect cookies from:
  - WordPress
  - Google Analytics
  - Google AdSense
  - Any other plugins

#### 2.3 Banner Design
**Customize banner to match LogicLeague branding:**

- **Layout:** Bottom Bar (recommended for mobile-first)
- **Primary Color:** `#6366F1` (LogicLeague purple)
- **Button Color:** `#6366F1`
- **Text Color:** `#1F2937` (dark gray)
- **Background:** `#FFFFFF` (white)

---

### Step 3: Cookie Categories Configuration

Navigate to **CookieYes → Cookie Categories**

#### Necessary (Always Enabled)
**Pre-configured cookies:**
- WordPress session cookies
- User authentication
- Security nonces
- CSRF tokens

**Note:** These cannot be disabled by users (required for site functionality)

#### Functional
**Add these cookies:**
- User quiz progress (localStorage)
- User preferences
- Language settings

**Description:**
> "These cookies help provide enhanced functionality like saving your quiz progress and remembering your preferences."

#### Analytics
**Add Google Analytics 4:**
- Domain: `google-analytics.com`
- Cookie Pattern: `_ga, _ga_*, _gid`

**Description:**
> "We use Google Analytics to understand how visitors interact with our website, which helps us improve your experience."

#### Advertisement
**Add Google AdSense:**
- Domain: `googlesyndication.com`, `doubleclick.net`
- Cookie Pattern: `IDE, _gcl_*, test_cookie`

**Description:**
> "These cookies are used by Google AdSense to serve relevant advertisements and measure ad performance."

---

### Step 4: Banner Content Configuration

Navigate to **CookieYes → Settings → Banner**

#### Banner Message
```
We use cookies to improve your experience, analyze traffic, and serve personalized ads. Choose your preferences below.
```

#### Button Configuration

**Accept All Button:**
- Text: "Accept All"
- Style: Primary (filled)
- Color: `#6366F1`

**Reject All Button:**
- Text: "Reject All"
- Style: Secondary (outline)
- Color: `#6366F1`
- ⚠️ **IMPORTANT:** Enable "Equal Prominence" (GDPR requirement)

**Cookie Settings Button:**
- Text: "Cookie Preferences"
- Position: Left side of banner
- Style: Link

---

### Step 5: Cookie Preferences Modal

Configure the detailed cookie settings modal:

#### Header
- Title: "Cookie Preferences"
- Description: "Manage your cookie consent preferences"

#### Categories Display
- ☑ Show category descriptions
- ☑ Show cookie tables (list of cookies)
- ☑ Allow users to enable/disable categories

#### Footer Buttons
- **Save Preferences** (primary)
- **Accept All** (secondary)
- **Reject All** (tertiary)

---

### Step 6: Advanced Settings

Navigate to **CookieYes → Settings → Advanced**

#### Global Privacy Control (GPC)
- ☑ **Enable GPC Signal Detection**
- Auto-reject non-essential cookies when GPC signal detected

#### Consent Logging
- ☑ **Enable consent logging** (required for GDPR compliance)
- Stores: User ID, timestamp, consented categories, IP address

#### Cookie Banner Behavior
- **Show banner:** On first visit only
- **Re-show banner:** After 12 months (CCPA requirement)
- **Block scripts:** Until consent given

#### Script Blocking
Configure which scripts to block until consent:

**Analytics Scripts:**
```javascript
// Google Analytics
data-cookieyes="analytics"
```

**Advertisement Scripts:**
```javascript
// Google AdSense
data-cookieyes="advertisement"
```

---

### Step 7: Script Integration

CookieYes will automatically add the banner script to your site.

**Manual verification in `functions.php`:**

The plugin handles script blocking automatically via `data-cookieyes` attribute.

For custom scripts, add this attribute:

```php
// Example: Block Google Analytics until consent
wp_enqueue_script('google-analytics', $ga_url);
add_filter('script_loader_tag', function($tag, $handle) {
    if ('google-analytics' === $handle) {
        $tag = str_replace(' src', ' data-cookieyes="analytics" src', $tag);
    }
    return $tag;
}, 10, 2);
```

---

### Step 8: Test Cookie Consent

#### Testing Checklist:

1. **Open site in incognito/private window**
2. **Verify banner appears** on first visit
3. **Test "Reject All" button:**
   - Analytics scripts should NOT load
   - AdSense scripts should NOT load
   - Check browser console for blocked scripts
4. **Test "Accept All" button:**
   - All scripts should load
   - Check cookies in DevTools → Application → Cookies
5. **Test "Cookie Preferences":**
   - Modal opens with category toggles
   - Can enable/disable individual categories
   - "Save Preferences" applies settings
6. **Test footer "Cookie Settings" button:**
   - Opens cookie preferences modal
   - Can change settings after initial consent
7. **Verify consent logging:**
   - Check **CookieYes → Consent Logs**
   - Should show user consents with timestamps

---

### Step 9: GDPR/CCPA Compliance Verification

#### GDPR Checklist (European Users):
- ✅ Banner shown before any non-essential cookies
- ✅ Equal prominence for Accept/Reject buttons
- ✅ No pre-selected checkboxes (opt-in, not opt-out)
- ✅ Clear cookie descriptions
- ✅ Easy access to change preferences (footer link)
- ✅ Consent logging enabled
- ✅ Privacy Policy link visible

#### CCPA Checklist (California Users):
- ✅ "Do Not Sell My Personal Information" option
- ✅ Privacy Policy updated within 12 months
- ✅ Cookie banner re-shown after 12 months
- ✅ GPC signal support enabled
- ✅ User can opt-out easily

---

### Step 10: Integration with Privacy Policy

Ensure your Privacy Policy (page-privacy-policy.php) includes:

1. **Cookie Policy link** ✅ (Already added)
2. **"Cookie Settings" button** ✅ (Already added)
3. **List of cookies used** ← Add this section:

**Add to Privacy Policy:**

```markdown
### Cookies We Use

We use the following types of cookies:

**Necessary Cookies:**
- WordPress session cookies (wp_*)
- Authentication cookies (wordpress_logged_in_*)
- Security tokens

**Functional Cookies:**
- Quiz progress (localStorage)
- User preferences

**Analytics Cookies:**
- Google Analytics (_ga, _gid)
- Used to understand site usage and improve user experience

**Advertisement Cookies:**
- Google AdSense (IDE, test_cookie)
- Used to display relevant ads and measure performance

You can manage your cookie preferences at any time using the "Cookie Settings" button below.
```

---

### Troubleshooting

#### Banner not showing:
1. Check if CookieYes plugin is activated
2. Clear browser cache and cookies
3. Test in incognito window
4. Check JavaScript console for errors

#### Scripts still loading after "Reject All":
1. Ensure scripts have `data-cookieyes` attribute
2. Check CookieYes → Settings → Script Blocker
3. Verify cookie category assignments

#### Cookie Settings button not working:
1. Ensure button ID is `cky-btn-revisit` or `cky-btn-revisit-bottom`
2. CookieYes plugin must be active
3. Check browser console for JavaScript errors

#### Consent logs not saving:
1. Navigate to CookieYes → Settings → Advanced
2. Enable "Consent Logging"
3. Check database table: `wp_cookieyes_log`

---

### Additional Resources

**CookieYes Documentation:**
https://www.cookieyes.com/documentation/

**GDPR Compliance Guide:**
https://gdpr.eu/cookies/

**CCPA Compliance Guide:**
https://oag.ca.gov/privacy/ccpa

**Google AdSense Cookie Policy:**
https://policies.google.com/technologies/ads

---

### Configuration Complete ✅

Once you've completed all steps above:

1. ✅ CookieYes plugin installed and configured
2. ✅ Cookie categories defined (Necessary, Functional, Analytics, Advertisement)
3. ✅ Banner design matches LogicLeague branding
4. ✅ GDPR/CCPA compliance verified
5. ✅ Footer cookie settings button functional
6. ✅ Privacy Policy updated with cookie information
7. ✅ Consent logging enabled
8. ✅ Script blocking configured

**Your website is now legally compliant for GDPR and CCPA! 🎉**

---

## Next Steps

After Cookie Consent is configured, proceed with:

- **Phase 2:** About Us & Author Profiles
- **Phase 3:** Sudoku Complete Implementation
- **Phase 4:** Authentication System

Refer to `IMPLEMENTATION_PLAN.md` for full roadmap.
