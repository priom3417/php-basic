# PHP Basics

## Table of Contents
- [Lambda Functions](#lambda-functions)
- [PHP Router](#php-router)
- [Commpnly Used PHP functions](#array_map)
    - [array_map()](#array_map)


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



## array_map()

### Description
`array_map(?callable $callback, array $array, array ...$arrays): array`

The `array_map()` function in PHP returns an array containing the results of applying a callback function to each element of an input array. When multiple arrays are used, the function applies the callback in parallel to each set of corresponding elements.

---

### Example #1: Basic array_map() Example

```php
function cube($n) {
    return $n * $n * $n;
}

$a = [1, 2, 3, 4, 5];
$b = array_map('cube', $a);
print_r($b);
```

**Output:**

```plaintext
Array
(
    [0] => 1
    [1] => 8
    [2] => 27
    [3] => 64
    [4] => 125
)
```

---

### Example #2: Using a Lambda Function with array_map()

```php
$func = function(int $value): int {
    return $value * 2;
};

print_r(array_map($func, range(1, 5)));

// Or with PHP 7.4+:
print_r(array_map(fn($value): int => $value * 2, range(1, 5)));
```

**Output:**

```plaintext
Array
(
    [0] => 2
    [1] => 4
    [2] => 6
    [3] => 8
    [4] => 10
)
```

---

### Example #3: Using Multiple Arrays

```php
function show_Spanish(int $n, string $m): string {
    return "The number {$n} is called {$m} in Spanish";
}

$a = [1, 2, 3, 4, 5];
$b = ['uno', 'dos', 'tres', 'cuatro', 'cinco'];

$c = array_map('show_Spanish', $a, $b);
print_r($c);
```

**Output:**

```plaintext
Array
(
    [0] => The number 1 is called uno in Spanish
    [1] => The number 2 is called dos in Spanish
    [2] => The number 3 is called tres in Spanish
    [3] => The number 4 is called cuatro in Spanish
    [4] => The number 5 is called cinco in Spanish
)
```
Usually, when using two or more arrays, they should be of equal length because the callback function is applied in parallel to the corresponding elements. If the arrays are of unequal length, shorter ones will be extended with empty elements to match the length of the longest.

An interesting use of this function is to construct an array of arrays, which can be easily performed by using null as the name of the callback function.

---

### Example #4: Performing a Zip Operation with Null Callback

```php
$a = [1, 2, 3, 4, 5];
$b = ['one', 'two', 'three', 'four', 'five'];
$c = ['uno', 'dos', 'tres', 'cuatro', 'cinco'];

$d = array_map(null, $a, $b, $c);
print_r($d);
```

**Output:**

```plaintext
Array
(
    [0] => Array ( [0] => 1 [1] => one [2] => uno )
    [1] => Array ( [0] => 2 [1] => two [2] => dos )
    [2] => Array ( [0] => 3 [1] => three [2] => tres )
    [3] => Array ( [0] => 4 [1] => four [2] => cuatro )
    [4] => Array ( [0] => 5 [1] => five [2] => cinco )
)
```

---

### Example #5: Using array_map() with Associative Arrays

```php
$arr = [
    'v1' => 'First release',
    'v2' => 'Second release',
    'v3' => 'Third release',
];

$callback = fn(string $k, string $v): string => "$k was the $v";

$result = array_map($callback, array_keys($arr), array_values($arr));

var_dump($result);
```

**Output:**

```plaintext
array(3) {
  [0] => string(24) "v1 was the First release"
  [1] => string(25) "v2 was the Second release"
  [2] => string(24) "v3 was the Third release"
}
```

---

### Problem Example

Given a dataset, extract the names of all non-smokers.

```php
$data = [
    ["name" => "John", "smoker" => false],
    ["name" => "Mary", "smoker" => true],
    ["name" => "Peter", "smoker" => false],
    ["name" => "Tony", "smoker" => true]
];

$names = array_filter(array_map(function($n) {
    if (!$n['smoker']) return $n['name'];
}, $data));

print_r($names);
```

**Output:**

```plaintext
Array
(
    [0] => John
    [2] => Peter
)
```
