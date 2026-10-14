<?php

/** Все метки: плашки с числом материалов и описанием */

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

$p = $this->params;
?>
<div class="wm-tags">
    <?php if ($p->get('show_page_heading')) : ?><h1 class="uk-heading-small"><?php echo htmlspecialchars((string) $p->get('page_heading'), ENT_QUOTES, 'UTF-8'); ?></h1><?php endif; ?>
    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid>
        <?php foreach ((array) $this->items as $tag) : ?>
            <div>
                <a class="uk-card uk-card-default uk-card-small uk-card-body uk-card-hover uk-display-block uk-link-toggle" href="<?php echo Route::_(RouteHelper::getComponentTagRoute($tag->id . ':' . $tag->alias, $tag->language)); ?>">
                    <span class="uk-h4 uk-link-heading">#<?php echo htmlspecialchars($tag->title, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php if ($p->get('all_tags_show_tag_hits')) : ?><span class="uk-badge uk-margin-small-left"><?php echo (int) $tag->hits; ?></span><?php endif; ?>
                    <?php if ($p->get('all_tags_show_tag_description', 1) && $tag->description) : ?><p class="uk-text-small uk-text-muted uk-margin-small-top uk-margin-remove-bottom"><?php echo htmlspecialchars(mb_strimwidth(trim(strip_tags($tag->description)), 0, 140, '…'), ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if ($p->get('show_pagination', 2) && $this->pagination->pagesTotal > 1) : ?><?php echo $this->pagination->getPagesLinks(); ?><?php endif; ?>
</div>
