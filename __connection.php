<?php
// object  = new classname();
$db_host = 'localhost';
$db_user = 'root';
$db_password = "";
$db_name = 'db_passion_seekers';
$con = mysqli_connect('localhost','root','','db_passion_seekers');
//database connection
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);
$connection_status = $connection->connect_errno == 0 ? "Connected" : "Not Connected";

//database connection error check
if ($connection->connect_errno != 0) {
  die('Database Connection Error : ' . $connection->connect_error);
}

function mysqlLoginQuery($username, $password)
{
  $query = "SELECT * FROM tbl_users WHERE username='$username' AND password='$password' AND status=1";
  return $query;
}

function mysqlGetUserById($id, $admin = false)
{
  $isAdmin = $admin ? "`tbl_admins`" : "`tbl_users`";
  $query = "SELECT * FROM " . $isAdmin . " WHERE id='$id';";
  return $query;
}

function mysqlLoginQueryAdmin($username, $password)
{
  $query = "SELECT * FROM tbl_admins WHERE username='$username' AND password='$password' AND status=1";
  return $query;
}

function mysqlisAdmin($id, $username)
{
  $query = "SELECT * FROM tbl_admins WHERE username='$username' AND status=1 AND id=$id";
  return $query;
}

//Query for Signup USERS
function mysqlSignUp($name = '', $username, $password, $email, $phoneNumber = '', $address = '')
{
  $query = "INSERT INTO `tbl_users`(`name`, `username`, `password`, `email`, `phone_number`, `address`) VALUES ('$name','$username','$password','$email','$phoneNumber','$address')";
  return $query;
}

//Quey to Signup ADMIN
function mysqlSignUpAdmin($name = '', $username, $password, $email, $phoneNumber = '', $address = '')
{
  $query = "INSERT INTO `tbl_admins`(`name`, `username`, `password`, `email`, `phone_number`, `address`) VALUES ('$name','$username','$password','$email','$phoneNumber','$address')";
  return $query;
}

//Query to check Username USERS[]
function mysqlCheckUsersUsername($username)
{
  $query = "SELECT * FROM tbl_users WHERE `username`='$username'";
  return $query;
}

//Query to check Email USERS
function mysqlCheckUsersEmail($email)
{
  $query = "SELECT * FROM tbl_users WHERE `email`='$email'";
  return $query;
}

//Query to check Username ADMIN
function mysqlCheckAdminsUsername($username)
{
  $query = "SELECT * FROM `tbl_admins` WHERE `username`='$username'";
  return $query;
}

//Query to check email ADMIN
function mysqlCheckAdminsEmail($email)
{
  $query = "SELECT * FROM `tbl_admins` WHERE `email`='$email'";
  return $query;
}

function mysqlCreatePost($title, $description, $adminId, $lattitude, $longitude, $typeOfActivity)
{
  $query = "INSERT INTO `tbl_location`(`title`, `description`, `admin_id`, `lattitude`, `longitude`,`type_of_activity`) VALUES (\"$title\",\"" . str_replace('"', '\"', $description) . "\",'$adminId','$lattitude','$longitude',\"$typeOfActivity\")";
  return $query;
}

function mysqlAddImage($image, $locationId)
{
  $query = "INSERT INTO `tbl_images`(`image`, `location_id`) VALUES ('$image',$locationId)";
  return $query;
}

function mysqlRemoveAllImagesByLocationId($id)
{
  $query = "DELETE FROM `tbl_images` WHERE location_id=$id";
  return $query;
}

function mysqlRemovePostAndImages($id)
{
  $query = "DELETE FROM `tbl_location` WHERE id=$id";
  $query1 = mysqlRemoveAllImagesByLocationId($id);

  return [$query, $query1];
}

function mysqlGetPost($id, $admin = false)
{
  $query = "SELECT 
              l.id,l.title, 
              l.description, 
              a.username, 
              l.lattitude, 
              l.longitude, 
              l.type_of_activity,
              l.created_at,
              l.status,
              l.type_of_activity
            FROM   
              `tbl_location` AS l ,`tbl_admins` AS a
            WHERE 
              l.admin_id = a.id AND l.id=$id AND l.status=true";

  $query1 = "SELECT `image` FROM `tbl_images` WHERE location_id=$id";

  if ($admin) {
    $query = "SELECT l.id,l.title, l.description, a.username, l.lattitude, l.longitude,l.type_of_activity,l.created_at,l.status 
            FROM   `tbl_location` AS l ,`tbl_admins` AS a
            WHERE l.admin_id = a.id AND l.id=$id";
  }
  return [$query, $query1];
}

function mysqlUpdatePost($id, $title, $description, $lattitude, $longitude, $typeOfActivity, $status)
{
  $dateNow = date('Y:m:d') . " " . date('H:i:s');
  $query = "UPDATE
    `tbl_location`
SET
    `title` = \"$title\",
    `description` = \"$description\",
    `lattitude` = $lattitude,
    `longitude` = $longitude,
    `status` = $status,
    `updated_at` = '$dateNow',
    `type_of_activity` = \"$typeOfActivity\"
WHERE
    id=$id";

  return $query;
}

function mysqlLocationAndImagesInfo($pageNo, $pageOffset)
{
  $pageNo = $pageNo * $pageOffset;
  $query =
    "SELECT
    id,
    title,
    `description`,
    lattitude,
    longitude,
    `status`,
    image_count,
    type_of_activity,
  	created_by,
    created_by_id,
    created_at,
    updated_at
FROM
    `tbl_location` AS l,
    (
    SELECT
        COUNT(location_id) AS image_count,
        location_id
    FROM
        `tbl_images`
    GROUP BY
        location_id
) AS i,
(
    SELECT username AS created_by,id AS created_by_id FROM `tbl_admins`
) AS a
WHERE
    i.location_id = l.id AND
    l.admin_id = a.created_by_id
ORDER BY
	`created_at` DESC
LIMIT $pageNo,$pageOffset";

  return $query;
}

function mysqlLocationPostCount()
{
  $query = "SELECT COUNT(id) as `total` FROM `tbl_location`";
  return $query;
}

function mysqlAdminRequestList($pageNo, $pageOffset)
{
  $pageNo = $pageNo * $pageOffset;
  $query = "SELECT
    id,
    `name`,
    username,
    email,
    `address`,
    phone_number,
    `status`,
    created_at
FROM
    `tbl_admins`
WHERE
    `status` = 0
LIMIT $pageNo,$pageOffset";

  return $query;
}

function mysqladminRequests($id, $accepted)
{

  if ($accepted == true) {
    $query = "UPDATE `tbl_admins` SET `status`=1 WHERE id=$id;";
  } else {
    $query = "DELETE FROM `tbl_admins` WHERE id=$id;";
  }

  return $query;
}

function mysqladminRequestsCount()
{
  return "SELECT COUNT(*) AS total  FROM `tbl_admins` WHERE `status`=0";
}

function mysqlInsertComment($userId, $location_id, $comment)
{
  $createdAt = date('Y-m-d') . " " . date('H:i:s');
  $query = "INSERT INTO `tbl_comments`(`user_id`, `location_id`, `comment`,`created_at`) VALUES ($userId,$location_id,'$comment','$createdAt')";
  return $query;
}

function mysqlgetComments($location_id, $pageNo, $pageOffset)
{
  $pageNo = $pageNo * $pageOffset;
  $query = "SELECT
    u.username,
    u.avatar,
    c.comment,
    c.created_at,
    c.location_id,
    c.id
FROM
    `tbl_comments` c
LEFT JOIN `tbl_users` u ON
    c.user_id = u.id
WHERE
	c.location_id=$location_id
ORDER BY
	c.created_at DESC
LIMIT $pageNo,$pageOffset";
  return $query;
}

function mysqlUpdateProfile($id, $name, $username, $password, $email, $address, $phone, $avatar, $admin = false)
{
  $dateNow = date('Y:m:d') . " " . date('H:i:s');
  $isAdmin = $admin ? "`tbl_admins`" : "`tbl_users`";
  $isAvatar = isset($avatar) ? "`avatar` ='$avatar'," : "";
  $isPassword = !is_null($password) ? " `password` ='" . $password . "'," : "";

  $query = "
    UPDATE
    " . $isAdmin . "
    SET
    `name` ='$name',
    `username` ='$username',
    $isPassword
    `email` ='$email',
    `address` ='$address',
    `phone_number` ='$phone',
    $isAvatar
    `Updated_at` ='$dateNow'
    WHERE
    id = '$id' ";

  return $query;
}

function mysqlCheckInFavorite($userId, $locationId)
{
  $query = "SELECT * FROM `tbl_favorites` WHERE `user_id`=$userId AND `location_id`='$locationId'";
  return $query;
}

function mysqlSaveToFavorite($userId, $locationId)
{
  $query = "INSERT INTO `tbl_favorites`(`user_id`, `location_id`) VALUES ('$userId','$locationId')";
  return $query;
}

function mysqlRemoveFromFavorite($userId, $locationId)
{
  $query = "DELETE FROM `tbl_favorites` WHERE `user_id`=$userId AND `location_id`=$locationId";
  return $query;
}

function mysqlGetAllFavoritePosts($userId, $pageNo = 0, $pageOffset = 0)
{
  $pageNo = $pageNo * $pageOffset;
  $query = "SELECT
        l.id AS id,
        f.id AS fid,
    f.created_at,
    l.title,
    l.description,
    l.type_of_activity,
    l.lattitude,
    l.longitude
FROM
    `tbl_favorites` AS f,
    `tbl_location` AS l
WHERE
    `user_id`= $userId AND
    f.location_id = l.id
ORDER BY
	  f.created_at DESC";

  return $query;
}

function mysqlPostReview($title, $description, $userId)
{
  $query = "INSERT INTO `tbl_feedbacks`(`user_id`, `title`, `description`) VALUES ('$userId','$title','$description')";
  return $query;
}

function mysqlGetReviewAll()
{
  $query = "SELECT * FROM `tbl_feedbacks` WHERE status=1";
  return $query;
}

function mysqlSearchPostCount($searchText)
{
  $query =
    "SELECT
    COUNT(*) as count
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
        l.`title` LIKE '%$searchText%' OR l.`description` LIKE '%$searchText%' OR l.`type_of_activity` LIKE '%$searchText%' AND l.`status` = 1
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image AS image
    FROM
        `tbl_images`
    WHERE
        1
    GROUP BY
        location_id
) AS i,
`tbl_admins` as a	
WHERE
    l.id = i.location_id AND
    l.admin_id = a.id AND
    l.status = 1
ORDER BY
    l.id";

  return $query;
}

function mysqlSearchPost($searchText, $pageNo = 0, $pageOffset = 10)
{
  $pageNo = $pageNo * $pageOffset;
  $query =
    "SELECT
    l.id,
    l.title,
    l.description,
    l.type_of_activity,
    l.status,
    i.image,
    a.username,
    l.created_at
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
        l.`title` LIKE '%$searchText%' OR l.`description` LIKE '%$searchText%' OR l.`type_of_activity` LIKE '%$searchText%' AND l.`status` = 1
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image AS image
    FROM
        `tbl_images`
    WHERE
        1
    GROUP BY
        location_id
) AS i,
`tbl_admins` as a	
WHERE
    l.id = i.location_id AND
    l.admin_id = a.id AND
    l.status = 1
ORDER BY
    l.id
    LIMIT $pageNo,$pageOffset";
  return $query;
}

function mysqlPostRecommendation($count = 4)
{
  $query =
    "SELECT
    l.id,
    l.title,
    l.description,
    l.type_of_activity,
    l.status,
    i.image,
    a.username,
    l.created_at
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
       l.`status` = 1
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image
    FROM
        `tbl_images`
    WHERE
        1
    GROUP BY
        location_id
) AS i,
`tbl_admins` as a	
WHERE
    l.id = i.location_id AND
    l.admin_id = a.id AND
    l.status = 1
ORDER BY
    RAND()
LIMIT $count";
  return $query;
}

function mysqlRecentPosts($id,$count = 3)
{
  $id = isset($id)?$id:true;
  $query =
  "SELECT
    l.id,
    l.title,
    l.description,
    l.type_of_activity,
    l.status,
    i.image,
    a.username,
    l.created_at
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
        l.`status` = 1 AND l.`id` != $id
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image AS image
    FROM
        `tbl_images`
    GROUP BY
        location_id
) AS i,
`tbl_admins` AS a
WHERE
    l.id = i.location_id AND l.admin_id = a.id AND l.status = 1
ORDER BY
    l.created_at DESC
LIMIT $count";

  return $query;
}

function mysqlGetPostsForExploreAndActivities($type = 'activity')
{
  switch ($type) {
    case 'explore': {
        $query =
          "SELECT
    l.id,
    l.title,
    l.description,
    i.image
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
        l.`type_of_activity` IN(
            'religious Places',
            'sightseeing',
            'visiting',
            'touring',
            'sightsee'
        ) AND l.`status` = 1
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image AS image
    FROM
        `tbl_images`
    WHERE
        1
    GROUP BY
        location_id
) AS i,
`tbl_admins` AS a
WHERE
    l.id = i.location_id AND l.admin_id = a.id AND l.status = 1
ORDER BY
    RAND()
LIMIT 11";
        break;
      }
    case 'activity':
    case 'activities':
    default: {
        $query =
        "SELECT
    l.id,
    l.title,
    l.description,
    i.image
FROM
    (
    SELECT
        *
    FROM
        `tbl_location` AS l
    WHERE
        l.`type_of_activity` IN(
            'hiking',
            'trekking',
            'mountaineering',
            'mountain biking',
            'cycling',
            'cruising'
        ) AND l.`status` = 1
) AS l,
(
    SELECT DISTINCTROW
        location_id,
        image AS image
    FROM
        `tbl_images`
    WHERE
        1
    GROUP BY
        location_id
) AS i,
`tbl_admins` AS a
WHERE
    l.id = i.location_id AND l.admin_id = a.id AND l.status = 1
ORDER BY
    RAND()
LIMIT 11
        ";
      }
  }
  return $query;
}

function mysqlRemoveComment($id){
  $query = "DELETE FROM `tbl_comments` WHERE id=$id";
  return $query;
}

// $query1 = "SELECT * FROM tbl_users WHERE username='user' AND password='upassword' AND status=1";
// print_r($connection->query($query1));
