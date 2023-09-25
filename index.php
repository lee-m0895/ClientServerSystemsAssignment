<?php
$view = new stdClass();
session_start();
$view->pageTitle = 'Homepage';
require_once('Views/index.phtml');
