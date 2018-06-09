<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 07.06.2018
 * Time: 21:26
 *
 *
 *
 */
#maria DB installation

$servername = "localhost";
$username = "startrek";
$password = "startrek";
$output = array();
#creating db
exec('mysql');

$connection  = mysqli_connect($servername, $username, "root");
$connection ->query('USE startrek');
$connection ->query('INSERT INTO roles values (1, \'USER\'),(2, \'ADMIN\') ');
$connection -> close();


