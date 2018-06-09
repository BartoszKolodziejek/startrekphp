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
#creating db
exec('mysql', $output);
echo implode($output);

#enviroment configuration

exec('php composer', $output);
echo implode($output);
exec('php composer install', $output);
echo implode($output);
exec('php composer dumpautoload -o', $output);
echo implode($output);
exec('php artisan config:cache', $output);
echo implode($output);
exec('php artisan route:cache', $output);
echo implode($output);
exec('php artisan migrate', $output);
echo implode($output);
$connection  = mysqli_connect($servername, $username, "root");
$connection ->query('USE 2k_18_b_kolo');
$connection ->query('INSERT INTO roles values (1, \'USER\'),(2, \'ADMIN\') ');
$connection -> close();


