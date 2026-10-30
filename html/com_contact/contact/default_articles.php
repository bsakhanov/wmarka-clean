<?php

/**
 * Материалы автора (контакта) с листалкой.
 *
 * Ядро выводит на странице контакта только последние N материалов («Количество материалов»,
 * articles_display_num) без постраничной навигации. Здесь запрос ядра повторён с подсчётом
 * и смещением: N на страницу, остальные — листалкой (?start=N). Условия выборки как у ядра;
 * при одинаковой дате порядок задаёт номер материала, чтобы страницы не пересекались.
 * Неровный или лишний номер страницы постоянно перенаправляется на настоящую страницу.
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Pagination\Pagination;
use Joomla\CMS\Router\Route;
use Joomla\Component\Contact\Site\Helper\RouteHelper as ContactRoute;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\Database\DatabaseInterface;
use Joomla\Database\ParameterType;

$item = $this->item;

if (!$this->params->get('show_articles') || empty($item->articles) || !(int) $item->user_id) {
    return;
}

$app = Factory::getApplication();
$db  = Factory::getContainer()->get(DatabaseInterface::class);

// «Количество материалов»: пункт меню → контакт → общие настройки контактов (как в ядре)
$limit = $this->params->get('articles_display_num', 10);

if ($limit === 'use_contact') {
    $limit = $item->params->get('articles_display_num', 10);

    if ((string) $limit === '') {
        $limit = ComponentHelper::getParams('com_contact')->get('articles_display_num', 10);
    }
}

$limit     = max(1, (int) $limit);
$published = $this->state->get('filter.published');
$now       = Factory::getDate()->toSql();

$base = static function () use ($db, $item, $app, $published, $now) {
    $query = $db->createQuery()
        ->from($db->quoteName('#__content', 'a'))
        ->where($db->quoteName('a.created_by') . ' = :author')
        ->whereIn($db->quoteName('a.access'), $app->getIdentity()->getAuthorisedViewLevels())
        ->bind(':author', $item->user_id, ParameterType::INTEGER);

    if (Multilanguage::isEnabled()) {
        $query->whereIn($db->quoteName('a.language'), [$app->getLanguage()->getTag(), '*'], ParameterType::STRING);
    }

    if (is_numeric($published)) {
        $query->where('a.state IN (1,2)')
            ->where('(' . $db->quoteName('a.publish_up') . ' IS NULL OR ' . $db->quoteName('a.publish_up') . ' <= :now1)')
            ->where('(' . $db->quoteName('a.publish_down') . ' IS NULL OR ' . $db->quoteName('a.publish_down') . ' >= :now2)')
            ->bind([':now1', ':now2'], $now);
    }

    return $query;
};

$total = (int) $db->setQuery($base()->select('COUNT(*)'))->loadResult();
$input = $app->getInput();
$start = (int) $input->getUint('limitstart', $input->getUint('start', 0));
$page  = (int) (floor(min($start, max(0, $total - 1)) / $limit) * $limit);

if ($page !== $start) {
    $app->redirect(Route::_(ContactRoute::getContactRoute($item->slug, $item->catid, $item->language) . ($page ? '&limitstart=' . $page : ''), false), 301);
}

$articles = $db->setQuery(
    $base()
        ->select($db->quoteName(['a.id', 'a.title', 'a.alias', 'a.catid', 'a.language', 'a.publish_up', 'a.images']))
        ->order($db->quoteName('a.publish_up') . ' DESC, ' . $db->quoteName('a.id') . ' DESC')
        ->setLimit($limit, $page)
)->loadObjectList();

foreach ($articles as $article) {
    $slug          = $article->alias !== '' ? $article->id . ':' . $article->alias : (string) $article->id;
    $article->link = Route::_(RouteHelper::getArticleRoute($slug, $article->catid, $article->language));
}

echo LayoutHelper::render('clean.list', ['items' => $articles]);

if ($total > $limit) {
    $pagination = new Pagination($total, $page, $limit);

    echo $pagination->getPagesLinks();
    echo '<p class="uk-text-meta uk-text-center uk-margin-small-top">' . $pagination->getPagesCounter() . '</p>';
}
