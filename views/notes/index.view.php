<?php require(base_path('views/partials/head.php')) ?>
<?php require(base_path('views/partials/nav.php')) ?>
<?php require(base_path('views/partials/banner.php')) ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <p>Hello. Welcome to the notes page.</p>

        <ul>
            <?php foreach($notes  as $note) :?>
                <li>
                    <a href="notes/show?id=<?=$note['id']?>"><li class="text-blue-500 hover:underline"><?= htmlspecialchars($note['body']) ?> </li></a>
                </li>
            <?php endforeach ?>
        </ul>
        
        <p class="mt-6">
            <a href="/notes/create" class="text-blue-500 hover:underline">Create Note</a>
        </p>
    </div>
</main>

<?php require(base_path('views/partials/footer.php')) ?>
