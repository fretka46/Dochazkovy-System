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

// Verify the card
// null = invalid, true = Arrival, false = Farewell
$isArrival = UpdateTeacherStatus($card_code);

if ($isArrival === null) {
    http_response_code(400);
    die(json_encode(["code" => 400 ,"error" => "Unathorized"]));
}

// Make record into the database
CreateLog($card_code, $isArrival);

// Give response
http_response_code(200);
echo(json_encode( ["code" => 200, 'isArrival' => $isArrival] ));