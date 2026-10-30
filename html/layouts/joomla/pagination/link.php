<?php

/**
 * Звено постраничной навигации: стрелки UIkit вместо значков ядра, «в начало» и «в конец»
 * не выводятся, ссылка на первую страницу — без «?start=0».
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$item = $displayData['data'];
$text = (string) $item->text;
$rtl  = Factory::getApplication()->getLanguage()->isRtl();
$show = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', mb_strtolower($text));

if ($text === Text::_('JPREV')) {
    $show = '<span uk-pagination-' . ($rtl ? 'next' : 'previous') . '></span>';
    $aria = Text::_('JLIB_HTML_GOTO_POSITION_PREVIOUS');
} elseif ($text === Text::_('JNEXT')) {
    $show = '<span uk-pagination-' . ($rtl ? 'previous' : 'next') . '></span>';
    $aria = Text::_('JLIB_HTML_GOTO_POSITION_NEXT');
} elseif ($text === Text::_('JLIB_HTML_START') || $text === Text::_('JLIB_HTML_END')) {
    return;
}

if ($displayData['active']) {
    $uri = new Uri(html_entity_decode((string) $item->link, ENT_QUOTES, 'UTF-8'));

    foreach (['start', 'limitstart'] as $var) {
        if ((string) $uri->getVar($var) === '0') {
            $uri->delVar($var);
        }
    }

    echo '<li><a href="' . htmlspecialchars($uri->toString(), ENT_QUOTES, 'UTF-8') . '" aria-label="' . htmlspecialchars($aria, ENT_QUOTES, 'UTF-8') . '">' . $show . '</a></li>';
} elseif (!empty($item->active)) {
    echo '<li class="uk-active"><span aria-current="page">' . $show . '</span></li>';
} else {
    echo '<li class="uk-disabled"><span>' . $show . '</span></li>';
}
