# PHP Basics

## Table of Contents
- [Lambda Functions](#lambda-functions)

## Lambda Functions

A Lambda function is an anonymous PHP function that can be stored in a variable and passed as an argument to other functions. Anonymous functions are also known as Closures. A Lambda function has no specific name.

### Syntax
```php
$var = function ($arg1, $arg2) { return $val; }; // No specific name. Stored in a variable.
```

### Example 1
```php
$arr1 = [4, 12, 6, 23, 16, 20];

$sum = function($arr){
    $s = 0;
    for($i = 0; $i < sizeof($arr); $i++){
        $s += $arr[$i];
    }
    return $s;
};

echo $sum($arr1);
```

### Example 2

1. **Filtering records from an associative array depending on a custom condition**:

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

   Now, let's write a function that can be used to filter the books by the author name, book name or by the release year.

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

   So, the above function will be able to filter the books by the author name, book name or by the release year. But, what if we want to filter the books that released before 2020? What if we want to filter the books where author name is X and released before YYYY? In that case, we can use a Lambda function so that the `filterBooks` function can accepts a Lambda function as a parameter and can perform custom filtering.

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