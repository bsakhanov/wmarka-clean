<?php

/** «Читать дальше» */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$params = $displayData['params'];
$item   = $displayData['item'];
$link   = $displayData['link'];
?>
<p class="uk-margin-small-top uk-margin-remove-bottom"><a class="uk-button uk-button-text" href="<?php echo $link; ?>" aria-label="<?php echo htmlspecialchars(Text::sprintf('JGLOBAL_READ_MORE_TITLE', $item->title), ENT_QUOTES, 'UTF-8'); ?>"><?php echo Text::_('JGLOBAL_READ_MORE'); ?></a></p>
