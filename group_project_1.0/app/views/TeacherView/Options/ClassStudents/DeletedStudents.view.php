<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Removed Students</title>
    <style>
       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8fafc; /* Light background */
    color: #1e293b; /* Dark blue-gray text */
    padding: 20px;
    margin: 0;
}

h2 {
    color: #1e3a8a; /* Strong professional blue */
    border-bottom: 2px solid #93c5fd; /* Light blue border */
    padding-bottom: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #ffffff; /* White table background */
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

th, td {
    padding: 14px 16px;
    text-align: left;
}

th {
    background-color: #3b82f6; /* Blue header */
    color: #ffffff;
    font-weight: 600;
    font-size: 15px;
}

td {
    background-color: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
    font-size: 14px;
}

tr:hover td {
    background-color: #f1f5f9; /* Soft hover effect */
}

.no-data {
    text-align: center;
    font-style: italic;
    color: #64748b;
    background-color: #ffffff;
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
