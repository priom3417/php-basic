# PHP Basics

## Table of Contents
- [Lambda Functions](#lambda-functions)
- [PHP Router](#php-router)

## Lambda Functions

A Lambda function is an anonymous PHP function that can be stored in a variable and passed as an argument to other functions. Anonymous functions are also known as Closures. A Lambda function has no specific name.

### Syntax
```php
$var = function ($arg1, $arg2) { return $val; }; // No specific name. Stored in a variable.
```

### Example 1
```php
$arr1 = [4, 12, 6, 23, 16, 20];

$sum = function($arr){ //Function stored in a variable
    $s = 0;
    for($i = 0; $i < sizeof($arr); $i++){
        $s += $arr[$i];
    }
    return $s;
};

echo $sum($arr1); //Invoking the function variable
```

### Example 2

**Filtering records from an associative array depending on a custom condition**:

Let's take the following associative array of books:

```php
$books = [
    [
        'name' => 'Do Androids Dream of Electric Sheep',
        'author' => 'Philip K. Dick',
        'releaseYear' => 2011,
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
```

Now, let's write a function that can be used to filter the books by the author name, book name, or by the release year.

```php
function filterBooks($records, $key, $search){
    $arr = [];
    foreach($records as $record){
        if($record[$key] == $search){
            $arr[] = $record;
        }
    }
    return $arr;
}

$books1 = filterBooks($books, 'author', 'Andy Weir');
$books2 = filterBooks($books, 'releaseYear', 2011);
```

So, the above function will be able to filter the books by the author name, book name, or release year. But, what if we want to filter the books that were released before 2020? What if we want to filter the books where the author name is X and released before YYYY?

In that case, we can use a Lambda function so that the `filterBooks()` function can accept a function as a parameter and perform custom filtering.

```php
function filterBooks($records, $fn){
    $arr = [];
    foreach($records as $record){
        if($fn($record)){
            $arr[] = $record;
        }
    }
    return $arr;
}

$books1 = filterBooks($books, function($record){
    return $record['releaseYear'] < 2020;
});

$books2 = filterBooks($books, function($record){
    return $record['releaseYear'] < 2020 && $record['author'] == 'Andy Weir';
});
```

PHP has a built-in function called `array_filter()` that does the same thing as the `filterBooks()` function. It accepts a function as the second parameter.

```php
$books1 = array_filter($books, function($record){
    return $record['releaseYear'] < 2020;
});

$books2 = array_filter($books, function($record){
    return $record['releaseYear'] < 2020 && $record['author'] == 'Andy Weir';
});
```

---

## PHP Router

### Why Do We Need a Router?

While browsing the web, you may have seen some website URLs with a `.php` extension. In the URL, you might see the file path of the web page, like `/server/customer/profile.php`. A router helps hide the actual file path and file extension of a web page. For example, `https://domain.com/profile` will load the content from `https://domain.com/server/customer/profile.php`.

### Approach

First, we need to centralize all HTTP requests to a single file. This means that a single file will be responsible for handling all the HTTP requests for a website. Let's assume the file is `index.php`. This file will be responsible for loading the web content depending on the route. For example, if a user hits the URL `https://domain.com/profile`, it will first redirect the request to `index.php`. The `index.php` file will check the URI (`/profile`) and load the content from `server/customer/profile.php`.

### Step 1: Centralizing All HTTP Requests

This is done by configuring the PHP server. Depending on the server you use, you'll need to make some tweaks.

#### Redirect Using Apache

Add the following directives to your `.htaccess` file:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php
```

- **Line 1**: Activates Apache's runtime rewriting engine.
- **Line 2**: Limits access to physical files.
- **Line 3**: Redirects all requests to `index.php`.

If the site or app is not at the root of the server, here's what the `.htaccess` file should look like:

```
RewriteEngine On
RewriteBase /folder/
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /folder/index.php [L]
```

In the code above, replace `/folder/` with the name of the folder containing your site.

Now, all HTTP requests will be redirected to `index.php`.

### Step 2: Creating the Routing System

Next, let's create a variable that will contain the URI of the HTTP request.

```php
$route = $_SERVER['REQUEST_URI'];
```

This route will help determine which file to load based on the route.

#### Example

```php
switch ($route) {
    case '/profile':
        require __DIR__ . '/server/customer/profile.php';
        break;
        
    case '/order':
        require __DIR__ . '/server/customer/order.php';
        break;
}
```
