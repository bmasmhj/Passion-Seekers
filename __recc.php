<?php
$user_latitude =  $_POST['lat'];
$user_longitude = $_POST['long'];
 $con = mysqli_connect('localhost','root','','db_passion_seekers');
$sql = "SELECT * FROM tbl_location ORDER BY id asc";
$result = $con->query($sql);
$data = [];
if($result->num_rows > 0) {
  $i = 0;
  while($row = $result->fetch_assoc()) {
    $data[$i]['id'] = $row['id'];
    $data[$i]['distance'] =  twopoints_on_earth($user_latitude, $user_longitude,$row['lattitude'],$row['longitude']);
   $i++;
  }
}

array_sort_by_column($data, 'distance');
// $np["data"] = $data[0]['id'];
// echo json_encode($np);

// echo '<pre>';

// print_r($data);

$len = count($data);
// echo '<br>';
for($r = 0 ; $r < $len ; $r++ ){
    $pid = $data[$r]['id'];
    fetchhere($pid);
}

function fetchhere($id){
 $con = mysqli_connect('localhost','root','','db_passion_seekers');

  $sid = $id;
  $sql = "SELECT  l.* , i.image as image , a.username as username
  FROM tbl_location l
  JOIN tbl_images i
  ON  l.id = i.location_id
  JOIN tbl_admins a
  ON l.admin_id = a.id
  WHERE l.id = '$sid'
  LIMIT 1 ";
  $result = $con->query($sql);
  $data = [];
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo ' <li class="recommendation__list__item" style="margin-top:20px">
        <a href="individualPage.php?id='.$row['id'].'">
           <div class="recommendation__list__item_images">
              <img src="/images/posts/'.$row['image'].'" alt="#">
           </div>
        </a>
        <div class="recommendation__list__item_info">
           <span class="tag">'.$row['username'].'</span>
           <h4>'.$row['title'].'</h4>
           <p>'.substr($row['description'], 0, 150).'...<a href=""./individualPage.php?id="'.$row['id'].'" class="recommendation__list__item_more">more</a></p>
        </div>
     </li>';
   }
} 
}

function twopoints_on_earth($latitudeFrom, $longitudeFrom, $latitudeTo,  $longitudeTo){
  $long1 = deg2rad($longitudeFrom);
  $long2 = deg2rad($longitudeTo);
  $lat1 = deg2rad($latitudeFrom);
  $lat2 = deg2rad($latitudeTo);
  //Haversine Formula
  $dlong = $long2 - $long1;
  $dlati = $lat2 - $lat1;
  $val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
  $res = 2 * asin(sqrt($val));
  $radius = 3958.756;
  return ($res*$radius);
}

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
  $sort_col = array();
  foreach ($arr as $key => $row) {
    $sort_col[$key] = $row[$col];
  }
  array_multisort($sort_col, $dir, $arr);
}
?>

