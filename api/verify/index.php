<?php
// File that checks the user's card code and updates is_present in tabase

require "../../functions.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Invalid request method");
}

if (!isset($_POST["card_code"])) {
    http_response_code(400);
    die("Missing card_code");
}

$card_code = $_POST["card_code"];

$databaseResponse = UpdateTeacherStatus($card_code);

if ($databaseResponse === null) {
    http_response_code(400);
    die("Access denied");
}

// TODO: Complete this
// Make record into the database
CreateLog($card_code);

// Update teacher status
if ($databaseResponse) {
    http_response_code(200);
    echo("Success");
} else {
    http_response_code(400);
    echo("Access denied");
}