<?php

/**
 * Постраничная навигация UIkit для getPagesLinks(): этим путём листалку выводят блоги,
 * метки, поиск и большинство видов ядра. Каждое звено рисует link.php.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$list = $displayData['list'];
?>
<nav class="uk-margin-large-top" aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>">
    <ul class="uk-pagination uk-flex-center">
        <?php echo $list['previous']['data']; ?>
        <?php foreach ($list['pages'] as $page) : ?>
            <?php echo $page['data']; ?>
        <?php endforeach; ?>
        <?php echo $list['next']['data']; ?>
    </ul>
</nav>
