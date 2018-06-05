<html>
<head>
    <meta charset="utf-8">
    <title>Adresboek</title>
    <link rel="stylesheet" type="text/css" href="css/addGebruikers.css">
</head>

<body>
<div id="container">
    <nav id="navigatie">
        <div id="navLinks">
            <a href="index.php">
                <button id="btnTerug">
                    Terug
                </button>
            </a>
        </div>
        <div id="navRechts">
            <img src="images/alpha-logo.png" width="250" height="200">
        </div>
    </nav>
    <main>
        <?php
        if (isset($_POST['user']) and isset($_POST['pass'])){
            $salt = "skkgf4dfg!";
            $username = $_POST['user'];
            $salt = "sha256";
            $password = $_POST['pass'];
            $hashedpass = crypt($password, $salt);
//3.1.2 Checking the values are existing in the database or not
            $query = "SELECT * FROM `gebruikers` WHERE Username='$username' and Password='$hashedpass'";
            $result = mysqli_query($connection, $query) ;

            $count = mysqli_num_rows($result);
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
        session_start();
        require('connect.php');
        $query = "";
        $first_entry = 0;
        if (isset($_POST["id"]) ) {
            //als de id is ingevult maak een query


            $query = "UPDATE gebruikers SET ";
            $salt = "sha256";
            if ($first_entry == 0) {

            if (!empty($_POST['Voornaam']) && $first_entry == 0) {
                $query .= "GebruikerVnaam = '{$_POST['Voornaam']}'";
                $first_entry = 1;
                unset($_POST['Voornaam']);
            }
            if ($first_entry == 0) {
                if (!empty($_POST['Vvg'])) {
                    $query .= "GebruikerVvg = '{$_POST['Vvg']}'";
                } else {
                    $query .= "GebruikerVvg = ''";
                }
                $first_entry = 1;
                unset($_POST['Vvg']);
            }
            if (!empty($_POST['Achternaam']) && $first_entry == 0) {
                $query .= "GebruikerAnaam = '{$_POST['Achternaam']}'";
                $first_entry = 1;
                unset($_POST['Achternaam']);
            }
            if (!empty($_POST['Email']) && $first_entry == 0) {
                $query .= "GebruikerEmail = '{$_POST['Email']}'";
                $first_entry = 1;
                unset($_POST['Email']);
            }
            if (!empty($_POST['GebruikerTel']) && $first_entry == 0) {
                $query .= "GebruikerTel = '{$_POST['GebruikerTel']}'";
                $first_entry = 1;
                unset($_POST['GebruikerTel']);
            }
            if (!empty($_POST['Username']) && $first_entry == 0) {
                $query .= "Username = '{$_POST['Username']}'";
                $first_entry = 1;
                unset($_POST['Username']);
            }
            if (!empty($_POST['Password']) &&  $first_entry == 0) {
                    $hashedpass = crypt($_POST['Password'], $salt);
                    $query .= "Password = '$hashedpass'";
                    unset($_POST['Password']);
            }
            if (!isset($_POST['AdminRole']) && $first_entry == 0) {
                $query .= "AdminRole = 0";
                $first_entry = 1;
                unset($_POST['AdminRole']);
            } else if (isset($_POST['AdminRole']) && $first_entry == 0 && $_POST['AdminRole'] == 'Yes') {
                $query .= "AdminRole = 1";
                $first_entry = 1;
                unset($_POST['AdminRole']);
            }

    //second entry in query

            if (!empty($_POST['Voornaam']) && $first_entry == 1) {
                $query .= ", GebruikerVnaam = '{$_POST['Voornaam']}'";
            }
            if ($first_entry == 1) {
                if (!empty($_POST['Vvg'])) {
                    $query .= ", GebruikerVvg = '{$_POST['Vvg']}'";
                } else {
                    $query .= ", GebruikerVvg = ''";
                }
            }
            if (!empty($_POST['Achternaam']) && $first_entry == 1) {
                $query .= ", GebruikerAnaam = '{$_POST['Achternaam']}'";
            }
            if (!empty($_POST['Email']) && $first_entry == 1) {
                $query .= ", GebruikerEmail = '{$_POST['Email']}'";
            }
            if (!empty($_POST['GebruikerTel']) && $first_entry == 1) {
                $query .= ", GebruikerTel = '{$_POST['GebruikerTel']}'";
            }
            if (!empty($_POST['Username']) && $first_entry == 1) {
                $query .= ", Username = '{$_POST['Username']}'";
            }
            if (!empty($_POST['Password']) && $first_entry == 1) {
                    $hashedpass = crypt($_POST['Password'], $salt);
                    $query .= ", Password = '$hashedpass'";
                    unset($_POST['Password']);
            }
            if (!isset($_POST['AdminRole']) && $first_entry == 1) {
                $query .= ", AdminRole = 0";
            } else if (isset($_POST['AdminRole']) && $first_entry == 1 && $_POST['AdminRole'] == 'Yes') {
                $query .= ", AdminRole = 1";
            }


        }

            $query .= " WHERE GebruikerId = {$_POST['id']}";
            //send query
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            //Go to index_admin.php
            echo $query;
            header("Location: index_admin.php");

        }
        //execute code when button is pressed
        if (isset($_POST['wijzigen'])){
        $query = "SELECT * FROM gebruikers WHERE GebruikerId = {$_POST['hidden']} LIMIT 1";
        $result1 = mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
        ////////////fill textboxes - no password - HTML
        if (isset($result1)) {
            while ($row = mysqli_fetch_assoc($result1)) {
                //adminrole checkbox checked - unchecked
                if ($row['AdminRole'] == 1) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                ?>

                <form action="" method="post">
                    <b>Gebruiker wijzigen:</b><br><br>
                    Id:<input type="text" value="<?php echo $row['GebruikerId']; ?>" readonly maxlength="15" name="id"
                              placeholder="Id"><br><br>
                    Gebruikersnaam:<input type="text" value="<?php echo $row['Username']; ?>" maxlength="15" name="Username"
                                    placeholder="Username"><br>
                    Nieuw Wachtwoord:<input type="password" value="" maxlength="15" name="Password"
                                   placeholder="Password"><br>
                    Admin<input type="checkbox" <?php echo "{$checked}"; ?> name="AdminRole"
                                value="Yes"><br><br>

                    Voornaam Gebruiker:<input type="text" value="<?php echo $row['GebruikerVnaam']; ?>" maxlength="15" name="Voornaam" placeholder="Voornaam"><br>
                    Vvg Gebruiker:<input type="text" value="<?php echo $row['GebruikerVvg']; ?>" maxlength="8" name="Vvg" placeholder="Voorvoegsels"><br>
                    Achternaam Gebruiker:<input type="text" value="<?php echo $row['GebruikerAnaam']; ?>" maxlength="15" name="Achternaam"
                                                placeholder="Achternaam"><br>
                    Email Gebruiker:<input type="text" value="<?php echo $row['GebruikerEmail']; ?>" maxlength="20" name="Email" placeholder="Email"><br>
                    Telefoon Gebruiker:<input type="text" value="<?php echo $row['GebruikerTel']; ?>" maxlength="11" name="GebruikerTel"
                                              placeholder="Telefoonnummer"><br>
                    <input type="submit" name="Wijzigen" value="Wijzigen">
                    <hr>
                </form>

                <?php
            }
        } else {
            // geen gebruiker geselecteerd
            header("Location: index_admin.php");
        }
        ////////////end of fill boxes
        ?>


    </main>
    <footer>
    </footer>
</div>
</body>
</html>