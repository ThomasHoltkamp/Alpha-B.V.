<?php

session_start();
session_destroy();
unset($_POST['user']);
unset($_POST['pass']);
header('Location: login.php');
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 15-5-2018
 * Time: 09:07
 */