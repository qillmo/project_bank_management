<?php
// login_process.php

// Get the submitted username and password from the form
$userInput = isset($_POST['username']) ? $_POST['username'] : '';
$passInput = isset($_POST['password']) ? $_POST['password'] : '';

// Replace these values with your actual authentication logic (e.g., checking against a database)
$validUsername = 'admin';
$validPassword = 'admin';

if ($userInput === $validUsername && $passInput === $validPassword) {
    // Start the session (if not already started)
    session_start();

    // Set a session variable to indicate that the user is logged in
    $_SESSION['logged_in'] = true;

    // Redirect the user to the index.php page
    header("Location: index.php");
    exit(); // Make sure to exit after sending the header to prevent further execution
} else {
    // Redirect the user back to the login page if authentication fails
    header("Location: login.php");
    exit();
}
?>
