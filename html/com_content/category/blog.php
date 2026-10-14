<?php

/** Блог категории: см. layouts/clean/blog.php */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;

$p       = $this->params;
$heading = $p->get('show_page_heading') ? (string) $p->get('page_heading') : ($p->get('show_category_title', 1) ? (string) $this->category->title : '');
$desc    = $p->get('show_description', 1) ? HTMLHelper::_('content.prepare', (string) $this->category->description, '', 'com_content.category') : '';

// Свойства вида защищены (protected): передаём их в макет отсюда, изнутри вида
echo LayoutHelper::render('clean.blog', ['lead' => $this->lead_items, 'intro' => $this->intro_items, 'links' => $this->link_items, 'pagination' => $this->pagination, 'params' => $p, 'heading' => $heading, 'description' => $desc]);
