<?php

/** Форма умного поиска: строка и кнопка */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<form action="<?php echo Route::_($this->query->toUri()); ?>" method="get" class="uk-margin-medium-bottom">
    <div class="uk-flex uk-flex-wrap" uk-margin>
        <div class="uk-inline uk-width-expand uk-margin-small-right">
            <span class="uk-form-icon" uk-icon="search"></span>
            <input class="uk-input uk-form-large" type="search" name="q" value="<?php echo htmlspecialchars((string) $this->query->input, ENT_QUOTES, 'UTF-8'); ?>" aria-label="<?php echo Text::_('COM_FINDER_SEARCH_FORM_LEGEND'); ?>">
        </div>
        <button class="uk-button uk-button-primary uk-button-large" type="submit"><?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?></button>
    </div>
    <?php echo $this->getFields(); ?>
</form>
