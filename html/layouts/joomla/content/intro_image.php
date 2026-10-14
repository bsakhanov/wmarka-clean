<?php

/**
 * Вступительное изображение. Размеры заданы здесь: 720 × 405 (16 : 9) и 360 × 203
 * для узких колонок; обрезка по центру, WebP через JUImage. Тот же макет выводит
 * картинку в карточках блога, избранного, меток и модулей.
 */

\defined('_JEXEC') or die;

use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$item = $displayData;
[$src, $alt] = T::introOf($item);

if (T::src($src) === '') {
    return;
}

$images = json_decode((string) ($item->images ?? '{}'), true) ?: [];
$class  = trim('uk-width-1-1 ' . ($images['imgclass_intro'] ?? ''));

echo T::img($src, [[720, 405], [360, 203]], $alt, '(min-width: 960px) 360px, (min-width: 640px) 50vw, 100vw', $class);
