<?php

if (empty($_POST["name"])) { // make sure field not empty
    die("Name required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Invalid email"); // check for email
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters long");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain a letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain a number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match"); // check for password repetition
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); //bcyrpt algorithm, 60 char string for security

$mysqli = require __DIR__ . "/database.php";

//placeholders to insert data into database
$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init(); //statement

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error); //catch syntax errors
}
//all three vars are strings
$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);
                  
if ($stmt->execute()) {

    header("Location: signup-success.html"); //redirect to other page
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) { //error number 
        die("email already in use");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
