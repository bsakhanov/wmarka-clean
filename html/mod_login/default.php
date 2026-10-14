<?php

/** Вход (mod_login) */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<form action="<?php echo Route::_('index.php', true); ?>" method="post" class="uk-form-stacked">
    <div class="uk-margin-small"><input class="uk-input" type="text" name="username" autocomplete="username" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>" aria-label="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>"></div>
    <div class="uk-margin-small"><input class="uk-input" type="password" name="password" autocomplete="current-password" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" aria-label="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>"></div>
    <div class="uk-margin-small"><label class="uk-text-small"><input class="uk-checkbox" type="checkbox" name="remember" value="yes"> <?php echo Text::_('MOD_LOGIN_REMEMBER_ME'); ?></label></div>
    <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?php echo Text::_('JLOGIN'); ?></button>
    <input type="hidden" name="option" value="com_users">
    <input type="hidden" name="task" value="user.login">
    <input type="hidden" name="return" value="<?php echo $return; ?>">
    <?php echo HTMLHelper::_('form.token'); ?>
    <ul class="uk-list uk-text-small uk-margin-small-top">
        <?php if ($params->get('showPasswordReset', 1)) : ?><li><a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>"><?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a></li><?php endif; ?>
        <?php if ($params->get('showUsernameReminder', 1)) : ?><li><a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>"><?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a></li><?php endif; ?>
    </ul>
</form>
