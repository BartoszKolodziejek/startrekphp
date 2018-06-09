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
$username = "2k_18_b_kolo";
$password = "2k_18_b_kolo";
$output = array();

$connection  = mysqli_connect($servername, $username, "root");
$connection ->query('USE 2k_18_b_kolo');
$connection ->query('INSERT INTO roles values (1, \'USER\'),(2, \'ADMIN\') ');
$connection -> close();


