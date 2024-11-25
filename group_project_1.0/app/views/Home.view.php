<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Cards</title>
    <link rel="stylesheet" href=".\home.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>User Cards</h1>
    <div id="card-container" class="card-container"></div>
      
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('Home/api') // Adjust to match your routing structure
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const container = document.getElementById('card-container');
                    data.forEach(record => {
                        const card = document.createElement('div');
                        card.className = 'card';
                        card.innerHTML = `
                            <h3>${record.name}</h3>
                            <p> Age: ${record.age}</p>
                        `;
                        container.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    </script>
</body>
</html>


