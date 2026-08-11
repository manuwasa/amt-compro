# Admin Guide

This guide covers everything you need to manage the AMT Group website through the admin panel.

## Table of Contents

1. [Logging In](#logging-in)
2. [Dashboard](#dashboard)
3. [Role Permissions](#role-permissions)
4. [Companies (Our Services)](#companies-our-services)
5. [Products](#products)
6. [Articles (News & Artikel)](#articles-news--artikel)
7. [Contact Messages](#contact-messages)
8. [Users](#users)
9. [Group Settings](#group-settings)
10. [Tips & Best Practices](#tips--best-practices)

---

## Logging In

Go to `https://yourdomain.com/admin` — you will be redirected to the login page automatically.

Enter your email and password. If you forget your password, use the **Forgot Password** link on the login page (requires mail to be configured in Group Settings).

After logging in you will land on the **Admin Dashboard**. There is no public sign-up page — new accounts are created by a superadmin under **Users**.

---

## Dashboard

The dashboard shows a quick summary of the site:
- Total Companies
- Total Products (across companies and global)
- Total Articles
- Unread contact messages

Use the **sidebar** on the left to navigate between sections. "Group Settings" and "Users" only appear if you are logged in as a Superadmin.

---

## Role Permissions

| Section | Admin | Superadmin |
|---------|:-----:|:----------:|
| Dashboard | ✓ | ✓ |
| Companies | ✓ | ✓ |
| Products | ✓ | ✓ |
| Articles | ✓ | ✓ |
| Contact Messages | ✓ | ✓ |
| Group Settings | — | ✓ |
| Users | — | ✓ |

---

## Companies (Our Services)

Navigate to **Companies** in the sidebar. Each Company is one of AMT Group's subsidiaries — this is what "Our Services" shows on the public site, and each one gets its own profile page.

### Creating a Company

1. Click **New Company**.
2. Fill in the fields:
   - **Name** — e.g. "PT ABC Jaya Sejahtera". Required.
   - **Slug** — the URL segment (e.g. `pt-abc-jaya-sejahtera`). Leave blank to auto-generate from the name.
   - **Logo** / **Cover Image** — JPEG, PNG, or WebP. Logo max 2 MB, cover max 4 MB.
   - **Biography** — the full profile shown on this company's page, using the rich text editor (see [Rich Text Editor](#rich-text-editor) below). Include history, vision/mission, and anything else worth telling visitors.
   - **Address / Phone / WhatsApp Number / Email** — this company's own contact details, shown on its profile page (separate from AMT Group's own contact info in Group Settings — see [Group Settings](#group-settings)). WhatsApp number should be digits only with country code, e.g. `6281234567890`.
   - **Sort Order** — controls the order companies appear on the homepage and "Our Services" page. Lower numbers appear first.
   - **Visible on the public site** — uncheck to hide a company everywhere on the public site without deleting it.
   - **SEO** — Meta Title/Description for this company's page. Both fall back to Name/Biography if left blank; a live character counter warns if you're over the recommended length.
3. Click **Save Company**.

### Managing a Company's Products

From the Companies list, click the product count (e.g. "6 products") next to a company, or from its edit page click **Manage \[Company\]'s products**. See [Products](#products) below.

### Deleting a Company

You cannot delete a company that still has products — remove or reassign its products first. This is a deliberate safeguard against accidentally orphaning product data.

---

## Products

Navigate to **Products** in the sidebar. Unlike Companies and Articles, Products has its own dedicated section rather than only living inside a company, because not every product belongs to a subsidiary — some are "global," available across AMT Group as a whole.

Use the filter pills at the top (All / each company) to narrow the list, or arrive pre-filtered by clicking a product count link from the Companies list.

### Creating a Product

1. Click **New Product**.
2. Fill in the fields:
   - **Company** — choose a subsidiary, or leave it as "— Global (not linked to any company) —" for a product that belongs to AMT Group as a whole rather than one subsidiary. If you arrived here via a specific company's product list, this is pre-selected for you.
   - **Brand** — e.g. "Befriend". Optional.
   - **Category** — free-text label, e.g. "Tire". Optional.
   - **Name** — e.g. "BF918". Required.
   - **Slug** — leave blank to auto-generate from the name.
   - **Description** — plain text (not rich text).
   - **Main Image** — JPEG, PNG, or WebP, max 2 MB.
   - **Gallery** — optional additional images; uploading new ones replaces the entire existing gallery.
   - **Sort Order** / **Visible on the public site** — same as Companies.
   - **SEO** — Meta Title/Description, falling back to Name/Description.
3. Click **Save Product**.

A global product shows up in the public product catalog labeled with the AMT Group name instead of a subsidiary, and its page links back to nothing in particular (no "From \[Company\]" link) since it isn't tied to one.

Product pages are often the site's best long-tail SEO opportunity (e.g. someone searching the exact model name) — fill in Description and SEO fields even for products that feel "obvious."

---

## Articles (News & Artikel)

Navigate to **Articles** in the sidebar.

### Creating an Article

1. Click **New Article**.
2. Fill in the fields:
   - **Title** — required.
   - **Slug** — leave blank to auto-generate from the title.
   - **Category** — free-text label, e.g. "Tips", "Company News".
   - **Tags** — comma-separated, e.g. `sni, ban, keselamatan`. Shown on the article page and useful for grouping related content.
   - **Excerpt** — short summary shown on the article listing card and used as the fallback meta description.
   - **Content** — full article body using the rich text editor.
   - **Featured Image** — JPEG, PNG, or WebP, max 4 MB.
   - **Featured Image Alt Text** — describes the image for accessibility and image search; falls back to the Title if left blank, but writing a real description helps SEO more.
   - **Published** — check to make the article visible on the public site. Leave unchecked to save as a draft.
   - **Published At** — defaults to the moment you first check Published if left blank.
   - **SEO** — Meta Title/Description, falling back to Title/Excerpt.
3. Click **Save Article**.

### Rich Text Editor

The Biography (Companies), Content (Articles), and Group Biography (Settings) fields all use the same **Quill** editor:

| Button | Action |
|--------|--------|
| H1 / H2 / H3 | Heading levels |
| **B** | Bold |
| *I* | Italic |
| U | Underline |
| S | Strikethrough |
| Ordered / Bullet list | Numbered / unordered list |
| `" "` | Blockquote |
| Link | Insert a hyperlink |

Use heading levels (H2/H3) inside long biographies and articles rather than making everything bold — it reads better and helps search engines understand the page's structure.

### URL / Slug

The article URL is generated from the title (e.g. "My First Post" → `/articles/my-first-post`). Changing the title after publishing does **not** change the slug once set — the slug field is editable independently if you need to change it deliberately, but avoid doing so on a published article since it will break any external links or bookmarks pointing at the old URL.

---

## Contact Messages

Navigate to **Messages** in the sidebar.

All messages submitted via the public Contact Us form are stored here. Unread messages are highlighted.

- Click **View** to read the full message and mark it as read.
- Click **Reply by Email** to open your email client addressed to the sender.
- Click **Delete** to remove a message permanently — there is no recycle bin.

If a real person's message never shows up here, check that they weren't blocked by the spam filter (a hidden field bots tend to fill in but real visitors never see) — legitimate messages are never affected by this, so this should be rare.

---

## Users

Navigate to **Users** in the sidebar. *(Superadmin only.)*

### Creating a User

1. Click **New User**.
2. Enter name, email, and password.
3. Choose a **Role**:
   - **Admin** — can manage Companies, Products, Articles, and view Messages.
   - **Superadmin** — full access, including Group Settings and other Users.
4. Click **Save User**.

### Editing a User

Click **Edit** next to the user. Leave the password field blank to keep their existing password.

### Deleting a User

Click **Delete** next to the user. You cannot delete your own account from this screen.

> **Warning:** Be careful when assigning the Superadmin role — superadmins have access to Group Settings, including SMTP mail credentials.

---

## Group Settings

Navigate to **Group Settings** in the sidebar. *(Superadmin only.)* This controls AMT Group's own identity and the homepage — separate from any individual subsidiary's own profile under Companies.

### Group Identity

| Field | Description |
|-------|-------------|
| Group Name | Shown in the browser title, navbar, and footer. |
| Tagline | Short slogan shown under the group name. |
| Logo | Shown in the navbar and used as the default social-share image. |
| Favicon | Browser tab icon. |

### Homepage Content

| Field | Description |
|-------|-------------|
| Group Biography | The main "About AMT Group" content on the homepage, using the rich text editor. |
| Portfolio Section Intro | Short text shown above the grid of subsidiary companies on the homepage. |

### Group Contact & Social

| Field | Description |
|-------|-------------|
| Group Email / Phone / WhatsApp Number | Shown on the group-level Contact Us page — separate from each subsidiary's own contact details under Companies. |
| Instagram URL / Tiktok URL | Shown in the footer, Contact Us page, and included in the homepage's `Organization` structured data for search engines. |

### Default SEO

| Field | Description |
|-------|-------------|
| Default Meta Description | Used as a fallback wherever a more specific page description isn't set. |
| Default Meta Keywords | Comma-separated. |

### SMTP

Once **Group Email** (above) and these fields are filled in, every Contact Us submission emails a notification — with the sender's name, contact details, and message — to the Group Email address, in addition to always being saved in **Messages**. Leave Group Email blank to disable the email and rely on checking Messages instead.

| Field | Description |
|-------|-------------|
| Mailer | `smtp` for a standard mail server, `log` to disable sending (logs to file instead — useful for testing). |
| Host | Your mail server hostname (e.g. `smtp.gmail.com`). |
| Port | Usually `587` (TLS) or `465` (SSL). |
| Encryption | `tls` (recommended) or `ssl`. |
| Username / Password | Your SMTP login. |
| From Address / From Name | The "From" identity on outgoing emails — most providers require this to match Username. |

Click **Save Settings** after making changes — mail settings take effect immediately on the next request.

#### Settings by provider

| Provider | Host | Port | Encryption | Notes |
|---|---|---|---|---|
| Google Workspace / Gmail | `smtp.gmail.com` | 587 | tls | Password must be an [App Password](https://myaccount.google.com/apppasswords), not the login password — requires 2-Step Verification enabled first. |
| Zoho Mail | `smtp.zoho.com` (or `smtppro.zoho.com` on paid plans) | 587 | tls | App-specific password if 2FA is on. |
| Microsoft 365 / Outlook | `smtp.office365.com` | 587 | tls | App password if MFA is on. |
| Hosting provider's own email (cPanel, etc.) | usually `mail.yourdomain.com` — check your host's control panel | 587 (or 465 with ssl) | tls / ssl | Avoid port 25, it's commonly blocked. Shared hosting sometimes throttles outbound mail. |

**Common pitfalls:**
- **From Address must match Username** — most providers reject or flag mail otherwise.
- **Port/encryption pairing** — `587` goes with `tls`, `465` goes with `ssl`. Mixing them is the most common cause of a silent connection failure.
- **Two-factor accounts** — if the mailbox has 2FA/MFA on, the regular password won't work for SMTP; generate an app-specific password instead (Google, Microsoft, and Zoho all support this).
- **If the mail server is slow or unreachable**, the contact form still saves the message (nothing is ever lost) but visitors may wait a few seconds before the confirmation page loads — worth testing once after entering real credentials.

**To verify it's working:** submit a real message through the public Contact Us page and confirm both (a) it appears in **Messages**, and (b) an email arrives at the Group Email address.

---

## Tips & Best Practices

- **Draft before publishing** — create articles as drafts (uncheck Published) to review them before they go live.
- **Sort order** — use multiples of 10 (10, 20, 30...) so you can insert items between existing ones without renumbering everything.
- **Images** — compress images before uploading. Tools like [Squoosh](https://squoosh.app) or [TinyPNG](https://tinypng.com) reduce file size significantly without visible quality loss.
- **Alt text matters** — always fill in Featured Image Alt Text on articles; it helps both accessibility and image search.
- **Fill in every subsidiary** — CV A, CV B, and CV C are seeded with placeholder text ("Profil perusahaan akan segera diperbarui.") so the site launches functional. Replace that placeholder content — and gather real product data for Deolus, which wasn't published with specific models on the old site — as soon as it's available.
- **Test your contact form** — after configuring SMTP, submit a test message from the Contact Us page to confirm it's received.
- **Backups** — the database is MySQL; ask your hosting provider to confirm automated backups are running, since all site content (companies, products, articles, uploaded media) now lives in the database and `storage/app/public`, not hand-coded into template files.
