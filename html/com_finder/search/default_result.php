<?php

/** Результат умного поиска: миниатюра (если есть), заголовок, описание, адрес */

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$r     = $this->result;
$link  = Route::_($r->route);
$image = ($r->imageUrl ?? '') !== '' ? T::img((string) $r->imageUrl, [[360, 203]], (string) ($r->imageAlt ?? $r->title)) : '';
?>
<li class="uk-margin-medium-bottom">
    <div class="uk-grid-small" uk-grid>
        <?php if ($image !== '') : ?><div class="uk-width-1-3 uk-width-1-4@m"><a href="<?php echo $link; ?>" tabindex="-1" aria-hidden="true"><?php echo $image; ?></a></div><?php endif; ?>
        <div class="uk-width-expand">
            <h3 class="uk-h4 uk-margin-remove"><a class="uk-link-heading" href="<?php echo $link; ?>"><?php echo htmlspecialchars((string) $r->title, ENT_QUOTES, 'UTF-8'); ?></a></h3>
            <?php if (!empty($r->description)) : ?><p class="uk-margin-small-top uk-margin-remove-bottom"><?php echo htmlspecialchars(mb_strimwidth(trim(strip_tags((string) $r->description)), 0, 220, '…'), ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
            <p class="uk-text-meta uk-margin-remove"><?php echo htmlspecialchars(rtrim(Uri::root(), '/') . $link, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
</li>
