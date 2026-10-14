<?php

/** Популярные метки плашками */

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

if (empty($list)) {
    return;
}
?>
<div uk-margin>
    <?php foreach ($list as $item) : ?>
        <a class="uk-button uk-button-default uk-button-small uk-border-pill uk-margin-xsmall-right" href="<?php echo Route::_(RouteHelper::getComponentTagRoute($item->tag_id . ':' . $item->alias, $item->language)); ?>">#<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?><?php if ($params->get('display_count', 0)) : ?> <span class="uk-text-muted"><?php echo (int) $item->count; ?></span><?php endif; ?></a>
    <?php endforeach; ?>
</div>
