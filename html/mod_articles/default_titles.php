<?php

/** Пункты списка, когда штатный default.php модуля подключает их сам ($items уже готов) */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

echo LayoutHelper::render('clean.list', ['items' => $items ?? []]);
