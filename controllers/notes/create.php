<?php

$heading = "Create Notes";

$db = new Database();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(Validator::string($_POST['body'], 1, 1000)){
        $db->query("INSERT INTO posts (body, user_id) VALUES(:body, :user_id)", [
            'body' => $_POST['body'],
            'user_id' => 1
        ]);
    } else{
        $errors['body'] = 'The body parameter should be between (1, 1000)';
    }
}

require base_path("views/notes/create.view.php");