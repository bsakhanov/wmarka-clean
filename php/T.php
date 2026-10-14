<?php

/**
 * @package     wmarka_clean
 * @copyright   (C) 2026 Webmarka
 * @license     GNU General Public License version 2 or later
 */

namespace WmarkaClean;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

/**
 * Всё, что нужно макетам чистого шаблона, в одном классе без настроек:
 * превью через JUImage, тег <img>, таблицы текста, блочные позиции.
 * Размеры картинок задают сами макеты (intro_image.php, full_image.php).
 */
final class T
{
    private static mixed $ju = false;

    /** Путь картинки из поля Joomla: без «#joomlaImage://…», без адреса сайта */
    public static function src(?string $src): string
    {
        $src = trim(html_entity_decode((string) $src, ENT_QUOTES, 'UTF-8'));
        $src = (string) preg_replace('/#joomlaImage:\/\/.*$/', '', $src);
        $root = Uri::root();

        if ($src !== '' && str_starts_with($src, $root)) {
            $src = substr($src, \strlen($root));
        }

        return ltrim($src, '/');
    }

    /**
     * Превью заданного размера (обрезка по центру, WebP) через JUImage.
     * Нет библиотеки или файла — адрес оригинала.
     */
    public static function thumb(string $src, int $w, int $h): string
    {
        $src = self::src($src);

        if ($src === '') {
            return '';
        }

        if (preg_match('#^(https?:)?//#i', $src)) {
            return $src;
        }

        if (self::$ju === false) {
            self::$ju = null;
            $autoload = JPATH_LIBRARIES . '/juimage/vendor/autoload.php';

            if (is_file($autoload)) {
                require_once $autoload;

                if (class_exists(\JUImage\Image::class)) {
                    self::$ju = new \JUImage\Image(['root_path' => JPATH_ROOT]);
                }
            }
        }

        if (self::$ju && is_file(JPATH_ROOT . '/' . $src)) {
            try {
                $rel = (string) self::$ju->render($src, ['w' => (string) $w, 'h' => (string) $h, 'zc' => '1', 'q' => '80', 'f' => 'webp', 'cache' => 'img']);

                if ($rel !== '' && is_file(JPATH_ROOT . '/' . $rel)) {
                    return Uri::root(true) . '/' . $rel;
                }
            } catch (\Throwable) {
            }
        }

        return Uri::root(true) . '/' . $src;
    }

    /**
     * <img> с набором размеров: $sizes — [[ширина, высота], …], первый — основной.
     * $media — значение атрибута sizes.
     */
    public static function img(string $src, array $sizes, string $alt, string $media = '', string $class = '', bool $eager = false): string
    {
        if (self::src($src) === '') {
            return '';
        }

        [$w, $h] = $sizes[0];
        $set     = [];

        foreach ($sizes as [$sw, $sh]) {
            $set[] = self::thumb($src, $sw, $sh) . ' ' . $sw . 'w';
        }

        $set = array_unique($set);

        return '<img src="' . htmlspecialchars(self::thumb($src, $w, $h), ENT_QUOTES, 'UTF-8') . '"'
            . (\count($set) > 1 ? ' srcset="' . htmlspecialchars(implode(', ', $set), ENT_QUOTES, 'UTF-8') . '"' . ($media !== '' ? ' sizes="' . $media . '"' : '') : '')
            . ' width="' . $w . '" height="' . $h . '" alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') . '"'
            . ($class !== '' ? ' class="' . $class . '"' : '')
            . ($eager ? ' fetchpriority="high"' : ' loading="lazy"') . ' decoding="async">';
    }

    /** Первая картинка материала: вступительная, иначе полная */
    public static function introOf(object $item): array
    {
        $images = json_decode((string) ($item->images ?? $item->core_images ?? ''), true) ?: [];
        $src    = $images['image_intro'] ?? '';
        $alt    = $images['image_intro_alt'] ?? '';

        if (self::src($src) === '') {
            $src = $images['image_fulltext'] ?? '';
            $alt = $images['image_fulltext_alt'] ?? '';
        }

        return [(string) $src, (string) ($alt !== '' ? $alt : ($item->title ?? $item->core_title ?? ''))];
    }

    /**
     * Блочная позиция. Все модули со стилем «blank» — выводятся как есть, каждый сам
     * задаёт секцию; иначе секция с контейнером и сеткой по числу модулей (до 4 колонок).
     * Суффикс класса модуля uk-width-… перебивает ширину колонки.
     */
    public static function block(object $doc, string $position, int $n): string
    {
        $count = (int) $doc->countModules($position);

        if (!$count) {
            return '';
        }

        $bare = true;

        foreach (\Joomla\CMS\Helper\ModuleHelper::getModules($position) as $module) {
            $style = (string) (new \Joomla\Registry\Registry($module->params))->get('style', '');

            if (!preg_match('/-blank$|^none$/', $style)) {
                $bare = false;
                break;
            }
        }

        if ($bare) {
            return '<jdoc:include type="modules" name="' . $position . '" style="none" />';
        }

        $cols = min($count, 4);
        $grid = $cols > 1 ? ' uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-' . $cols . '@m' : ' uk-child-width-1-1';

        return '<section id="' . $position . '" class="uk-section' . ($n % 2 ? ' uk-section-muted' : '') . '"><div class="uk-container">'
            . '<div class="wm-block-grid uk-grid-large' . $grid . '" uk-grid><jdoc:include type="modules" name="' . $position . '" style="clean" /></div>'
            . '</div></section>';
    }

    /**
     * Таблицы текста: классы UIkit, шапка из <th>, на телефоне столбиком с подписями
     * столбцов (data-label); со слиянием ячеек — прокрутка в своём блоке.
     */
    public static function tables(string $html): string
    {
        if (stripos($html, '<table') === false || !class_exists(\DOMDocument::class)) {
            return $html;
        }

        return (string) preg_replace_callback('~<table\b.*?</table>~is', static function (array $m): string {
            if (stripos(substr($m[0], 6), '<table') !== false) {
                return '<div class="uk-overflow-auto">' . $m[0] . '</div>';
            }

            $doc = new \DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="UTF-8"?><html><body>' . $m[0] . '</body></html>', LIBXML_NONET);
            libxml_clear_errors();
            $table = $doc->getElementsByTagName('table')->item(0);

            if (!$table instanceof \DOMElement) {
                return $m[0];
            }

            $xp   = new \DOMXPath($doc);
            $head = $xp->query('./thead/tr[1]/*', $table);

            if (!$head->length) {
                $first = $xp->query('./tbody/tr[1] | ./tr[1]', $table)->item(0);

                if ($first instanceof \DOMElement && $xp->query('./td', $first)->length === 0 && $xp->query('./th', $first)->length > 1) {
                    $thead = $doc->createElement('thead');
                    $table->insertBefore($thead, $table->firstChild);
                    $thead->appendChild($first);
                    $head = $xp->query('./thead/tr[1]/*', $table);
                }
            }

            $labels = [];

            foreach ($head as $cell) {
                if ($cell instanceof \DOMElement && $cell->nodeName === 'td') {
                    $th = $doc->createElement('th');

                    while ($cell->firstChild) {
                        $th->appendChild($cell->firstChild);
                    }

                    $cell->parentNode->replaceChild($th, $cell);
                    $cell = $th;
                }

                $labels[] = trim((string) preg_replace('/\s+/u', ' ', $cell->textContent));
            }

            $rows       = $xp->query('./tbody/tr | ./tr', $table);
            $responsive = $xp->query('.//*[@colspan > 1 or @rowspan > 1]', $table)->length === 0;

            foreach ($rows as $row) {
                if ($labels && $xp->query('./td | ./th', $row)->length !== \count($labels)) {
                    $responsive = false;
                }
            }

            if ($responsive && $labels) {
                foreach ($rows as $row) {
                    foreach ($xp->query('./td', $row) as $j => $td) {
                        if (($labels[$j] ?? '') !== '') {
                            $td->setAttribute('data-label', $labels[$j]);
                        }
                    }
                }
            }

            $table->removeAttribute('width');
            $class = trim($table->getAttribute('class'));
            $table->setAttribute('class', trim((str_contains($class, 'uk-table') ? $class : $class . ' uk-table uk-table-divider uk-table-small') . ($responsive ? ' uk-table-responsive' : '')));

            return '<div class="uk-overflow-auto">' . $doc->saveHTML($table) . '</div>';
        }, $html);
    }
}
