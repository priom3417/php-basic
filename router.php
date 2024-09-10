<?php

$routes = [
    '/php/' => 'controllers/index.php',
    '/php/about' => 'controllers/about.php',
    '/php/contact' => 'controllers/contact.php',
    '/php/notes' => 'controllers/notes.php',
    '/php/note' => 'controllers/note.php',
];

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
routeToController($uri, $routes);