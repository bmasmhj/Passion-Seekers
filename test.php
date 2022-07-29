<?php
$con = mysqli_connect('localhost','root','','db_passion_seekers');

$queryForRecomendationPosts =
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
	image,
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
LIMIT 4";

$recomendationOfPosts = [];

$resultsForRecomendation = $con->query($queryForRecomendationPosts);

if ($resultsForRecomendation) {
	while ($row = $resultsForRecomendation->fetch_assoc()) {
	   array_push($recomendationOfPosts, $row);
	}
}

	


print_r($recomendationOfPosts);

?>
