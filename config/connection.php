<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$msg_error = '';

try {
  $conn = new PDO('mysql:host=162.241.3.4;dbname=bsrpco90_rgbfast', "bsrpco90_rgbfast", "rgbfast");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $msg_error = $e->getMessage();
}