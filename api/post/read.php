<?php 
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    //

    $database = new Database();
    $db = $database->connect();
    //
    $post = new Post($db);
    //get id
    $post->id = isset($_GET['id']) ? $_GET['id'] : 0;

    if($post->id) {
    // get post single
    $post->read_single();

    //create array json
    $post_arr = array(
        'id' =>$post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    print_r(json_encode($post_arr));
    
    } else {
        $result = $post->read();

    $num = $result->rowCount();

    //Check if any posts
    if($num >0 ) {
        $posts_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'body' => html_entity_decode($body),
                'author' => $author,
                'category_id' => $category_id,
                'category_name' => $category_name
            );

            //push

            array_push($posts_arr['data'], $post_item);
        }

        //JSON
        echo json_encode($posts_arr);

    } else {
        echo json_encode(
            array('message' => 'No posts found')
        );
    }
    }
    ?>
