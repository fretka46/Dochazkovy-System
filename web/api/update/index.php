<?php
include "../../functions.php";

// Code that responds with the current status of teachers in the database

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    die("Invalid request method");
}

echo json_encode(GetTeacherStatus(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
http_response_code(200);