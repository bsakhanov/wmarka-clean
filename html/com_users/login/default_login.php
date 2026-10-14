<?php

/** Вход на сайт */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
?>
<div class="uk-width-large uk-margin-auto">
    <?php if ($this->params->get('show_page_heading')) : ?><h1 class="uk-heading-small"><?php echo htmlspecialchars((string) $this->params->get('page_heading'), ENT_QUOTES, 'UTF-8'); ?></h1><?php endif; ?>
    <form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="uk-form-stacked uk-card uk-card-default uk-card-body">
        <?php foreach ($this->form->getFieldset('credentials') as $field) : ?>
            <?php if (!$field->hidden) : ?><div class="uk-margin"><label class="uk-form-label" for="<?php echo $field->id; ?>"><?php echo strip_tags($field->label); ?></label><div class="uk-form-controls"><?php echo $field->input; ?></div></div><?php else : ?><?php echo $field->input; ?><?php endif; ?>
        <?php endforeach; ?>
        <div class="uk-margin"><label><input class="uk-checkbox" type="checkbox" name="remember" value="yes"> <?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?></label></div>
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?php echo Text::_('JLOGIN'); ?></button>
        <input type="hidden" name="return" value="<?php echo base64_encode((string) $this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>">
        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
    <ul class="uk-list uk-text-small uk-margin-top">
        <li><a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>"><?php echo Text::_('COM_USERS_LOGIN_RESET'); ?></a></li>
        <li><a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>"><?php echo Text::_('COM_USERS_LOGIN_REMIND'); ?></a></li>
    </ul>
</div>
