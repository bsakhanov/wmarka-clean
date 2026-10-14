<?php

/**
 * Список материалов модуля: миниатюра 16 : 9 слева (тот же макет вступительного
 * изображения), заголовок, дата. $displayData: items (у элемента link, title, images, дата).
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$items = $displayData['items'] ?? [];

if (!$items) {
    return;
}
?>
<ul class="uk-list uk-list-divider">
    <?php foreach ($items as $item) : ?>
        <?php $image = !empty($item->images) ? LayoutHelper::render('joomla.content.intro_image', $item) : ''; ?>
        <?php $date = $item->publish_up ?? ($item->created ?? ''); ?>
        <li>
            <div class="uk-grid-small" uk-grid>
                <?php if ($image !== '') : ?><div class="uk-width-1-3"><a href="<?php echo $item->link ?? ($item->route ?? '#'); ?>" tabindex="-1" aria-hidden="true"><?php echo $image; ?></a></div><?php endif; ?>
                <div class="uk-width-expand">
                    <a class="uk-link-heading uk-text-bold" href="<?php echo $item->link ?? ($item->route ?? '#'); ?>"><?php echo htmlspecialchars((string) $item->title, ENT_QUOTES, 'UTF-8'); ?></a>
                    <?php if ($date) : ?><div class="uk-text-meta"><?php echo HTMLHelper::_('date', $date, Text::_('DATE_FORMAT_LC4')); ?></div><?php endif; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
