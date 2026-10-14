<?php

/** Список материалов с миниатюрами (layouts/clean/list.php) */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

echo LayoutHelper::render('clean.list', ['items' => $list ?? []]);
