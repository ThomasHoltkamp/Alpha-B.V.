
<?php
session_start();
if (isset($_SESSION['isFout'])){
    echo '<script language="javascript">
alert("Gebruikersnaam of wachtwoord is onjuist");</script>';
    unset($_SESSION['isFout']);
}
if (isset($_SESSION['user']))
{
    header("Location: index.php");
    exit;

}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Adresboek</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div id="container">
        <div id="inloggen">
            <div id="boven">
                <img src="images/alpha-logo.png" class="logo" width="175" height="175">
                <div id="bovenRechts">
                    <h1>Alpha B.V.</h1>
                </div>
            </div>

            <div id="onder">
                <form method="post" action="index.php">
                    <input type="text" name="user" placeholder="Username"><br><br>
                    <input type="password" name="pass" placeholder="Password"><br><br>
                    <input type="checkbox" name="chkRemember" value="remember">Remember me<br><br>
                    <input type="hidden" name="isFout">
                    <input type="submit" name="submit" value="Inloggen">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
