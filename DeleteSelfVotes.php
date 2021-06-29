<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'forum';

// MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Detect connections
if ($conn->connect_error) {
    die("Failed to connect MySQL: " . $conn->connect_error);
}
echo "Connected to MySQL";

// Query origin data
$post_votes = $conn->query("SELECT id, post_id, user_id FROM post_votes");
$posts = $conn->query("SELECT id, user_id FROM posts");
$data_posts=array(array());
while($row = $posts->fetch_assoc()){
    $data_posts[]=$row;
}

// Process data
$ids_to_delete = array();
while($row = $post_votes->fetch_assoc()){
    if($conn->query("SELECT user_id FROM posts WHERE id=".$row["post_id"])->fetch_assoc()["user_id"] == $row["user_id"]){
        $ids_to_delete[] =  $row["id"];
    }
}
/*
var_dump($ids_to_delete);
echo "We will delete these.\n";
foreach($ids_to_delete as $value){
    $conn->query("DELETE FROM post_votes WHERE id=" . $value);
}
echo "Complete deleting votes. Now updating user votes. ";*/

$users=array();
while($row = $conn->query("SELECT id FROM users")->fetch_assoc()){
    $users[]=$row;
}
var_dump($users);
$now_votes=array(array());
while($row = $conn->query("SELECT id, value FROM post_votes")->fetch_assoc()){
    $now_votes[]=$row;
}