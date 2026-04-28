# Plan: Logo Replacement & Screenshot Gallery

## Overview

Two tasks:
1. Replace the text-based logo (letter "O" in gradient circle) with actual PNG logo images across all pages
2. Add a screenshot gallery section after the pricing section in `projects/404-slimmer/index.html`

---

## Task 1: Logo Replacement

### Current State

All 5 HTML pages currently use a text-based logo:
```html
<span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-cyan-400 to-emerald-400 text-slate-950 font-semibold shadow-lg shadow-cyan-500/30">O</span>
<div>
    <h1 class="text-base md:text-lg font-semibold tracking-tight">Overconda</h1>
    <p class="text-[11px] md:text-xs text-slate-400" data-i18n="nav.tagline">...</p>
</div>
```

### Target State

Replace with `<img>` tags using the PNG logos:
- **`images/overconda-logo-white.png`** — for dark backgrounds (primary, since all pages use `bg-slate-950`)
- **`images/overconda-logo-dark.png`** — for light backgrounds (future use)

### Files to Modify

| File | Logo Location (lines) |
|------|----------------------|
| `index.html` | Lines 14-19 |
| `projects/404-slimmer/index.html` | Lines 14-19 |
| `legal/terms/index.html` | Lines 14-19 |
| `legal/privacy/index.html` | Lines 14-19 |
| `legal/refund/index.html` | Lines 14-19 |

### Logo HTML Structure (replacement)

```html
<a href="/" class="flex items-center gap-3 hover:opacity-90 transition-opacity overconda-logo">
    <img src="/images/overconda-logo-white.png"
         alt="Overconda"
         width="160"
         height="40"
         class="h-8 md:h-10 w-auto"
         loading="eager" />
</a>
```

The logo image will replace both the "O" circle AND the text "Overconda" + tagline, since the PNG already contains the full branding.

---

## Task 2: Screenshot Gallery (404-slimmer page)

### Current State

The page at `projects/404-slimmer/index.html` has sections:
1. Header / Title
2. Features card
3. Plans & Pricing (lines 70-117)
4. Back to Home link (lines 119-124)

### Target State

Insert a new "Screenshots" section **between** the Plans & Pricing section and the Back to Home link.

### Gallery Section HTML Structure

```html
<div class="rounded-2xl border border-slate-800/80 bg-slate-950/60 p-6 md:p-8">
    <h3 class="text-lg font-semibold text-slate-100 mb-4" data-i18n="slimmer.screenshots.title">Screenshots</h3>
    <div class="screenshot-grid">
        <a href="/images/404-slimmer/Screenshot%202569-04-28%20at%2021.42.06.png" target="_blank" class="screenshot-item">
            <img src="/images/404-slimmer/Screenshot%202569-04-28%20at%2021.42.06.png" alt="404 Slimmer Screenshot 1" loading="lazy" />
        </a>
        <!-- ... repeat for all 9 images ... -->
    </div>
</div>
```

### Gallery CSS (in `css/overconda.css`)

```css
/* Screenshot Grid */
.screenshot-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.screenshot-item {
    display: block;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 1px solid rgba(51, 65, 85, 0.5);
    background: rgba(15, 23, 42, 0.6);
    transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
}

.screenshot-item:hover {
    border-color: rgba(34, 211, 238, 0.6);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.screenshot-item img {
    display: block;
    width: 100%;
    height: auto;
    aspect-ratio: 16 / 10;
    object-fit: cover;
}

@media (max-width: 768px) {
    .screenshot-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .screenshot-grid {
        grid-template-columns: 1fr;
    }
}
```

### Logo CSS (in `css/overconda.css`)

```css
/* Overconda Logo */
.overconda-logo img {
    display: block;
    height: 2.5rem;
    width: auto;
}

@media (min-width: 768px) {
    .overconda-logo img {
        height: 2.5rem;
    }
}
```

---

## Task 3: CSS File Creation

Create a new file `css/overconda.css` containing:
1. Logo styles (`.overconda-logo`)
2. Screenshot gallery styles (`.screenshot-grid`, `.screenshot-item`)
3. Any future shared styles

### CSS File Link

Add to the `<head>` of all 5 HTML files:
```html
<link rel="stylesheet" href="/css/overconda.css">
```

---

## Implementation Order

1. Create `css/` directory and `css/overconda.css` with all styles
2. Modify `projects/404-slimmer/index.html`:
   - Add CSS link in `<head>`
   - Replace logo with `<img>` tag
   - Add screenshot gallery section after pricing
   - Add i18n keys for gallery title
3. Modify `index.html`:
   - Add CSS link in `<head>`
   - Replace logo with `<img>` tag
4. Modify `legal/terms/index.html`, `legal/privacy/index.html`, `legal/refund/index.html`:
   - Add CSS link in `<head>`
   - Replace logo with `<img>` tag

---

## i18n Keys to Add (404-slimmer page)

Add to the `I18N` object in the script:

```js
// In en:
slimmer: {
    // ... existing keys ...
    screenshots: { title: 'Screenshots' }
}

// In th:
slimmer: {
    // ... existing keys ...
    screenshots: { title: 'ภาพตัวอย่าง' }
}
```
