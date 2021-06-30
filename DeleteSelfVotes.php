<?php
// MySQL连接信息
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'forum';

// 连接并检测MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Failed to connect MySQL: " . $conn->connect_error);
}
echo "Connected to MySQL\n";

// 查询原始数据
$post_votes = $conn->query("SELECT id, post_id, user_id FROM post_votes");
$posts = $conn->query("SELECT id, user_id FROM posts");
$data_posts=array(array());
while($row = $posts->fetch_assoc()){
    $data_posts[]=$row;
}

// 处理数据
/*
$ids_to_delete = array();
while($row = $post_votes->fetch_assoc()){
    if($conn->query("SELECT user_id FROM posts WHERE id=".$row["post_id"])->fetch_assoc()["user_id"] == $row["user_id"]){
        $ids_to_delete[] =  $row["id"];
    }
}

var_dump($ids_to_delete);
echo "We will delete these.\n";
foreach($ids_to_delete as $value){
    $conn->query("DELETE FROM post_votes WHERE id=" . $value);
}*/
echo "Complete deleting votes. Now updating user votes. \n";

// 修改user votes
$now_votes=$conn->query("SELECT user_id, value FROM post_votes");
//$new_user_votes=array(array(),array());
while($row = $now_votes->fetch_assoc()){
    if(isset($new_user_votes)){
        if(in_array($row["user_id"],array_column($new_user_votes,"id"))){ //假如数组中已存在此用户
            if($row["value"] == 1){
                for ($i = 0; $i < count($new_user_votes); ++ $i) { //修改数组 new
                    if($new_user_votes[$i]["id"]==$row["user_id"]){
                        $new_user_votes[$i]["votes"]++;
                    }
                }
            }else{
                for ($i = 0; $i < count($new_user_votes); ++ $i) { //修改数组 new
                    if($new_user_votes[$i]["id"]==$row["user_id"]){
                        $new_user_votes[$i]["votes"]--;
                    }
                }
            }
            /*foreach($new_user_votes as $i){ //修改数组
                if($i["id"] == $row["user_id"]){
                    if($row["value"] == 1){
                        $i["votes"]++;
                    }else{
                        $i["votes"]--;
                    }
                }
            }*/
        }else{ //如果不存在，则创建
            $new_user_votes[]=array(
                "id"=>$row["user_id"],
                "votes"=>$row["value"]
            );
        }
    }else{
        $new_user_votes=array(
            array("id"=>$row["user_id"]),
            array("votes"=>$row["value"])
        );
    }
}
var_dump($new_user_votes);