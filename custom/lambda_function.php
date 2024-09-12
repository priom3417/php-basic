<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo</title>
</head>

<body>
    <?php

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

        /* function filterBooks($records, $fn){

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
        });  */


        $books1 = array_filter($books, function($record){
            return $record['releaseYear'] < 2020;
        });

        $books2 = array_filter($books, function($record){
            return $record['releaseYear'] < 2020 && $record['author'] == 'Andy Weir';
        });

        echo "<pre>";
        var_dump($books1);
        var_dump($books2);
        echo "</pre>";

    ?>

    <ul>
        <?php foreach ($books1 as $book) : ?>
            <li>
                <a href="<?= $book['purchaseUrl'] ?>">
                    <?= $book['name']; ?> (<?= $book['releaseYear'] ?>) - By <?= $book['author'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>