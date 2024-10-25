<?php


$heading = 'Notes';

$db = new Database();

$notes = $db->query("SELECT * FROM posts")->get();

require base_path("views/notes/index.view.php");