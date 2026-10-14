<?php

/** Материалы метки: заголовок, описание, карточки сеткой 1 / 2 / 3 колонки */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

$p     = $this->params;
$tags  = array_values(array_filter((array) $this->item, 'is_object'));
$title = $p->get('show_page_heading') ? (string) $p->get('page_heading') : implode(', ', array_map(static fn ($t) => (string) $t->title, $tags));
?>
<div class="wm-tag">
    <?php if ($title !== '' && $p->get('show_tag_title', 1)) : ?><h1 class="uk-heading-small">#<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1><?php endif; ?>
    <?php if (\count($tags) === 1 && $p->get('tag_list_show_tag_description', 1) && $tags[0]->description) : ?>
        <div class="uk-text-lead uk-margin-medium-bottom"><?php echo HTMLHelper::_('content.prepare', $tags[0]->description, '', 'com_tags.tag'); ?></div>
    <?php endif; ?>
    <?php if ($this->items) : ?>
        <div class="uk-grid-medium uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid>
            <?php foreach ($this->items as $item) : ?>
                <?php $item->title = $item->core_title; $item->introtext = $item->core_body ?? ''; $item->images = $item->core_images ?? ''; ?>
                <div><?php echo LayoutHelper::render('clean.card', ['item' => $item, 'params' => $p, 'link' => Route::_($item->link), 'heading' => 'h2']); ?></div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="uk-text-muted"><?php echo Text::_('COM_TAGS_NO_ITEMS'); ?></p>
    <?php endif; ?>
    <?php if ($p->get('show_pagination', 2) && $this->pagination->pagesTotal > 1) : ?><?php echo $this->pagination->getPagesLinks(); ?><?php endif; ?>
</div>
