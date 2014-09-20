<?php
//Testing commit
error_reporting(E_ALL);
//Good to set these
ini_set('default_charset', 'utf-8');
ini_set('display_errors', '1');
ini_set('session.use_trans_sid', false);
ini_set('session.use_only_cookies', true);
ini_set('url_rewriter.tags', '');
session_start();
define("DOCROOT", $_SERVER['DOCUMENT_ROOT'] . '/');
define('SYSTEM_PATH',DOCROOT.'system/');
define('CORE_PATH',SYSTEM_PATH.'core/');
define('CLASSES_PATH',SYSTEM_PATH.'classes/');
define('MODELS_PATH',SYSTEM_PATH.'models/');
define('EMAILS_PATH',SYSTEM_PATH.'email_templates/');
define('LIBRARIES_PATH',SYSTEM_PATH.'libraries/');
//Include Core Files
//include($_SERVER['DOCUMENT_ROOT'] . '/views/index.php');
//Include class files
require_once (CLASSES_PATH . 'vija.php');
//Load Libraries
require_once (LIBRARIES_PATH . 'Slim/Slim.php');
require_once (LIBRARIES_PATH . 'phpmailer/class.phpmailer.php');
//AND AWAY WE GO
require_once (CORE_PATH . 'router.php');