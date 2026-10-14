<?php

/**
 * Меню. В позициях навбара (navbar-*) — горизонтальное меню UIkit с выпадающими
 * списками; в остальных позициях — вертикальное. Пункт «Ссылка в новом окне» открывается
 * в новой вкладке, разделитель и заголовок — без ссылки.
 */

\defined('_JEXEC') or die;

if (empty($list)) {
    return;
}

$navbar = str_starts_with((string) $module->position, 'navbar');
$base   = (int) reset($list)->level;
$stack  = [];

echo '<ul class="' . ($navbar ? 'uk-navbar-nav' : 'uk-nav uk-nav-default') . '">';

foreach ($list as $item) {
    $current = (int) $item->id === (int) $active_id || ($item->type === 'alias' && (int) $item->getParams()->get('aliasoptions') === (int) $active_id);
    $classes = [];

    if ($current || \in_array((int) $item->id, array_map('intval', $path), true)) {
        $classes[] = 'uk-active';
    }

    if ($item->deeper) {
        $classes[] = 'uk-parent';
    }

    echo '<li' . ($classes ? ' class="' . implode(' ', $classes) . '"' : '') . '>';

    $title = htmlspecialchars((string) $item->title, ENT_QUOTES, 'UTF-8');
    $icon  = $navbar && $item->deeper && (int) $item->level === $base ? ' <span uk-navbar-parent-icon></span>' : '';

    if (\in_array($item->type, ['separator', 'heading'], true)) {
        echo $navbar && $item->deeper ? '<a href="#" role="button">' . $title . $icon . '</a>' : '<span class="uk-nav-header">' . $title . '</span>';
    } else {
        $target = (int) $item->browserNav === 1 ? ' target="_blank" rel="noopener"' : '';
        echo '<a href="' . htmlspecialchars((string) $item->flink, ENT_QUOTES, 'UTF-8') . '"' . $target . ($current ? ' aria-current="page"' : '') . '>' . $title . $icon . '</a>';
    }

    if ($item->deeper) {
        if ($navbar && (int) $item->level === $base) {
            echo '<div class="uk-drop uk-navbar-dropdown"><ul class="uk-nav uk-navbar-dropdown-nav">';
            $stack[] = '</ul></div></li>';
        } else {
            echo '<ul class="uk-nav-sub">';
            $stack[] = '</ul></li>';
        }
    } elseif ($item->shallower) {
        echo '</li>';

        for ($i = 0; $i < (int) $item->level_diff && $stack; $i++) {
            echo array_pop($stack);
        }
    } else {
        echo '</li>';
    }
}

while ($stack) {
    echo array_pop($stack);
}

echo '</ul>';
