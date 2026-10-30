<?php

/**
 * Постраничная навигация UIkit. В данных ядра active = «можно перейти» (ссылка),
 * а текущая страница приходит с active = false.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

$pages = $displayData['list']['pages'] ?? [];

if (empty($pages['pages']) || \count($pages['pages']) < 2) {
    return;
}

$li = static function (array $p, string $icon = ''): string {
    $data = $p['data'] ?? null;

    if (!\is_object($data)) {
        return '';
    }

    $text = $icon !== '' ? '<span ' . $icon . '></span>' : htmlspecialchars((string) $data->text, ENT_QUOTES, 'UTF-8');
    $aria = $icon !== '' ? ' aria-label="' . htmlspecialchars(strip_tags((string) $data->text), ENT_QUOTES, 'UTF-8') . '"' : '';

    if (!empty($p['active']) && !empty($data->link)) {
        // Первая страница — без «?start=0»: у неё один адрес, тот же, что у самого списка
        $uri = new \Joomla\CMS\Uri\Uri(html_entity_decode((string) $data->link, ENT_QUOTES, 'UTF-8'));

        foreach (['start', 'limitstart'] as $var) {
            if ((string) $uri->getVar($var) === '0') {
                $uri->delVar($var);
            }
        }

        return '<li><a href="' . htmlspecialchars($uri->toString(), ENT_QUOTES, 'UTF-8') . '"' . $aria . '>' . $text . '</a></li>';
    }

    return '<li class="' . ($icon !== '' ? 'uk-disabled' : 'uk-active') . '"><span' . $aria . '>' . $text . '</span></li>';
};
?>
<nav class="uk-margin-large-top" aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>">
    <ul class="uk-pagination uk-flex-center">
        <?php echo $li($pages['previous'] ?? [], 'uk-pagination-previous'); ?>
        <?php foreach ($pages['pages'] as $page) : ?>
            <?php echo $li($page); ?>
        <?php endforeach; ?>
        <?php echo $li($pages['next'] ?? [], 'uk-pagination-next'); ?>
    </ul>
</nav>
