<?php

/**
 * Статья: рубрика над заголовком, заголовок H1 (заголовок пункта меню — только у пункта,
 * который ведёт на эту статью), служебная строка, полное изображение, текст с таблицами
 * по-телефонному, метки плашками, навигация по статьям.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$item   = $this->item;
$params = $item->params;
$active = Factory::getApplication()->getMenu()->getActive();
$own    = $active && ($active->query['view'] ?? '') === 'article' && (int) ($active->query['id'] ?? 0) === (int) $item->id;
$nav    = !empty($item->pagination) && !$item->paginationposition && $item->paginationrelative;
?>
<article class="uk-article" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="inLanguage" content="<?php echo $item->language === '*' ? Factory::getApplication()->get('language') : $item->language; ?>">

    <?php if ($own && $this->params->get('show_page_heading') && $this->params->get('page_heading') !== $item->title) : ?>
        <p class="uk-text-meta uk-margin-remove"><?php echo htmlspecialchars((string) $this->params->get('page_heading'), ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <?php if ($params->get('show_category') && !empty($item->category_title)) : ?>
        <p class="uk-text-small uk-margin-remove">
            <?php if ($params->get('link_category') && !empty($item->catslug)) : ?>
                <a class="uk-text-primary" href="<?php echo Route::_(RouteHelper::getCategoryRoute($item->catslug, $item->category_language ?? '*')); ?>"><?php echo htmlspecialchars($item->category_title, ENT_QUOTES, 'UTF-8'); ?></a>
            <?php else : ?>
                <span class="uk-text-primary"><?php echo htmlspecialchars($item->category_title, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </p>
    <?php endif; ?>

    <?php if ($params->get('show_title')) : ?>
        <h1 class="uk-article-title uk-margin-small-top" itemprop="headline"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php endif; ?>

    <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $item, 'params' => $params, 'nocategory' => true]); ?>
    <?php echo $item->event->afterDisplayTitle; ?>
    <?php echo $item->event->beforeDisplayContent; ?>

    <?php if ($params->get('access-view')) : ?>
        <?php echo LayoutHelper::render('joomla.content.full_image', $item); ?>
        <?php if (!empty($item->pagination) && !$item->paginationposition && !$item->paginationrelative) : ?><?php echo $item->pagination; ?><?php endif; ?>
        <?php if (isset($item->toc)) : ?><?php echo $item->toc; ?><?php endif; ?>
        <div class="wm-text" itemprop="articleBody"><?php echo T::tables((string) $item->text); ?></div>
        <?php if ($params->get('show_tags', 1) && !empty($item->tags->itemTags)) : ?><?php echo LayoutHelper::render('joomla.content.tags', $item->tags->itemTags); ?><?php endif; ?>
        <?php if ($nav) : ?><?php echo $item->pagination; ?><?php endif; ?>
    <?php else : ?>
        <?php echo $item->introtext; ?>
        <p><a class="uk-button uk-button-primary" href="<?php echo Route::_('index.php?option=com_users&view=login&return=' . base64_encode(Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language), false))); ?>"><?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?></a></p>
    <?php endif; ?>

    <?php echo $item->event->afterDisplayContent; ?>
</article>
