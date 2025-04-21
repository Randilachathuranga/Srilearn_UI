<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <link rel="stylesheet" href="../../../../../group_project_1.0/public/views/General/Subscriptions/Subscription.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="toggle-container">
            <button class="toggle-btn" onclick="togglePlans()">Switch to Institute Plans</button>
        </div>

        <!-- Teacher Plans -->
        <div id="teacher-plans" class="plans-container"></div>

        <!-- Institute Plans -->
        <div id="institute-plans" class="plans-container hidden"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetch("http://localhost/group_project_1.0/public/Subscriptions/viewallsubdetails")
                .then(response => response.json())
                .then(data => renderPlans(data))
                .catch(error => console.error("Failed to fetch plans:", error));
        });

        function renderPlans(plans) {
            const teacherPlans = document.getElementById("teacher-plans");
            const institutePlans = document.getElementById("institute-plans");

            teacherPlans.innerHTML = "";
            institutePlans.innerHTML = "";

            const typeNames = {
                1: "Lite",
                2: "Pro",
                3: "Ultimate"
            };

            plans.forEach(plan => {
    const planCard = document.createElement("div");
    planCard.className = "plan-card";

    const title = typeNames[(plan.Type - 1) % 3 + 1] || "Plan";

    // Updated pricing logic
    let price = 0;
    if (plan.UserType === "teacher") {
        price = [10, 15, 20][(plan.Type - 1) % 3];
    } else if (plan.UserType === "institute") {
        price = [20, 35, 50][(plan.Type - 1) % 3];
    }

    const features = [];
    if (plan.Isjobavail == 1) features.push("Job Hiring"); features.push("Massage system")
    if (plan.Ispayavail == 1) features.push("Payment Handling");
    if (plan.Isadavail == 1) features.push("Ad Posting");

    planCard.innerHTML = `
        <h2 class="plan-title">${title}</h2>
        <div class="plan-price price-amount">$${price}</div>
        <div class="pic"><img src="../../../../../group_project_1.0/public/views/General/Subscriptions/subscription.jpeg"></div>
        <div class="plan-duration">${plan.Duration} months</div>

        <ul class="plan-features">
            ${features.map(f => `<li>${f}</li>`).join("")}
        </ul>
        <h1>${plan.Type}</h1>
        <button class="subscribe-btn" onclick="handlepayment(${plan.Type})">Subscribe Now</button>
        <div class="plan-description">
        </div>
    `;

    if (plan.UserType === "teacher") {
        teacherPlans.appendChild(planCard);
    } else if (plan.UserType === "institute") {
        institutePlans.appendChild(planCard);
    }
});
        }

 
        function handlepayment(planType) {
           
            window.location.href = `http://localhost/group_project_1.0/public/Payment/subscibe/${planType}`;
            
        }

        function togglePlans() {
            const teacherPlans = document.getElementById('teacher-plans');
            const institutePlans = document.getElementById('institute-plans');
            const toggleBtn = document.querySelector('.toggle-btn');

            if (teacherPlans.classList.contains('hidden')) {
                teacherPlans.classList.remove('hidden');
                institutePlans.classList.add('hidden');
                toggleBtn.textContent = 'Switch to Institute Plans';
            } else {
                teacherPlans.classList.add('hidden');
                institutePlans.classList.remove('hidden');
                toggleBtn.textContent = 'Switch to Teacher Plans';
            }
        }
    </script>
</body>
</html>
