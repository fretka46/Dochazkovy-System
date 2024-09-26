<?php
include  "internal/config.php";

// Database connection
$conn = new mysqli($host, $user, $password, $dbname, $port) or die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8mb4");


// Gets all teacher status from database
function GetTeacherStatus(): array {
    global $conn;
    $result = $conn->query("SELECT id, name, is_present FROM teachers ORDER BY is_present DESC");
    $teachers = array();
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }

    return $teachers;
}



// Updates status and returns true if teacher is present, false if teacher is absent, null if access is denied
function UpdateTeacherStatus(string $card) : ?bool {
    global $conn;

    // Query the current status of the teacher
    $stmt = $conn->prepare("SELECT is_present FROM teachers WHERE card_code = ?");
    $stmt->bind_param("s", $card);
    $stmt->execute();
    $stmt->bind_result($is_present);
    $stmt->fetch();
    $stmt->close();

    // If no teacher is found, return null (access denied)
    if ($is_present === null) {
        return null;
    }

    // Update the status of the teacher
    $stmt = $conn->prepare("UPDATE teachers SET is_present = NOT is_present WHERE card_code = ?");
    $stmt->bind_param("s", $card);
    $stmt->execute();
    $stmt->close();

    // Return the new status
    return !$is_present;
}

function CreateLog(string $card) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO access_log (card_id) VALUES (?)");
    $stmt->bind_param("s", $card);
    $stmt->execute();
    $stmt->close();
}