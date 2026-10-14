<?php

/**
 * Карточка материала для блога, избранного и меток: картинка сверху (у ведущего
 * материала — слева на половину ширины), рубрика, заголовок, служебная строка, анонс.
 * $displayData: item, params, link, wide (ведущий), heading (h2 / h3).
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$item    = $displayData['item'];
$params  = $displayData['params'];
$link    = $displayData['link'];
$wide    = !empty($displayData['wide']);
$h       = $displayData['heading'] ?? 'h3';
$title   = htmlspecialchars((string) ($item->title ?? $item->core_title ?? ''), ENT_QUOTES, 'UTF-8');
$text    = trim(strip_tags((string) ($item->introtext ?? $item->core_body ?? '')));
$text    = mb_strlen($text) > 220 ? rtrim(mb_substr($text, 0, mb_strrpos(mb_substr($text, 0, 220), ' ') ?: 220), ' ,.;:—-') . '…' : $text;
$image   = LayoutHelper::render('joomla.content.intro_image', $item);
$cat     = (!empty($item->category_title) && $params->get('show_category', 1))
    ? (!empty($item->catslug) && $params->get('link_category') ? '<a class="uk-text-primary" href="' . Route::_(RouteHelper::getCategoryRoute($item->catslug, $item->category_language ?? '*')) . '">' . htmlspecialchars($item->category_title, ENT_QUOTES, 'UTF-8') . '</a>' : '<span class="uk-text-primary">' . htmlspecialchars($item->category_title, ENT_QUOTES, 'UTF-8') . '</span>')
    : '';
$meta    = isset($item->params) && $item->params instanceof \Joomla\Registry\Registry
    ? LayoutHelper::render('joomla.content.info_block', ['item' => $item, 'params' => $params, 'nocategory' => true])
    : '';
?>
<article class="uk-card uk-card-default uk-card-hover uk-height-1-1<?php echo $wide ? ' uk-margin-medium-bottom' : ''; ?>">
    <div class="<?php echo $wide && $image !== '' ? 'uk-grid-collapse uk-child-width-1-2@m' : ''; ?>"<?php echo $wide && $image !== '' ? ' uk-grid' : ''; ?>>
        <?php if ($image !== '') : ?>
            <div class="<?php echo $wide ? 'uk-card-media-left uk-cover-container' : 'uk-card-media-top'; ?>"><a href="<?php echo $link; ?>" tabindex="-1" aria-hidden="true"><?php echo $image; ?></a></div>
        <?php endif; ?>
        <div>
            <div class="uk-card-body">
                <?php if ($cat !== '') : ?><p class="uk-text-small uk-margin-remove"><?php echo $cat; ?></p><?php endif; ?>
                <<?php echo $h; ?> class="<?php echo $wide ? 'uk-h2' : 'uk-h4'; ?> uk-margin-small-top uk-margin-remove-bottom"><a class="uk-link-heading" href="<?php echo $link; ?>"><?php echo $title; ?></a></<?php echo $h; ?>>
                <?php echo $meta; ?>
                <?php if ($text !== '' && $params->get('show_intro', 1)) : ?><p class="uk-margin-small-top uk-margin-remove-bottom"><?php echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
            </div>
        </div>
    </div>
</article>
