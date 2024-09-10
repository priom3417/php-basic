<?php

function dd($value){
    echo "<pre>";

    var_dump($value);

    echo "</pre>";
    
    die();
}

function urlIs($value) {
    return parse_url($_SERVER['REQUEST_URI'])['path'] === $value;
}

function abort($code = 404, $msg = "404 Not found!"){
    http_response_code($code);
    if($code == 403){
        require "views/403.php";
    }
    else{
        require "views/404.php";
    }
    die();
}

function routeToController($uri, $routes){
    if(array_key_exists($uri, $routes)){
        require $routes[$uri];
    }
    else{
        abort();
    }
}

function authorize($condition, $code){

    if(!$condition){
        abort($code);
    }

}

$books = [
    [
        'name' => 'Do Androids Dream of Electric Sheep',
        'author' => 'Philip K. Dick',
        'releaseYear' => 1968,
        'purchaseUrl' => 'http://example.com'
    ],
    [
        'name' => 'Project Hail Mary',
        'author' => 'Andy Weir',
        'releaseYear' => 2021,
        'purchaseUrl' => 'http://example.com'
    ],
    [
        'name' => 'The Martian',
        'author' => 'Andy Weir',
        'releaseYear' => 2011,
        'purchaseUrl' => 'http://example.com'
    ],
];

function filter($books, $fn){
    $data = [];

    foreach($books as $book){
        if($fn($book)){
            $data[] = $book;
        }
    }

    return $data;
}

$filtered_books = filter($books, function ($data){
    if($data['author'] == 'Andy Weir'){
        return true;
    }
    else{
        return false;
    }
});

//dd($filtered_books);
