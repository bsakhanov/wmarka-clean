<?php

/** Сайт закрыт: сообщение и вход для администратора */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$app = Factory::getApplication();
$wa  = $this->getWebAssetManager();
$wa->useStyle('template.wmarka_clean');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>
<body>
<main class="uk-section uk-section-large uk-flex uk-flex-middle" uk-height-viewport><div class="uk-container uk-container-xsmall">
    <h1 class="uk-h2"><?php echo htmlspecialchars((string) $app->get('sitename'), ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="uk-text-lead"><?php echo $app->get('display_offline_message', 1) == 1 ? htmlspecialchars((string) $app->get('offline_message'), ENT_QUOTES, 'UTF-8') : Text::_('JOFFLINE_MESSAGE'); ?></p>
    <jdoc:include type="message" />
    <form action="<?php echo Route::_('index.php', true); ?>" method="post" class="uk-card uk-card-default uk-card-body uk-margin-medium-top">
        <div class="uk-margin-small"><input class="uk-input" name="username" type="text" autocomplete="username" placeholder="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" aria-label="<?php echo Text::_('JGLOBAL_USERNAME'); ?>"></div>
        <div class="uk-margin-small"><input class="uk-input" name="password" type="password" autocomplete="current-password" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" aria-label="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>"></div>
        <button type="submit" class="uk-button uk-button-primary uk-width-1-1"><?php echo Text::_('JLOGIN'); ?></button>
        <input type="hidden" name="option" value="com_users"><input type="hidden" name="task" value="user.login"><input type="hidden" name="return" value="<?php echo base64_encode(\Joomla\CMS\Uri\Uri::base()); ?>">
        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
</div></main>
</body>
</html>
