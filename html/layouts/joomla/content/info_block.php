<?php

/** Служебная строка материала: автор, рубрика, дата, просмотры — по опциям ядра */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$item   = $displayData['item'];
$params = $displayData['params'];
$parts  = [];

if ($params->get('show_author') && !empty($item->author)) {
    $name    = htmlspecialchars((string) ($item->created_by_alias ?: $item->author), ENT_QUOTES, 'UTF-8');
    $parts[] = (!empty($item->contact_link) && $params->get('link_author')) ? '<a href="' . $item->contact_link . '">' . $name . '</a>' : $name;
}

if ($params->get('show_category') && !empty($item->category_title) && empty($displayData['nocategory'])) {
    $cat     = htmlspecialchars((string) $item->category_title, ENT_QUOTES, 'UTF-8');
    $parts[] = $params->get('link_category') && !empty($item->catslug) ? '<a href="' . Route::_(RouteHelper::getCategoryRoute($item->catslug, $item->category_language ?? '*')) . '">' . $cat . '</a>' : $cat;
}

foreach (['show_publish_date' => 'publish_up', 'show_create_date' => 'created', 'show_modify_date' => 'modified'] as $flag => $field) {
    if ($params->get($flag) && !empty($item->$field)) {
        $parts[] = '<time datetime="' . HTMLHelper::_('date', $item->$field, 'c') . '">' . HTMLHelper::_('date', $item->$field, Text::_('DATE_FORMAT_LC3')) . '</time>';
        break;
    }
}

if ($params->get('show_hits')) {
    $parts[] = '<span uk-icon="icon: eye; ratio: 0.75"></span> ' . (int) $item->hits;
}

if ($parts) {
    echo '<p class="uk-article-meta uk-margin-small">' . implode(' <span class="uk-margin-xsmall-left uk-margin-xsmall-right">/</span> ', $parts) . '</p>';
}
