<?php
$user = 'root';
$password = '';
$database = 'will';

$dbc = mysqli_connect ( 'localhost', $user, $password, $database ) or die ( 'DB Error' );

//$query = "INSERT INTO aliens_abduction (first_name, last_name, when_it_happened, how_long, how_many, alien_description, what_they_did, fang_spotted, other, email) VALUES('Sally', 'Jones', '3 days ago', '1 day', 'four', 'green with six tentacles', 'We just talked and played with a dog', 'yes', 'I may have seen your dog. Contact me.', 'sally@gregs-list.net')";

$result = mysqli_query ( $dbc, $query ) or die ( 'QUERY Error' );

mysqli_close ($dbc);

?>