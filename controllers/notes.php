<?php


$heading = 'Notes';

$db = new Database();

$notes = $db->query("SELECT * FROM posts")->get();

require "views/notes.view.php";