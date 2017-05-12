<?php
include 'includes/db.php';
session_start();
ob_start();

$score = $_GET['score'];

$query = "UPDATE `users` SET `highscore`=" . $score . " WHERE `email` = '" . $_SESSION['email'] . "' AND `highscore` < " . $score . "";
if(mysqli_query($mysqli, $query)){
    //echo "Affected rows:  " . mysqli_affected_rows($mysqli);
    if(mysqli_affected_rows($mysqli) == 1)
        echo "Highscore!";
}
?>