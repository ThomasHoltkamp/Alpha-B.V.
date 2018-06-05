
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

        if (isset($_POST["Username"]) && $_POST["Password"] &&
            $_POST["Voornaam"] && $_POST["Achternaam"] &&
            $_POST["Email"] && $_POST["Telefoon"]){
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


            $query = "INSERT INTO `gebruikers` (`GebruikerVnaam`, 
`GebruikerVvg`, `GebruikerAnaam`, `GebruikerEmail`, `GebruikerTel`, 
`Username`, `Password`, `AdminRole`) VALUES 
('{$_POST["Voornaam"]}', '{$_POST["Vvg"]}', '{$_POST["Achternaam"]}', 
'{$_POST["Email"]}', '{$_POST["Telefoon"]}', 
'{$_POST["Username"]}', '$hashedpass', '{$admin}')";

            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            //header("Location: index_admin.php");
        } else {
        }

        //////////////////////////////////////////////////
        if (isset($_POST["maken"])){
            // als de pagina geladen word met maken

            unset($_POST["maken"]);
            header("Location:index_admin.php");


        } else if (isset($_POST['nogeenmaken'])){


            unset($_POST['nogeenmaken']);
            // als de pagina geladen word met nog een maken
            $queryGetId = "SELECT GebruikerId FROM gebruikers ORDER BY GebruikerId DESC LIMIT 1";
            $result = mysqli_query($connection, $queryGetId) or die (mysqli_error());
            $Id = mysqli_fetch_assoc($result);

            echo "Gebruiker ".$_POST['Username']. " is aangemaakt met het ID: ";
            foreach ($Id as $id){
                echo $id;
            };
            //header("Refresh:0");

        }

        ?>

        <form action="" method="post">
            <b>Gebruiker toevoegen:</b> <br>
            Username:<input type="text" maxlength="15" name="Username" placeholder="Username" required>*<br>
            Password:<input type="password" maxlength="15" name="Password" placeholder="Password" required>*<br>
            Admin:<input type="checkbox" name="AdminRole" placeholder="Admin"><br>
            <br>
            Voornaam Gebruiker:<input type="text" maxlength="15" name="Voornaam" placeholder="Voornaam" required>*<br>
            Vvg Gebruiker:<input type="text" maxlength="8" name="Vvg" placeholder="Voorvoegsels"><br>
            Achternaam Gebruiker:<input type="text" maxlength="15" name="Achternaam" placeholder="Achternaam" required>*<br>
            Email Gebruiker:<input type="text" maxlength="20" name="Email" placeholder="Email" required>*<br>
            Telefoon Gebruiker:<input type="text" maxlength="11" name="Telefoon" placeholder="Telefoonnummer" required>*<br>
            <input type="submit" value="gebruiker maken" name="maken"><br>
            <input type="submit" value="nog een gebruiker maken" name="nogeenmaken">
        </form>
    </main>
    <footer>

    </footer>
</div>
</body>
</html>