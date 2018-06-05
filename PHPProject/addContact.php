
<html>
<head>
    <meta charset="utf-8">
    <title>Adresboek</title>
    <link rel="stylesheet" type="text/css" href="css/addContact.css">
</head>

<body>
<div id="container">
    <nav id="navigatie">
        <div id="navLinks">
            <a href="index.php">
                <button id="btnTerug">Terug</button>
            </a>
        </div>
        <div id="navRechts">
            <img src="images/alpha-logo.png" width="250" height="200">
        </div>
    </nav>
    <main>
        <?php
        session_start();
        require('connect.php');
        $query ="";

        if (isset($_POST["ContactVnaam"]) && $_POST["ContactAnaam"] &&
            $_POST["ContactEmail"]) {
            //als de form goed is ingevult
            if (isset($_POST['AdminRole'])){
                $admin = 1;
            } else {
                $admin = 0;
            }
            //secure values

            $salt = "sha256";
            $password = $_POST['Password'];

            $hashedpass = crypt($password, $salt);

//nieuwe contact waardes
            //
            //
            //
            //
            //
            $query = "INSERT INTO `contacten` (`ContactVnaam`, 
`ContactVvg`, `ContactAnaam`, `ContactBedrijfsnaam`, `ContactEmail`, `ContactTelPrive`, 
`ContactTelZakelijk`, `ContactBedrijfPlaats`) VALUES 
('{$_POST["ContactVnaam"]}', '{$_POST["Vvg"]}', '{$_POST["ContactAnaam"]}', 
'{$_POST["Bedrijfsnaam"]}', '{$_POST["Email"]}', 
'{$_POST["TelPrive"]}', '{$_POST["TelZak"]}', '{$_POST["BPlaats"]}'";

            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            //header("Location: index_admin.php");
        } else {
        }


        if (isset($_POST["maken"])){
            // als de pagina geladen word met maken

            unset($_POST["maken"]);
            //
            //
            //
            //
            //
            //LOCATION VERANDEREN NAAR CONTACT INDEX ADMIN
            header("Location:index_admin.php");


        } else if (isset($_POST['nogeenmaken'])){


            unset($_POST['nogeenmaken']);
            // als de pagina geladen word met nog een maken
            $queryGetId = "SELECT ContactId FROM contacten ORDER BY ContactId DESC LIMIT 1";
            $result = mysqli_query($connection, $queryGetId) or die (mysqli_error());
            $Id = mysqli_fetch_assoc($result);

            echo "Contact ".$_POST['ContactVnaam']. " is aangemaakt met het ID: ";
            foreach ($Id as $id){
                echo $id;
            };
            //header("Refresh:0");

        }

        ?>

        <form action="" method="post">
            <b>Gebruiker toevoegen:</b> <br>
            Voornaam:<input type="text" maxlength="15" name="ContactVnaam" placeholder="Voornaam" required>*<br>
            Voorvoegsels:<input type="text" maxlength="7" name="Vvg" placeholder="Voorvoegsels" ><br>
            Achternaam:<input type="text" maxlength="15" name="ContactAnaam" placeholder="Achternaam" required>*<br>
            <br>
            Bedrijfsnaam:<input type="text" maxlength="15" name="Bedrijfsnaam" placeholder="Bedrijfsnaam" ><br>
            Email:<input type="text" maxlength="20" name="Email" placeholder="Email"><br>
            Telefoon Privé:<input type="text" maxlength="11" name="TelPrive" placeholder="Telefoon Privé" ><br>
            Telefoon Zakelijk:<input type="text" maxlength="11" name="TelZak" placeholder="Telefoon zakelijk" ><br>
            Bedrijfsplaats:<input type="text" maxlength="15" name="BPlaats" placeholder="Bedrijfsplaats"><br>
            <input type="submit" value="Contact maken" name="maken"><br>
            <input type="submit" value="Nog een contact maken" name="nogeenmaken">
        </form>
    </main>
    <footer>

    </footer>
</div>
</body>
</html>