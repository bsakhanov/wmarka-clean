<?php

/**
 * Карточки (макет wm-cards из wmarka): модули, настроенные под wmarka, работают и здесь.
 * Без этого файла Joomla взяла бы штатный default.php модуля, а тот снова искал бы
 * «wm-cards_items» и зациклился.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

$items = [];

foreach ((array) ($list ?? []) as $key => $value) {
    \is_array($value) ? array_push($items, ...$value) : $items[] = $value;
}

if (!$items) {
    return;
}
?>
<div class="uk-grid-medium uk-child-width-1-2@s uk-child-width-1-3@l uk-grid-match" uk-grid>
    <?php foreach ($items as $item) : ?>
        <div><?php echo LayoutHelper::render('clean.card', ['item' => $item, 'params' => $params, 'link' => $item->link, 'heading' => 'h3']); ?></div>
    <?php endforeach; ?>
</div>
