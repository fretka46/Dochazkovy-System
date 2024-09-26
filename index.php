<?php
// File for showing list of all teachers in the room
require "functions.php";

?>

<head>
    <meta charset="UTF-8">
    <title>Teacher List</title>
    <link rel="stylesheet" href="css/mainPage.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="m-8">
        <h1 class="text-center text-6xl mb-4 font-bold">B-109</h1>
        <h2 class="text-center font-bold">Teacher List</h2>
    </div>

        <!-- Teacher table -->
    <div class="overflow-x-auto m-8 ml-24 mr-24">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th class="w-1/12 text-center">Id</th>
                    <th class="w-2/12 ">Profile</th>
                    <th class="w-4/12 text-center">Name</th>
                    <th class="w-2/12 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Main data
                $teachers = GetTeacherStatus();
                if (empty($teachers)) {
                    echo "<tr><td colspan='4'>No teachers are present.</td></tr>";
                } else {
                    foreach ($teachers as $teacher) {
                        $rowClass = $teacher['is_present'] ? 'bg-green-100 bg-opacity-20' : 'bg-red-100 bg-opacity-20';
                        echo "<tr class='$rowClass'>";
                        echo "<td class='w-1/12 text-center'>" . $teacher['id'] . "</td>";
                        echo "<td class='w-2/12 flex items-center gap-3 justify-center'>
                                <div class='avatar ml-6 " . ($teacher['is_present'] ? 'online' : 'offline') . "'>
                                    <div class='w-24 rounded-full'>
                                        <img src='api/profiles/" . $teacher['id'] . ".jpg' alt='Profile Picture' />
                                    </div>
                                </div>
                              </td>";
                        echo "<td class='w-4/12 text-center'>" . $teacher['name'] . "</td>";
                        echo "<td class='w-2/12 text-center'>" . ($teacher['is_present'] ? "Present" : "Absent") . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
            <!-- foot -->
            <tfoot>
                <tr>
                    <th colspan="4" class="text-center">Registered Teachers: <?php echo count($teachers); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>