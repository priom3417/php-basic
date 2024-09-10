<?php require('partials/head.php') ?>
<?php require('partials/nav.php') ?>
<?php require('partials/banner.php') ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello. Welcome to the notes page.</p>

        <?php foreach($notes  as $note) :?>
            <a href="note?id=<?=$note['id']?>"><li class="text-blue-500 hover:underline"><?= $note['body'] ?> </li></a>
        <?php endforeach ?>

    </div>
</main>

<?php require('partials/footer.php') ?>
