<?php

/** Страница ошибки: шапка с меню и понятное сообщение */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$app  = Factory::getApplication();
$wa   = $this->getWebAssetManager();
$wa->getRegistry()->addTemplateRegistryFile('wmarka_clean', 0);
$wa->useStyle('template.wmarka_clean')->useScript('template.wmarka_clean.icons');
$code = (int) $this->error->getCode();
$site = htmlspecialchars((string) $app->get('sitename'), ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $code; ?> — <?php echo $site; ?></title>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>
<body>
<div class="uk-navbar-container"><div class="uk-container"><nav uk-navbar><div class="uk-navbar-left"><a class="uk-navbar-item uk-logo" href="<?php echo Uri::root(true); ?>/"><?php echo $site; ?></a></div><div class="uk-navbar-right uk-visible@m"><jdoc:include type="modules" name="navbar-right" style="none" /></div></nav></div></div>
<main class="uk-section uk-section-large"><div class="uk-container uk-container-small uk-text-center">
    <p class="uk-heading-2xlarge uk-text-muted uk-margin-remove"><?php echo $code ?: 500; ?></p>
    <h1 class="uk-h2"><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></h1>
    <p><?php echo Text::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
    <a class="uk-button uk-button-primary" href="<?php echo Uri::root(true); ?>/"><?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></a>
</div></main>
</body>
</html>
