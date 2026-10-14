<?php

/**
 * Стиль модуля «clean»: заголовок и содержимое. Суффикс класса модуля — на обёртке
 * (в блочной позиции обёртка — колонка сетки, поэтому uk-width-… работает).
 */

\defined('_JEXEC') or die;

$module = $displayData['module'];
$params = $displayData['params'];

if ((string) $module->content === '') {
    return;
}

$tag   = htmlspecialchars((string) $params->get('module_tag', 'div'), ENT_QUOTES, 'UTF-8');
$htag  = htmlspecialchars((string) $params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$sfx   = htmlspecialchars((string) $params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
$hcls  = htmlspecialchars((string) $params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
?>
<<?php echo $tag; ?> id="module-<?php echo (int) $module->id; ?>" class="wm-module <?php echo $sfx; ?>">
    <?php if ($module->showtitle) : ?>
        <<?php echo $htag; ?> class="<?php echo $hcls !== '' ? $hcls : 'uk-h4 uk-heading-bullet'; ?>"><?php echo $module->title; ?></<?php echo $htag; ?>>
    <?php endif; ?>
    <?php echo $module->content; ?>
</<?php echo $tag; ?>>
