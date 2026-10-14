<?php

/** Метки плашками */

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

if (empty($displayData)) {
    return;
}

$links = [];

foreach ((array) $displayData as $tag) {
    $links[] = '<a class="uk-button uk-button-default uk-button-small uk-border-pill uk-margin-xsmall-right" href="'
        . Route::_(RouteHelper::getComponentTagRoute($tag->tag_id . ':' . $tag->alias, $tag->language)) . '" rel="tag">#' . htmlspecialchars($tag->title, ENT_QUOTES, 'UTF-8') . '</a>';
}

echo '<div class="uk-margin" uk-margin>' . implode('', $links) . '</div>';
