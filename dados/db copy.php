<?php
$servername = "sql103.infinityfree.com";
$username = "if0_40616717";
$password = "fZG9Vzu919qpeuV";
$dbname = "if0_40616717_portfolio";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); // Define a conexão para UTF-8

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
