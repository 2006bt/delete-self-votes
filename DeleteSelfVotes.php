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
    $uid = $row["user_id"];
    if($uid == array_search($uid, array_column($data_posts, 'user_id'))){
        $ids_to_delete[] =  $row["id"];
    }
}

// Show result
while($row = $post_votes->fetch_assoc()){
    if(in_array($row["id"], $ids_to_delete)){
        echo "ID" . $row["id"] . "user_id" . $row["user_id"] . "\n";
    }
}
echo "We will delete these.";





