<?php

/** Контакты категории: карточки с фото, должностью и ссылкой */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Contact\Site\Helper\RouteHelper;
use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$p = $this->params;
?>
<div class="wm-contacts">
    <?php if ($p->get('show_page_heading')) : ?><h1 class="uk-heading-small"><?php echo htmlspecialchars((string) $p->get('page_heading'), ENT_QUOTES, 'UTF-8'); ?></h1><?php elseif ($p->get('show_category_title', 1)) : ?><h1 class="uk-heading-small"><?php echo htmlspecialchars((string) $this->category->title, ENT_QUOTES, 'UTF-8'); ?></h1><?php endif; ?>
    <?php if ($p->get('show_description', 1) && $this->category->description) : ?><div class="uk-text-lead uk-margin-medium-bottom"><?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_contact.category'); ?></div><?php endif; ?>
    <div class="uk-grid-medium uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid>
        <?php foreach ((array) $this->items as $item) : ?>
            <div>
                <a class="uk-card uk-card-default uk-card-body uk-card-hover uk-display-block uk-link-toggle uk-text-center" href="<?php echo Route::_(RouteHelper::getContactRoute($item->slug, $item->catid, $item->language)); ?>">
                    <?php if ($item->image) : ?><div class="uk-margin-small-bottom"><?php echo T::img((string) $item->image, [[160, 160]], (string) $item->name, '', 'uk-border-circle'); ?></div><?php endif; ?>
                    <span class="uk-h4 uk-link-heading uk-display-block"><?php echo htmlspecialchars((string) $item->name, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php if ($item->con_position) : ?><span class="uk-text-meta"><?php echo htmlspecialchars((string) $item->con_position, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($p->get('show_pagination', 2) && $this->pagination->pagesTotal > 1) : ?><?php echo $this->pagination->getPagesLinks(); ?><?php endif; ?>
</div>
