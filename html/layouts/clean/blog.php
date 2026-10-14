<?php

/**
 * Блог: ведущие материалы широкими карточками, остальные — сеткой 1 / 2 / 3 колонки,
 * ссылки на остальные материалы списком, постраничная навигация.
 * $displayData: lead, intro, links (материалы), pagination, params, heading, description.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$lead    = (array) ($displayData['lead'] ?? []);
$intro   = (array) ($displayData['intro'] ?? []);
$links   = (array) ($displayData['links'] ?? []);
$pages   = $displayData['pagination'] ?? null;
$params  = $displayData['params'];
$link    = static function ($item): string {
    if ($item->params->get('access-view', true)) {
        return Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language));
    }

    return Route::_('index.php?option=com_users&view=login&return=' . base64_encode(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language)));
};
?>
<div class="wm-blog">
    <?php if ($displayData['heading'] !== '') : ?>
        <h1 class="uk-heading-small uk-margin-medium-bottom"><?php echo htmlspecialchars($displayData['heading'], ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php endif; ?>
    <?php if (($displayData['description'] ?? '') !== '') : ?>
        <div class="uk-text-lead uk-margin-medium-bottom"><?php echo $displayData['description']; ?></div>
    <?php endif; ?>

    <?php foreach ($lead as $item) : ?>
        <?php echo LayoutHelper::render('clean.card', ['item' => $item, 'params' => $item->params, 'link' => $link($item), 'wide' => true, 'heading' => 'h2']); ?>
    <?php endforeach; ?>

    <?php if ($intro) : ?>
        <div class="uk-grid-medium uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid>
            <?php foreach ($intro as $item) : ?>
                <div><?php echo LayoutHelper::render('clean.card', ['item' => $item, 'params' => $item->params, 'link' => $link($item), 'heading' => 'h2']); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($links) : ?>
        <h3 class="uk-h4 uk-heading-bullet uk-margin-large-top"><?php echo Text::_('JGLOBAL_MORE_ARTICLES') !== 'JGLOBAL_MORE_ARTICLES' ? Text::_('JGLOBAL_MORE_ARTICLES') : Text::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
        <ul class="uk-list uk-list-divider">
            <?php foreach ($links as $item) : ?>
                <li><a class="uk-link-heading" href="<?php echo $link($item); ?>"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!$lead && !$intro && !$links) : ?>
        <p class="uk-text-muted"><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
    <?php endif; ?>

    <?php if ($pages && ($params->def('show_pagination', 2) == 1 || ($params->get('show_pagination') == 2 && $pages->pagesTotal > 1))) : ?>
        <?php echo $pages->getPagesLinks(); ?>
        <?php if ($params->def('show_pagination_results', 1)) : ?><p class="uk-text-meta uk-text-center"><?php echo $pages->getPagesCounter(); ?></p><?php endif; ?>
    <?php endif; ?>
</div>
