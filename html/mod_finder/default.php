<?php

/** Поиск (mod_finder): строка с иконкой */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<form class="uk-search uk-search-default uk-width-1-1" action="<?php echo Route::_($route); ?>" method="get" role="search">
    <span uk-search-icon></span>
    <input class="uk-search-input" type="search" name="q" placeholder="<?php echo htmlspecialchars(Text::_('MOD_FINDER_SEARCH_VALUE'), ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?php echo htmlspecialchars(Text::_('MOD_FINDER_SEARCH_VALUE'), ENT_QUOTES, 'UTF-8'); ?>">
    <?php echo $output ?? ''; ?>
</form>
