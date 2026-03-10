<?php
include("connexiondb.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['username'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $password = $_POST['pwd'];
    
    $req="INSERT INTO user (username,email,poste,pwd) VALUES ('$nom','$email','$poste','$password')";
    $result=mysqli_query($con,$req);
if ($result==true) {
    echo "<div class='message'>
        <p>Enregistrement reussi !!</p>
    </div> <br>";
    echo "<a href='../index.php'><button class='btn'>login now</button></a>";
}
else{
    echo "<div class='message'>
        <p>Enregistrement refuser!!</p>
    </div> <br>";
    echo "<a href='../formulaire/register.php'><button class='btn'>recommencer</button></a>";
}
}
   

