<?php
$link = array();

$page = new Page(true, 'Accusé de reception de commande', $link);
$page->build_content($html);
$page->show();
