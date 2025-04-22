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
            <?php if ($_SESSION['Role'] === 'teacher'): ?>
                <h2>Teacher Plans</h2>
            <?php elseif ($_SESSION['Role'] === 'institute'): ?>
                <h2>Institute Plans</h2>
            <?php endif; ?>
        </div>

        <!-- Plans Container - Only one will be shown based on role -->
        <div id="plans-container" class="plans-container"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const userRole = "<?php echo $_SESSION['Role']; ?>";
            
            fetch("http://localhost/group_project_1.0/public/Subscriptions/viewallsubdetails")
                .then(response => response.json())
                .then(data => renderPlans(data, userRole))
                .catch(error => console.error("Failed to fetch plans:", error));
        });

        function renderPlans(plans, userRole) {
            const plansContainer = document.getElementById("plans-container");
            plansContainer.innerHTML = "";

            // Define plan type names
            const typeNames = {
                1: "Lite",
                2: "Pro",
                3: "Ultimate",
                4: "Lite",
                5: "Pro",
                6: "Ultimate"
            };

            // Filter plans based on user role
            const filteredPlans = plans.filter(plan => {
                if (userRole === 'teacher') {
                    return plan.Type >= 1 && plan.Type <= 3;
                } else if (userRole === 'institute') {
                    return plan.Type >= 4 && plan.Type <= 6;
                }
                return false;
            });

            // Render the filtered plans
            filteredPlans.forEach(plan => {
                const planCard = document.createElement("div");
                planCard.className = "plan-card";

                // Get correct plan title
                const title = typeNames[plan.Type] || "Plan";

                // Set price based on plan type
                let price = 0;
                if (plan.Type === 1) price = 10;
                else if (plan.Type === 2) price = 15;
                else if (plan.Type === 3) price = 20;
                else if (plan.Type === 4) price = 20;
                else if (plan.Type === 5) price = 35;
                else if (plan.Type === 6) price = 50;

                // Collect features
                const features = [];
                if (plan.Isjobavail == 1) features.push("Job Hiring");
                features.push("Message System");
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
                     <h2 class="plan-title">${plan.Type}</h2>
                    <button class="subscribe-btn" onclick="handlepayment(${plan.Type})">Subscribe Now</button>
                    <div class="plan-description">
                    </div>
                `;

                plansContainer.appendChild(planCard);
            });
        }

        function handlepayment(planType) {
            window.location.href = `http://localhost/group_project_1.0/public/Payment/subscibe/${planType}`;
        }
    </script>
</body>
</html>