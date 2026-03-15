<?php
session_start();

include("connexiondb.php");
// if (isset($_POST['username']) && isset($_POST['compte']) && isset($_POST['password']) ) {
//     # code...
// }else{
//     header("location:../index.php");
// }
if (isset($_POST['submit'])) {
    $nom = mysqli_real_escape_string($con,$_POST['username']);
    $pwd = mysqli_real_escape_string($con,$_POST['pwd']);

    $resulte = mysqli_query($con,"SELECT *FROM user WHERE username='$nom' AND pwd='$pwd'")
    or die("error select");
    $row = mysqli_fetch_assoc($resulte);

    if (is_array($row) && !empty($row)) {
        $_SESSION['valid'] = $row['username'];
        $_SESSION['pwd'] = $row['pwd'];
    }else {
        die("fatal error");
    }
    
    }

?>