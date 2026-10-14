<?php

/** Материалы категории: список с миниатюрами; при группировке — по группам */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

if (empty($list)) {
    return;
}

if (!empty($grouped)) {
    foreach ($list as $group => $items) {
        echo '<h4 class="uk-h5 uk-margin-small-bottom">' . htmlspecialchars((string) $group, ENT_QUOTES, 'UTF-8') . '</h4>';
        echo LayoutHelper::render('clean.list', ['items' => $items]);
    }

    return;
}

echo LayoutHelper::render('clean.list', ['items' => $list]);
