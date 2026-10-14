<?php

/** Контакт: фото, имя и должность, адрес и связь, форма письма. Подробности — штатными подмакетами ядра */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use WmarkaClean\T;

require_once JPATH_THEMES . '/wmarka_clean/php/T.php';

$c = $this->item;
$p = $this->params;
?>
<div class="wm-contact">
    <div class="uk-grid-medium uk-flex-middle uk-margin-medium-bottom" uk-grid>
        <?php if ($c->image && $p->get('show_image', 1)) : ?>
            <div class="uk-width-auto"><?php echo T::img((string) $c->image, [[200, 200]], (string) $c->name, '', 'uk-border-circle'); ?></div>
        <?php endif; ?>
        <div class="uk-width-expand">
            <h1 class="uk-heading-small uk-margin-remove"><?php echo htmlspecialchars((string) $c->name, ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if ($c->con_position && $p->get('show_position', 1)) : ?><p class="uk-text-lead uk-margin-small-top"><?php echo htmlspecialchars((string) $c->con_position, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
        </div>
    </div>
    <div class="uk-grid-large" uk-grid>
        <div class="uk-width-1-1 uk-width-1-2@m">
            <?php echo $this->loadTemplate('address'); ?>
            <?php if ($c->misc && $p->get('show_misc', 1)) : ?><div class="uk-margin-top"><?php echo HTMLHelper::_('content.prepare', $c->misc, '', 'com_contact.contact'); ?></div><?php endif; ?>
        </div>
        <?php if ($p->get('show_email_form', 1) && ($c->email_to || $c->user_id)) : ?>
            <div class="uk-width-1-1 uk-width-1-2@m"><div class="uk-card uk-card-default uk-card-body"><?php echo $this->loadTemplate('form'); ?></div></div>
        <?php endif; ?>
    </div>
    <?php if ($p->get('show_articles') && $c->user_id && !empty($c->articles)) : ?><div class="uk-margin-large-top"><?php echo $this->loadTemplate('articles'); ?></div><?php endif; ?>
</div>
