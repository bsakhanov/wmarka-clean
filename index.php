<?php

/**
 * @package     wmarka_clean
 * @copyright   (C) 2026 Webmarka
 * @license     GNU General Public License version 2 or later
 *
 * Чистый шаблон: без настроек. Раскладка задана здесь, размеры картинок — в макетах
 * html/layouts/joomla/content/intro_image.php и full_image.php.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use WmarkaClean\T;

require_once __DIR__ . '/php/T.php';

$app  = Factory::getApplication();
$wa   = $this->getWebAssetManager();
$wa->useStyle('template.wmarka_clean')->useScript('template.wmarka_clean.icons');
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

// Значки: набор из папки шаблона (favicon.svg, favicon.ico, apple-touch-icon.png)
$fav = 'media/templates/site/' . $this->template . '/images/favicon/';
$fav = is_dir(JPATH_ROOT . '/' . $fav) ? $fav : 'media/templates/site/wmarka_clean/images/favicon/';
foreach ([['favicon.svg', 'icon', ['type' => 'image/svg+xml']], ['favicon.ico', 'alternate icon', ['type' => 'image/vnd.microsoft.icon']], ['apple-touch-icon.png', 'apple-touch-icon', ['sizes' => '180x180']]] as [$file, $rel, $attr]) {
    if (is_file(JPATH_ROOT . '/' . $fav . $file)) {
        $this->addHeadLink(Uri::root(true) . '/' . $fav . $file, $rel, 'rel', $attr);
    }
}

$site    = htmlspecialchars((string) $app->get('sitename'), ENT_QUOTES, 'UTF-8');
$active  = $app->getMenu()->getActive();
$pclass  = $active ? htmlspecialchars((string) $active->getParams()->get('pageclass_sfx', ''), ENT_QUOTES, 'UTF-8') : '';
$sideA   = $this->countModules('sidebar-a');
$sideB   = $this->countModules('sidebar-b');
$n       = 0;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>
<body class="site <?php echo $pclass; ?>">

<?php if ($this->countModules('toolbar-left') || $this->countModules('toolbar-right')) : ?>
<div class="uk-section uk-section-secondary uk-padding-remove-vertical uk-text-small uk-visible@m">
    <div class="uk-container uk-flex uk-flex-between uk-flex-middle" style="min-height:40px">
        <div><jdoc:include type="modules" name="toolbar-left" style="none" /></div>
        <div><jdoc:include type="modules" name="toolbar-right" style="none" /></div>
    </div>
</div>
<?php endif; ?>

<header uk-sticky="show-on-up: true; animation: uk-animation-slide-top; sel-target: .uk-navbar-container">
    <div class="uk-navbar-container">
        <div class="uk-container">
            <nav uk-navbar>
                <div class="uk-navbar-left">
                    <?php if ($this->countModules('logo')) : ?>
                        <jdoc:include type="modules" name="logo" style="none" />
                    <?php else : ?>
                        <a class="uk-navbar-item uk-logo" href="<?php echo Uri::root(true); ?>/"><?php echo $site; ?></a>
                    <?php endif; ?>
                </div>
                <?php if ($this->countModules('navbar-center')) : ?>
                    <div class="uk-navbar-center uk-visible@m"><jdoc:include type="modules" name="navbar-center" style="none" /></div>
                <?php endif; ?>
                <div class="uk-navbar-right">
                    <div class="uk-visible@m uk-flex"><jdoc:include type="modules" name="navbar-right" style="none" /></div>
                    <jdoc:include type="modules" name="iconnav" style="none" />
                    <a class="uk-navbar-toggle uk-hidden@m" href="#offcanvas" uk-toggle aria-label="<?php echo Text::_('TPL_WMARKA_CLEAN_MENU'); ?>"><span uk-navbar-toggle-icon></span></a>
                </div>
            </nav>
        </div>
    </div>
</header>

<?php if ($this->countModules('breadcrumb')) : ?>
<div class="uk-container uk-margin-top"><jdoc:include type="modules" name="breadcrumb" style="none" /></div>
<?php endif; ?>

<?php foreach (['adver-top', 'slider', 'block-a', 'block-b'] as $position) : ?>
    <?php if (($html = T::block($this, $position, $n)) !== '') { echo $html; $n++; } ?>
<?php endforeach; ?>

<main class="uk-section">
    <div class="uk-container">
        <div class="uk-grid-large" uk-grid>
            <div class="wm-main uk-width-1-1 uk-width-expand@m">
                <?php if ($this->countModules('main-top')) : ?><div class="uk-margin-medium-bottom"><jdoc:include type="modules" name="main-top" style="clean" /></div><?php endif; ?>
                <jdoc:include type="message" />
                <jdoc:include type="component" />
                <?php if ($this->countModules('main-bottom')) : ?><div class="uk-margin-medium-top"><jdoc:include type="modules" name="main-bottom" style="clean" /></div><?php endif; ?>
            </div>
            <?php if ($sideA) : ?><aside class="uk-width-1-1 uk-width-1-4@m uk-flex-first@m"><jdoc:include type="modules" name="sidebar-a" style="clean" /></aside><?php endif; ?>
            <?php if ($sideB) : ?><aside class="uk-width-1-1 uk-width-1-4@m"><jdoc:include type="modules" name="sidebar-b" style="clean" /></aside><?php endif; ?>
        </div>
    </div>
</main>

<?php foreach (['block-c', 'block-d', 'block-e', 'block-f', 'block-g', 'block-h', 'block-i', 'block-k'] as $position) : ?>
    <?php if (($html = T::block($this, $position, $n)) !== '') { echo $html; $n++; } ?>
<?php endforeach; ?>

<footer class="uk-section uk-section-secondary uk-light">
    <div class="uk-container">
        <?php if ($this->countModules('footer-left') || $this->countModules('footer-center') || $this->countModules('footer-right')) : ?>
        <div class="uk-child-width-1-3@m uk-grid-large uk-margin-medium-bottom" uk-grid>
            <div><jdoc:include type="modules" name="footer-left" style="clean" /></div>
            <div><jdoc:include type="modules" name="footer-center" style="clean" /></div>
            <div><jdoc:include type="modules" name="footer-right" style="clean" /></div>
        </div>
        <?php endif; ?>
        <div class="uk-flex uk-flex-between uk-flex-wrap uk-text-small">
            <div>© <?php echo date('Y'); ?> <?php echo $site; ?></div>
            <div><jdoc:include type="modules" name="footer" style="none" /></div>
        </div>
    </div>
</footer>

<div id="offcanvas" uk-offcanvas="overlay: true; flip: true">
    <div class="uk-offcanvas-bar">
        <button class="uk-offcanvas-close" type="button" uk-close aria-label="<?php echo Text::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?>"></button>
        <?php if ($this->countModules('offcanvas-menu')) : ?>
            <jdoc:include type="modules" name="offcanvas-menu" style="none" />
        <?php else : ?>
            <jdoc:include type="modules" name="navbar-right" style="none" />
        <?php endif; ?>
        <jdoc:include type="modules" name="offcanvas" style="clean" />
    </div>
</div>

<a class="uk-position-fixed uk-position-bottom-right uk-position-medium uk-icon-button" href="#" uk-totop uk-scroll aria-label="<?php echo Text::_('TPL_WMARKA_CLEAN_TOTOP'); ?>"></a>
<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
