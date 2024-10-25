<?php


$heading = 'Note';

$db = new Database();

$note = $db->query("SELECT * FROM posts WHERE id = :id", 

    [':id' => $_GET['id']]
    
)->findOrFail();

$current_user = 1;

authorize($note['user_id'] == $current_user, Response::FORBIDDEN);

require base_path("views/notes/show.view.php");