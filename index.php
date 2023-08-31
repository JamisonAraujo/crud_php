<?php 

require_once 'App/Core/Core.php';
require_once 'App/Controller/AdminController.php';
require_once 'App/Controller/AboutController.php';
require_once 'App/Controller/ErrorController.php';
require_once 'App/Controller/HomeController.php';
require_once 'App/Controller/PostController.php';
require_once 'App/Model/Post.php';
require_once 'App/Model/Comment.php';
require_once 'lib/Database/Connection.php';

$template = file_get_contents('App/Template/template.html');

ob_start();
    $core = new Core();
    $core->start($_GET);

    $obOutput = ob_get_contents();
ob_end_clean();

echo str_replace('{{dynamic area}}', $obOutput, $template);
