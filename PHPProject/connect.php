<?php
$connection = mysqli_connect('localhost', 'root', '' , 'phpproject');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'phpproject');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
/**
 * Created by PhpStorm.
 * User: Niels
 * Date: 15-5-2018
 * Time: 08:59
 */