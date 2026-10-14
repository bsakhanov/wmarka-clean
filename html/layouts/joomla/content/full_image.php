<?php

/**
 * Полное изображение статьи. Размеры заданы здесь: 1200 × 675 (16 : 9) и 720 × 405
 * для телефонов; обрезка по центру, WebP через JUImage. Нет полного — вступительное.
 */

\defined('_JEXEC') or die;

use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$item   = $displayData;
$images = json_decode((string) ($item->images ?? '{}'), true) ?: [];
$src    = $images['image_fulltext'] ?? '';
$alt    = $images['image_fulltext_alt'] ?? '';
$cap    = $images['image_fulltext_caption'] ?? '';
$class  = $images['imgclass_fulltext'] ?? '';

if (T::src($src) === '') {
    $src   = $images['image_intro'] ?? '';
    $alt   = $images['image_intro_alt'] ?? '';
    $cap   = $images['image_intro_caption'] ?? '';
    $class = $images['imgclass_intro'] ?? '';
}

if (T::src($src) === '') {
    return;
}
?>
<figure class="uk-margin-medium">
    <?php echo T::img($src, [[1200, 675], [720, 405]], $alt !== '' ? $alt : (string) $item->title, '(min-width: 1200px) 860px, 100vw', trim('uk-width-1-1 ' . $class), true); ?>
    <?php if ($cap !== '') : ?><figcaption class="uk-text-meta uk-margin-small-top"><?php echo htmlspecialchars($cap, ENT_QUOTES, 'UTF-8'); ?></figcaption><?php endif; ?>
</figure>
