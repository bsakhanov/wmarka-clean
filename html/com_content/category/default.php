<?php

/** Список материалов категории: таблица с датой и просмотрами */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$p       = $this->params;
$heading = $p->get('show_page_heading') ? (string) $p->get('page_heading') : ($p->get('show_category_title', 1) ? (string) $this->category->title : '');
$dateKey = (string) $p->get('list_show_date', 'published');
$field   = ['created' => 'created', 'modified' => 'modified', 'published' => 'publish_up'][$dateKey] ?? '';
?>
<div class="wm-category-list">
    <?php if ($heading !== '') : ?><h1 class="uk-heading-small"><?php echo htmlspecialchars($heading, ENT_QUOTES, 'UTF-8'); ?></h1><?php endif; ?>
    <?php if ($p->get('show_description', 1) && $this->category->description) : ?>
        <div class="uk-text-lead uk-margin-medium-bottom"><?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?></div>
    <?php endif; ?>
    <?php if ($this->items) : ?>
        <div class="uk-overflow-auto">
            <table class="uk-table uk-table-divider uk-table-hover uk-table-middle">
                <thead><tr><th><?php echo Text::_('JGLOBAL_TITLE'); ?></th><?php if ($field !== '') : ?><th class="uk-table-shrink uk-text-nowrap"><?php echo Text::_('COM_CONTENT_' . strtoupper($dateKey) . '_DATE'); ?></th><?php endif; ?><?php if ($p->get('list_show_hits', 1)) : ?><th class="uk-table-shrink"><?php echo Text::_('JGLOBAL_HITS'); ?></th><?php endif; ?></tr></thead>
                <tbody>
                <?php foreach ($this->items as $item) : ?>
                    <tr>
                        <td><a class="uk-link-heading" href="<?php echo Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language)); ?>"><?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?></a></td>
                        <?php if ($field !== '') : ?><td class="uk-text-nowrap uk-text-meta"><?php echo HTMLHelper::_('date', $item->$field, Text::_('DATE_FORMAT_LC4')); ?></td><?php endif; ?>
                        <?php if ($p->get('list_show_hits', 1)) : ?><td class="uk-text-meta"><?php echo (int) $item->hits; ?></td><?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="uk-text-muted"><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></p>
    <?php endif; ?>
    <?php if ($p->get('show_pagination', 2) && $this->pagination->pagesTotal > 1) : ?><?php echo $this->pagination->getPagesLinks(); ?><?php endif; ?>
</div>
