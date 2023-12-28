<?php
// Exit if accessed directly

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

global $loader;
global $twig;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig   = new Environment($loader, [
 'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
