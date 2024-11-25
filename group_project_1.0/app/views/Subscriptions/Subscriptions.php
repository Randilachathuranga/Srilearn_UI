<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <link rel="stylesheet" href="../../../../group_project_1.0/app/views/Subscriptions/SubStyles.css">
</head>
<body>
    <div class="container">
        <div class="toggle-container">
            <button class="toggle-btn" onclick="togglePlans()">Switch to Institute Plans</button>
        </div>

        <!-- Teacher Plans -->
        <div id="teacher-plans" class="plans-container">
            <div class="plan-card">
                <h2 class="plan-title">Lite</h2>
                <div class="plan-price">$10</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="plan-duration">1 Month</div>
                <ul class="plan-features">
                    <li>Post Ads</li>
                    <li>Individual Class Management</li>
                </ul>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Perfect for individual teachers starting their journey. Post ads and manage your class efficiently.
                </div>
            </div>

            <div class="plan-card">
                <h2 class="plan-title">Pro</h2>
                <div class="plan-price">$100</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="plan-duration">1 Year</div>
                <ul class="plan-features">
                    <li>All Lite Features</li>
                    <li>Extended Ad Posting</li>
                    <li>Priority Support</li>
                </ul>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Ideal for professional teachers. Get extended features and priority support.
                </div>
            </div>

            <div class="plan-card">
                <h2 class="plan-title">Ultimate</h2>
                <div class="plan-price">$150</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="plan-duration">1 Year</div>
                <ul class="plan-features">
                    <li>All Pro Features</li>
                    <li>Chat Service</li>
                    <li>Premium Support</li>
                </ul>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Complete package with all features including chat service and premium support.
                </div>
            </div>
        </div>

        <!-- Institute Plans -->
        <div id="institute-plans" class="plans-container hidden">
            <div class="plan-card">
                <h2 class="plan-title">Lite</h2>
                <div class="plan-price">$50</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="plan-duration">1 Month</div>
                <ul class="plan-features">
                    <li>Job Hiring</li>
                    <li>Payment Handling</li>
                    <li>Ad Posting</li>
                </ul>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Essential features for small institutes. Manage jobs, payments, and ads effectively.
                </div>
            </div>

            <div class="plan-card">
                <h2 class="plan-title">Pro</h2>
                <div class="plan-price">$180</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="feature-checkbox">
                    <input type="checkbox" onchange="updatePrice(this)"> Post Ads (+$10)<br>
                    <input type="checkbox" onchange="updatePrice(this)"> Handle Jobs (+$10)<br>
                    <input type="checkbox" onchange="updatePrice(this)"> Handle Payments (+$10)
                </div>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Customize your plan with the features you need. Pay only for what you use.
                </div>
            </div>

            <div class="plan-card">
                <h2 class="plan-title">Ultimate</h2>
                <div class="plan-price">$200</div>
                <div class="pic"><img src="../../../../group_project_1.0/app/views/subscription.webp"></div>
                <div class="plan-duration">1 Year</div>
                <ul class="plan-features">
                    <li>All Features Included</li>
                    <li>Premium Support</li>
                    <li>Priority Processing</li>
                </ul>
                <button class="subscribe-btn">Subscribe Now</button>
                <div class="plan-description">
                    Complete solution for large institutes. All features included with premium support.
                </div>
            </div>
        </div>
    </div>

    <script>
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

        function updatePrice(checkbox) {
            const planCard = checkbox.closest('.plan-card');
            const priceElement = planCard.querySelector('.plan-price');
            let basePrice = 180;

            const checkboxes = planCard.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(box => {
                if (box.checked) {
                    basePrice += 10;
                }
            });

            priceElement.textContent = `$${basePrice}`;
        }
    </script>
</body>
</html>
