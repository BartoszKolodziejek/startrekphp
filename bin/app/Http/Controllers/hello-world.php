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
$username = "root";
$password = "root";
$output = array();
exec('sudo apt-get install software-properties-common', $output);
echo implode($output);
exec('sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8', $output);
echo implode($output);
exec('sudo add-apt-repository \'deb [arch=amd64,i386,ppc64el] http://mariadb.kisiek.net/repo/10.3/ubuntu xenial main\'', $output);
echo implode($output);
exec('sudo apt update', $output);
echo implode($output);
exec('sudo apt install mariadb-server', $output);
echo implode($output);
#creating db
$connection = mysqli_connect($servername, $username, "");
$connection -> begin_transaction();
$connection ->query('ALTER USER \'root\'@\'localhost\' IDENTIFIED BY \'root\'');
$connection ->query('CREATE DATABASE startrek');
$connection -> commit();
$connection ->query('USE startrek');
$connection -> close();
#enviroment configuration
exec('apt-get install apache2', $output);
echo implode($output);
exec('Y', $output);
echo implode($output);
exec('cd startrek', $output);
echo implode($output);
exec('curl -sS https://getcomposer.org/installer | php — –filename=composer', $output);
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
$connection ->query('INSERT INTO roles values (1, \'USER\'),(2, \'ADMIN\') ');
$connection -> close();


