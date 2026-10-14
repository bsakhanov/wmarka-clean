<?php

/** Выход (mod_login) */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<form action="<?php echo Route::_('index.php', true); ?>" method="post">
    <p class="uk-margin-small"><?php echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars((string) $user->name, ENT_QUOTES, 'UTF-8')); ?></p>
    <button type="submit" class="uk-button uk-button-default uk-width-1-1"><?php echo Text::_('JLOGOUT'); ?></button>
    <input type="hidden" name="option" value="com_users">
    <input type="hidden" name="task" value="user.logout">
    <input type="hidden" name="return" value="<?php echo $return; ?>">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
