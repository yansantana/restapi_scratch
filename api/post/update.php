<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Wtih');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //

    $database = new Database();
    $db = $database->connect();
    //
    $post = new Post($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //set id
    $post->id = $data->id;

    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    //update
    if($post->update()) {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    } else {
        array('message' => 'Post Not Updated');
    }


