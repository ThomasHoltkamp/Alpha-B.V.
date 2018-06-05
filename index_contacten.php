
<?php
session_start();
require('connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['user']) and isset($_POST['pass'])){
//3.1.1 Assigning posted values to variables.
    $username = $_POST['user'];
    $password = $_POST['pass'];
//3.1.2 Checking the values are existing in the database or not
    $query = "SELECT * FROM `gebruikers` WHERE Username='$username' and Password='$password'";
    $query2 = "SELECT * FROM `contacten`";


    $result = mysqli_query($connection, $query) ;
    $result2 = mysqli_query($connection, $query2) or die(mysqli_error($connection));
//    $result3 = mysqli_query($connection, $query3) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
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
}
else
{
    header("login.php");
}

if (isset($_POST['verbutton'])) {


    $query5 = "DELETE FROM gebruikers WHERE GebruikerId = {$_POST['hidden']} ";
    $result5 = mysqli_query($connection, $query5);
    //header( "refresh:2;url=index_admin.php" );
    header("Refresh: 0");
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
                    <img src="images/logging-out-2355227_960_720.png" width="31" height="31">
                </button>
            </a>
            <a href="index_admin.php">
                <button id="navAdmin">
                    Naar<br>Adminpagina
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

    $query4 = "SELECT * FROM contacten";
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
                <th>Telefoon zakelijk</th>
                <th>Telefoon prive</th>
                <th>Bedrijfsnaam</th>
                <th>Bedrijfsplaats</th>
                <th>Wijzigen</th>
                <th>Verwijderen</th>
            </tr>
            <?php

            while($row = mysqli_fetch_assoc($result4)) {
                echo "<tr>
            <td>" . $row['ContactId'] . "</td>
            <td>" . $row['ContactVnaam'] . "</td>
            <td>" . $row['ContactVvg'] . "</td>
            <td>" . $row['ContactAnaam'] . "</td>
            <td>" . $row['ContactEmail'] . "</td>
            <td>" . $row['ContactTelZakelijk'] . "</td>
            <td>" . $row['ContactTelPrive'] . "</td>
            <td>" . $row['ContactBedrijfsnaam'] . "</td>
            <td>" . $row['ContactBedrijfPlaats'] . "</td>
            <td>
                <form action='verwijzig.php' method='post' style='margin-bottom:0; text-align:center;'>
                        <input type='hidden' name='hidden' value=" . $row['ContactId'] . " >
                        <input type='submit' name='wijzigen' value= wijzigen >
                    </form> 
            </td>
            <td><form action='index_admin.php' method='post' style='margin-bottom:0; text-align:center;'>
                    <input type='hidden' name='hidden' value=" . $row['ContactId'] . " >
                    <input type='submit' name='verbutton' value= verwijderen >
                </form>
            </td>
          </tr>";
            }

            ?>
    </div>
</div>
</body>
</html>

