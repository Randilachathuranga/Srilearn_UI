<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Removed Students</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a; /* Dark blue background */
            color: #f1f5f9; /* Light text */
            padding: 20px;
            margin: 0;
        }

        h2 {
            color: #ffffff;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #1e293b; /* Slightly lighter than body */
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            text-align: left;
        }

        th {
            background-color: #334155; /* Header dark shade */
            color: #ffffff;
            font-weight: bold;
        }

        td {
            background-color: #0f172a;
            border-bottom: 1px solid #334155;
            color: #e2e8f0;
        }

        tr:hover td {
            background-color: #1e293b; /* Hover effect */
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #94a3b8;
            background-color: #1e293b;
        }
    </style>
</head>
<body>

    <h2>Removed Students</h2>
    <table id="removedStudentsTable">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Removed Date</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody id="removedStudentsTableBody">
            <tr>
                <td colspan="3" class="no-data">Loading...</td>
            </tr>
        </tbody>
    </table>

    <script>
        const id = <?= json_encode($Class_id ?? []) ?>;
        console.log("Class ID from PHP:", id);

        document.addEventListener("DOMContentLoaded", () => {
            fetch(`http://localhost/group_project_1.0/public/Enrollment/getAlldeleted/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Failed to fetch removed students.");
                    }
                    return response.json();
                })
                .then(data => {
                    const tbody = document.getElementById("removedStudentsTableBody");
                    tbody.innerHTML = ""; // Clear loading message

                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="3" class="no-data">No removed students found.</td></tr>`;
                        return;
                    }

                    data.forEach(student => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${student.Stu_id}</td>
                            <td>${student.Rem_date}</td>
                            <td>${student.Reason}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                    document.getElementById("removedStudentsTableBody").innerHTML = `
                        <tr><td colspan="3" class="no-data">Error loading data.</td></tr>
                    `;
                });
        });
    </script>

</body>
</html>
