<?php

/** Только компонент: печать, окна, всплывающие формы */

\defined('_JEXEC') or die;

$this->getWebAssetManager()->useStyle('template.wmarka_clean')->useScript('template.wmarka_clean.icons');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>
<body class="uk-padding">
    <jdoc:include type="message" />
    <jdoc:include type="component" />
</body>
</html>
