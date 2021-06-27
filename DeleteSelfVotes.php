<?php
echo "MySQL server name:";
$servername = fgets(STDIN);
echo "MySQL username:";
$username = fgets(STDIN);
echo "MySQL password:";
$password = fgets(STDIN);
echo "Flarum database:";
$dbname = fgets(STDIN);

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
$data_posts = $posts -> fetch_assoc();

// Process data
$ids_to_delete = array();
while($data_post_votes = $post_votes->fetch_assoc()){
    $uid = $data_post_votes["user_id"];
    if($uid == array_search($uid, array_column($data_posts, 'user_id'))["user_id"]){
        $ids_to_delete[] =  $data_post_votes["id"];
    }
}

// Show result
while($row = $post_votes->fetch_assoc()){
    if(in_array($row["id"], $ids_to_delete)){
        echo "ID" . $row["id"] . "user_id" . $row["user_id"];
    }
}
echo "We will delete these.";





