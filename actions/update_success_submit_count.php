<?php

// Start the session
session_start();

// checking 5 clicks
$submit_click_counter = $_POST['submit_click_counter'];

$_SESSION["submit_click_counter"] = $submit_click_counter;

?>