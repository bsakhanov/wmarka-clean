<?php

/** Выход с сайта */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<div class="uk-width-large uk-margin-auto">
    <form action="<?php echo Route::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="uk-card uk-card-default uk-card-body">
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?php echo Text::_('JLOGOUT'); ?></button>
        <input type="hidden" name="return" value="<?php echo base64_encode((string) $this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>">
        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
</div>
