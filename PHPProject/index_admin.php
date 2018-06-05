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



    $result = mysqli_query($connection, $query) ;
//    $result3 = mysqli_query($connection, $query3) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
    //   $count3 = mysqli_num_rows($result3);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
    if ($count == 1){
        $_SESSION['user'] = $username;
    }else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
        echo "Verkeerde login gegevens";
        echo "<a href='login.php'>Back</a>";
    }
}
else
{
    header("login.php");
}

if (isset($_POST['verbutton'])) {


    $query5 = "DELETE FROM gebruikers WHERE GebruikerId = {$_POST['hidden']} ";
    $result5 = mysqli_query($connection, $query5);
    header("Refresh: 0");
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Adresboek</title>
    <link rel="stylesheet" type="text/css" href="css/index_style.css">

    <script>
        function confirm_delete() {
            if(confirm('are you sure?'))
            {
            }
            else
            {
                //window.location.replace("https://www.example.com");
                self.location = "localhost/php/PHPProject/index_admin.php";
                alert("are you sure?");
            }
        }
    </script>
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
                <img src="images/alpha-logo.png" class="logo" width="250" height="200">
            </div>
        </div>
        <div id="navMidden">
        </div>
        <div id="navRechts">
            <!--only show when on mobile-->
            <a href="addGebruiker.php" class="hiddenButton">
                <button id="btnToevoegen">
                    Toevoegen
                </button>
            </a>
            <!---->
            <a href="logout.php">
                <button id="navUitloggen">
                    Uitloggen
                </button>
            </a>

        </div>
    </nav>

    <div id="links">
        <a href="addGebruiker.php">
            <button id="btnToevoegen">
                Toevoegen
            </button>
        </a>

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
                <th>Wijzigen</th>
                <th>Verwijderen</th>
            </tr>
            <?php
            $salt = "sha256";
            while($row = mysqli_fetch_assoc($result4)) {
                echo "<tr>
            <td>" . $row['GebruikerId'] . "</td>
            <td>" . $row['GebruikerVnaam'] . "</td>
            <td>" . $row['GebruikerVvg'] . "</td>
            <td>" . $row['GebruikerAnaam'] . "</td>
            <td>" . $row['GebruikerEmail'] . "</td>
            <td>" . $row['GebruikerTel'] . "</td>
            <td>" . $row['Username'] . "</td>
            <td>" . $row['Password'] . "</td>
            <td>" . $row['AdminRole'] . "</td>
            <td>
                <form action='verwijzig.php' method='post' style='margin-bottom:0; text-align:center;'>
                        <input type='hidden' name='hidden' value=".$row['GebruikerId']." >
                        <input type='submit' name='wijzigen' value= wijzigen >
                    </form> 
            </td>
            <td>
                   
                <form action='index_admin.php' method='post' style='margin-bottom:0; text-align:center;'>
                    <input onclick='confirm_delete()' type='submit' name='verbutton' value= verwijderen >
                    <input type='hidden' name='hidden' value=".$row['GebruikerId']." >
                </form>
            </td>
          </tr>";
            }

            ?>
    </div>
</div>
</body>
</html>
