<?php

/** Избранные материалы: тот же блог, что и у категории (layouts/clean/blog.php) */

\defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;

$heading = $this->params->get('show_page_heading') ? (string) $this->params->get('page_heading') : '';

// Свойства вида защищены (protected): передаём их в макет отсюда, изнутри вида
echo LayoutHelper::render('clean.blog', ['lead' => $this->lead_items, 'intro' => $this->intro_items, 'links' => $this->link_items, 'pagination' => $this->pagination, 'params' => $this->params, 'heading' => $heading, 'description' => '']);
