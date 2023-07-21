<?php
session_start(); //must be called first

session_destroy(); 

header("Location: login.php"); //redirect
exit;