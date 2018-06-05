<?php
session_start();
require('connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['user']) and isset($_POST['pass'])){


    $salt = "skkgf4dfg!";
//3.1.1 Assigning posted values to variables.
    $username = $_POST['user'];
    $salt = "sha256";
    $password = $_POST['pass'];

    $hashedpass = crypt($password, $salt);
//3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `gebruikers` WHERE Username='$username' and Password='$hashedpass'";



    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);


    $query3 = "SELECT * FROM `gebruikers` WHERE Username='$username' and Password='$hashedpass' and AdminRole = 1";
    $result3 = mysqli_query($connection, $query3) or die(mysqli_error($connection));
    $count3 = mysqli_num_rows($result3);

    //   $count3 = mysqli_num_rows($result3);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        $_SESSION['user'] = $username;
    }else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        $fmsg = "Verkeerde login gegevens";
        echo $fmsg;
        echo "<a href='login.php'>Back</a>";
    }
    if($count3 == 1)
    {
        $_SESSION['admin'] = 1;
    }
    else
    {
        $_SESSION['admin'] = 0;
    }

}

if (isset($_SESSION['user'])){

    if ($_SESSION['admin'] == 1)
    {
        header("Location: index_admin.php");
        exit;

    }
    else if($_SESSION['admin'] == 0){

    }
}

else
{
    $_SESSION['isFout'] = $_POST['isFout'];
    header("Location: login.php");
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Adresboek</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">
</head>

<body>
<div id="container">
    <nav>
        <h1>
            Welkom <?php if (isset($_SESSION['user'])) {
                $username = $_SESSION['user'];
                echo $username;
            }
            ?>!
        </h1>
        <div id="navLinks">
            <div id="navImage">
                <img src="images/alpha-logo.png" width="250" height="200">
            </div>
        </div>
        <div id="navMidden">
        </div>
        <div id="navRechts">
            <a href="logout.php">
                <button id="navUitloggen">
                    Uitloggen
                </button>
            </a>
        </div>
    </nav>

    <div id="links">
    </div>
    <?php
    $query4 = "SELECT * FROM gebruikers";
    $result4 = mysqli_query($connection,$query4);
    ?>
    <div id="rechts">
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Voornaam</th>
            <th>Voorvoegsel</th>
            <th>Achternaam</th>
            <th>Email</th>
            <th>Telefoonnummer</th>
            <th>Username</th>
            <th>Password</th>
            <th>Admin</th>
        </tr>
        <?php
        while($row = mysqli_fetch_assoc($result4)){
            echo "<tr>
            <td>".$row['GebruikerId']."</td>
            <td>".$row['GebruikerVnaam']."</td>
            <td>".$row['GebruikerVvg']."</td>
            <td>".$row['GebruikerAnaam']."</td>
            <td>".$row['GebruikerEmail']."</td>
            <td>".$row['GebruikerTel']."</td>
            <td>".$row['Username']."</td>
            <td>".$row['Password']."</td>
            <td>".$row['AdminRole']."</td>
          </tr>";
        }
        ?>
    </div>
</div>


    <footer>
    </footer>
</div>
</body>
</html>
