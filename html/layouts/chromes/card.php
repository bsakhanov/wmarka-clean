<?php

/** Стиль модуля «card»: белая карточка UIkit */

\defined('_JEXEC') or die;

$module = $displayData['module'];
$params = $displayData['params'];

if ((string) $module->content === '') {
    return;
}

$htag = htmlspecialchars((string) $params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$sfx  = htmlspecialchars((string) $params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8');
?>
<div id="module-<?php echo (int) $module->id; ?>" class="wm-module <?php echo $sfx; ?>">
    <div class="uk-card uk-card-default uk-card-body uk-card-small">
        <?php if ($module->showtitle) : ?><<?php echo $htag; ?> class="uk-card-title"><?php echo $module->title; ?></<?php echo $htag; ?>><?php endif; ?>
        <?php echo $module->content; ?>
    </div>
</div>
