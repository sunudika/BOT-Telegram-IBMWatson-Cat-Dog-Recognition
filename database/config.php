<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "telegram_bot_counter";

$connection = mysqli_connect($host, $user, $pass, $db) or die(mysqli_connect_error());