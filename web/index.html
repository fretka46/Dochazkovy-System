<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher List</title>
    <link rel="stylesheet" href="css/mainPage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTable() {
                fetch('api/update')
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = ""; // Clear existing rows
                        if (data.length === 0) {
                            tbody.innerHTML = "<tr><td colspan='4'>No teachers are present.</td></tr>";
                        } else {
                            data.forEach(teacher => {
                                const rowClass = teacher.is_present == "1" ? 'bg-green-100 bg-opacity-20' : 'bg-red-100 bg-opacity-20';
                                const status = teacher.is_present == "1" ? "Present" : "Absent";
                                const profileStatus = teacher.is_present == "1" ? 'online' : 'offline';

                                const row = `
                                    <tr class='${rowClass}'>
                                        <td class='w-1/12 text-center'>${teacher.id}</td>
                                        <td class='w-2/12 flex items-center gap-3 justify-center'>
                                            <div class='avatar ml-6 ${profileStatus}'>
                                                <div class='w-24 rounded-full'>
                                                    <img src='api/profiles/${teacher.id}.jpg' alt='Profile Picture' />
                                                </div>
                                            </div>
                                        </td>
                                        <td class='w-4/12 text-center'>${teacher.name}</td>
                                        <td class='w-2/12 text-center'>${status}</td>
                                    </tr>
                                `;
                                tbody.innerHTML += row;
                            });
                        }
                        document.querySelector('tfoot th').innerText = `Registered Teachers: ${data.length}`;
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

            // Initial table update
            updateTable();

            // Update table every 5 seconds
            setInterval(updateTable, 1000);
        });
    </script>
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
                <!-- Data will be inserted here by JavaScript -->
            </tbody>
            <!-- foot -->
            <tfoot>
                <tr>
                    <th colspan="4" class="text-center">Registered Teachers: 0</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>