# wmarka clean

[Русский](README.md) · [Қазақша](README.kk.md) · **English**

A clean starter template for Joomla 5 and 6 built on UIkit 3 — **with no settings at all**. The page layout lives in `index.php`, image sizes in two layouts, styling in one stylesheet. Whatever you want to change, you change in files, not in the administrator.

It is a clean build of [wmarka](https://github.com/bsakhanov/wmarka): the same positions and the same approach to blocks, tables and images, but without a panel of a hundred-plus options, without its own SEO engine and without token-driven mega menus. It is meant for developers who build a site by hand and want to see every line of markup.

| | wmarka clean | wmarka |
|---|---|---|
| Settings in the administrator | none | 120+ options, menu item options |
| Thumbnail sizes | in `intro_image.php` and `full_image.php` | in the template style |
| Blog, tags, article | fixed layouts | chosen in settings |
| SEO (canonical, JSON-LD) | Joomla core plugins | own engine |
| Mega menu | no, plain dropdowns | `wm-mega…` tokens |
| PHP files | 48 | 180+ |

## Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [First run, step by step](#first-run-step-by-step)
4. [Module positions](#module-positions)
5. [Block positions](#block-positions)
6. [Module styles](#module-styles)
7. [Images](#images)
8. [What is overridden](#what-is-overridden)
9. [Making it your own](#making-it-your-own)
10. [Moving from wmarka](#moving-from-wmarka)
11. [File structure](#file-structure)
12. [Tested](#tested)
13. [History](#history)
14. [Thanks](#thanks)
15. [Licence](#licence)

## Requirements

- **Joomla 5.x or 6.x.** Tested on 6.2.0.
- **PHP 8.1 or later** for Joomla 5, **8.3 or later** for Joomla 6 (a core requirement). The syntax of every file is checked on PHP 8.5.
- **The JUImage library** (Joomla! Ukraine) crops and compresses thumbnails. Without it the template works but shows original images.
- UIkit 3.25.25 ships with the template; nothing to install separately.

## Installation

1. Download `tpl_wmarka_clean-1.0.0.zip` from the [releases](https://github.com/bsakhanov/wmarka-clean/releases) page.
2. Joomla administrator → **System → Install Extensions → Upload Package File** → choose the archive.
3. **System → Site Template Styles** → click the star of "wmarka_clean - Default" to make it the default style.
4. Install JUImage if your site does not have it yet: the `lib_juimage` archive is in the [JUImage](https://github.com/Joomla-Ukraine/JUImage) releases and inside the full [wmarka](https://github.com/bsakhanov/wmarka/releases) package. The template finds the library by itself.

> There is nothing to configure in the style: it has only the standard "Details" and "Menu Assignment" tabs.

## First run, step by step

**1. Menu.** Create the main menu (**Menus → Manage → New**) and its items. The item marked with a star is the home page.

**2. Menu module in the header.** **Content → Site Modules → New → Menu**: pick your menu, position `navbar-right`, module style "Default", "Show Title" off. In navbar positions the menu is horizontal, with dropdowns for child items. On phones the same menu appears in the mobile panel behind the three-line button.

**3. Logo.** Without a module, the header shows the site name from **System → Global Configuration → Site Name**. For an image, create a "Custom" module in the `logo` position (default style, title hidden), for example:

```html
<a class="uk-navbar-item uk-logo" href="/"><img src="/images/logo.svg" width="160" height="40" alt="Site name"></a>
```

**4. Breadcrumbs.** Put a "Breadcrumbs" module in `breadcrumb`.

**5. Sidebars.** Modules go to `sidebar-a` (left) and `sidebar-b` (right). The content column narrows by itself when a sidebar is not empty; each sidebar takes a quarter of the width.

**6. Home page blocks.** A slider goes to `slider`, sections above the content to `block-a`, `block-b`, below it to `block-c` … `block-k`. See [Block positions](#block-positions) for how they are laid out.

**7. Footer.** Three columns — `footer-left`, `footer-center`, `footer-right`; the copyright row — `footer`. The template writes the year and the site name itself.

**8. Site icons.** Put `favicon.svg`, `favicon.ico` and `apple-touch-icon.png` into `media/templates/site/wmarka_clean/images/favicon/` — or into the same folder of your child template. The template outputs the files it finds.

**9. Search.** You need a "Smart Search" menu item (a hidden menu is fine) and a "Smart Search" module in any position. Update the index with **Components → Smart Search → Index** or `php cli/joomla.php finder:index`.

## Module positions

| Position | Where on the page |
|---|---|
| `toolbar-left`, `toolbar-right` | dark strip above the header (from 960 px) |
| `logo` | instead of the site name in the header |
| `navbar-center`, `navbar-right` | navbar: centre and right (menu) |
| `iconnav` | icons on the right of the navbar |
| `breadcrumb` | breadcrumbs under the header |
| `adver-top`, `slider`, `block-a`, `block-b` | block positions above the content |
| `main-top`, `main-bottom` | above and below the component, in the content column |
| `sidebar-a`, `sidebar-b` | left and right sidebars |
| `block-c` … `block-k` | block positions below the content |
| `footer-left`, `footer-center`, `footer-right` | three footer columns |
| `footer` | copyright row, right side |
| `offcanvas-menu`, `offcanvas` | mobile panel: menu and modules below it |
| `debug` | the very bottom of the page |

All thirty positions are declared in the manifest and listed in the module manager.

## Block positions

`adver-top`, `slider` and `block-a` … `block-k` follow one rule.

- **If every module in the position uses the "blank" style,** the template draws nothing around them and the modules run full width. That is how covers, video blocks and subscription strips are made: the module brings its own section.
- **Otherwise** the template wraps the position itself: a `uk-section` with a container and a grid. One column per module, up to four; one column on phones, two from 640 px. Every second block position on a page gets a muted background.
- **A module class suffix** `uk-width-…` overrides the column width. Two modules with `uk-width-2-3@m` and `uk-width-1-3@m` split the row into two thirds and one third.

A full-width module — a "Custom" module with the `blank` style:

```html
<section class="uk-section uk-section-primary uk-light">
  <div class="uk-container">
    <h2>Newsletter</h2>
    <p>Once a week — the week's essentials.</p>
  </div>
</section>
```

## Module styles

Chosen in the module: **Advanced → Module Style**.

| Style | Looks like |
|---|---|
| `clean` | title with a bullet and the content; default in sidebars, blocks and footer |
| `card` | a white UIkit card with a title |
| `blank` | no wrapper at all; full width in a block position |

## Images

The sizes are written directly in the layouts — this is the only place they live:

| Layout | Sizes | Used for |
|---|---|---|
| `html/layouts/joomla/content/intro_image.php` | **720 × 405** and **360 × 203** | blog, featured and tag cards; module lists |
| `html/layouts/joomla/content/full_image.php` | **1200 × 675** and **720 × 405** | the article |

Both pairs are 16 : 9, centre-cropped, WebP, quality 80. The browser picks a file from `srcset` by slot width and screen density. Thumbnails are cached in the `img/` folder at the site root.

No intro image — the card uses the full one. No JUImage or no file — the original is shown.

**Changing the sizes.** Copy the layout into a child template (see [below](#making-it-your-own)) and edit one line. For 4 : 3 thumbnails in `intro_image.php`:

```php
echo T::img($src, [[800, 600], [400, 300]], $alt, '(min-width: 960px) 360px, (min-width: 640px) 50vw, 100vw', $class);
```

Then clear the `img/` folder: new thumbnails are made on the first page view.

## What is overridden

**Articles**

- **Article.** The category on a line above the title, an `H1` title, the info line (author, date, hits), the full image, the text. Tables in the text stack on phones with the column name next to each value; a table with merged cells scrolls inside its own box. Then tags as pills and article navigation. The menu item heading is printed only when the item points to this very article.
- **Category blog and featured.** Leading articles as a wide card with the image on the left half; the rest in a grid: one column on phones, two from 640 px, three from 960 px. Then links to more articles and pagination.
- **Category list.** A table: title, date, hits.

**Tags**

- **Tag** — cards in a grid, as in the blog.
- **All tags** — pills with description and hits.

**Everything else**

- **Contact** — photo, name, position, address, email form. **Contact category** — cards with round photos.
- **Smart Search** — a search field with an icon and results with thumbnails.
- **Login and logout** — forms in a card.
- **Modules:**
  - menu (horizontal in the navbar, vertical elsewhere);
  - Articles, Latest, Most Read, Articles - Category, Related Articles — a list with thumbnails;
  - Popular Tags — as pills;
  - Smart Search, Login, Breadcrumbs.
- **Shared layouts** — the info line, tags, Read more, UIkit pagination.
- **Pages:** error, offline and component-only.

Joomla core options — whether to show the date, author, category or tags, how many leading and intro articles — work as usual: they are Joomla settings, not template settings.

Core markup the template does not override (registration, password reset, profile, contact form) is styled UIkit-like by `media/css/clean.css`.

## Making it your own

**Edit a child template, not the template itself.** An update overwrites the template's files but leaves the child template alone.

1. **System → Site Templates → wmarka_clean → Create Child Template.** Joomla creates `templates/wmarka_clean_<name>/` with a manifest and the media folder `media/templates/site/wmarka_clean_<name>/`.
2. Make the child template's style the default.
3. Copy into the child template only what you change. Anything it does not have, Joomla takes from the parent.

| To change | Copy this file into the child template |
|---|---|
| thumbnail sizes | `html/layouts/joomla/content/intro_image.php`, `full_image.php` |
| the card | `html/layouts/clean/card.php` |
| blog columns (`uk-child-width-1-3@m`) | `html/layouts/clean/blog.php` |
| the article | `html/com_content/article/default.php` |
| header, footer, block order | `index.php` |
| colours, spacing, the quote | `media/css/clean.css` → into the child media folder as `css/clean.css` |

**UIkit colours and fonts.** The whole UIkit theme is `media/css/uikit.min.css`. Build your own theme as the UIkit documentation describes (Less or Sass variables) and put `uikit.min.css` into the child media folder: the template loads it instead of the standard one.

**Your own script.** Put the file into `media/templates/site/<child>/js/` and load it in your `index.php`, e.g. `$wa->registerAndUseScript('my', 'media/templates/site/<child>/js/my.js', [], ['defer' => true])`.

## Moving from wmarka

- **Modules using wmarka layouts** (`wm-cards`, `wm-media`, `wm-feed`, `wm-slider` of the Articles module) keep working: clean has layouts with the same names. Without them Joomla would loop on the module's default layout.
- **Menu items with alternative layouts** like `wmarka:wm-team` work while wmarka is installed. If you remove wmarka, switch those items to standard layouts.
- **wmarka style settings** — contacts, SEO, thumbnail sizes — are not carried over: clean has none. Canonical and Schema.org markup come from the core "System - SEF" (Site Domain field) and "System - Schema.org" plugins.
- **Token mega menus** become a plain menu with dropdowns.

## File structure

```
templates/wmarka_clean/
├── index.php              page layout
├── component.php          component only (print, modals)
├── error.php              error page
├── offline.php            site offline
├── joomla.asset.json      UIkit and template styles
├── php/T.php              thumbnails, <img>, tables, block positions
├── html/
│   ├── layouts/joomla/content/   intro_image, full_image, info_block, tags, readmore
│   ├── layouts/joomla/pagination/links.php
│   ├── layouts/clean/            card, blog, list
│   ├── layouts/chromes/          clean, card, blank
│   ├── com_content/  com_tags/  com_contact/  com_finder/  com_users/
│   └── mod_menu/  mod_articles*/  mod_related_items/  mod_tags_popular/  mod_login/  mod_finder/  mod_breadcrumbs/
└── language/ru-RU, en-GB
media/templates/site/wmarka_clean/
├── css/uikit.min.css, clean.css
├── js/uikit.min.js, uikit-icons.min.js
└── images/favicon/
```

## Tested

On a clean Joomla 6.2.0 with the "Vestnik" demo site from the wmarka package:

- 21 pages return 200, a missing address returns 404, no PHP messages;
- 375 and 1366 px, with and without JavaScript: no page is wider than the screen, no JavaScript errors;
- JUImage produced thumbnails of exactly the given sizes: 720 × 405, 360 × 203, 1200 × 675;
- the syntax of all 48 PHP files is checked on PHP 8.5.11.

## History

**J!Blank.** It started with J!Blank by the JBZoo team: a template that generates no styles and leaves every decision to the developer.

**wmarka 1.0 (July 2023) — 2.0.7 (December 2025).** An "almost clean template" on UIkit 3: no settings in the administrator, configuration in code (`php/init.php` from J!Blank), organisation data in language overrides in three languages, blocks as separate partials, positions and module styles after the Master3 template. Updates wiped the edits made in code, and positions were not declared in the manifest — both lessons are taken into account in clean.

**wmarka 3.0 (March 2026) and 4.x (October 2026).** The template grew into a "full" one: settings in the administrator, its own SEO engine, mega menus, news presentation, a demo package.

**wmarka clean 1.0.0 (October 2026).** Back to the cleanness of 2.x without its traps: everything in files, but positions are declared, edits live in a child template, and from 4.x it takes what needs no settings — the block rule, phone-friendly tables, JUImage thumbnails.

## Thanks

This template stands on many people's shoulders. Thank you:

- **The Joomla Project** and Open Source Matters — for the core layouts every override starts from, and for Joomla itself.
- **YOOtheme** — for UIkit, which carries all the markup.
- **Denys Nosov and the Joomla! Ukraine team** — for the JUImage library.
- **Denis Smetannikov (SmetDenis) and the JBZoo team** — for J!Blank, where wmarka began.
- **The authors of the Master3 template** — for the position scheme and module styles that came into wmarka.
- **Aleksey Morozov (AlekVolsk) and Sergey Tolkachyov** — for the Blank Page component (com_blank); Aleksey also for the UIkit grid module whose layouts lived in early versions.
- **Authors of layouts that lived in wmarka 1.x–2.x:** web-eau.net (category article layouts), FavThemes (timeline and promo banners), TemplatePlazza (news feed with dates), Jeroen Moolenschot and Joomill (YouTube field), Joomline (JL extension layouts), Septdir Workshop (JYProExtra layouts), Serban Ghita and Nick Ilyin (Mobile Detect), the Google AMP team (the AMP version in 1.0).
- **The JPathRu community** and jpath.ru — for the Russian Joomla documentation we learned from and checked against.
- **Everyone who ran wmarka on their sites and sent bug reports:** many 4.x decisions that made it into clean grew out of those reports.

wmarka and wmarka clean are by **Beibit Sakhanov**, [Webmarka](https://webmarka.kz).

## Licence

GNU General Public License version 2 or later — full text in [LICENSE.txt](LICENSE.txt). UIkit — MIT licence, JUImage — GNU GPL v2+.
