<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing Plans</title>
  <link rel="stylesheet" href="./SubStyles.css">
</head>
<body>

  <div class="pricing-section">
    <h2>Our Pricing Plans</h2>
    <p>Pick an account plan that fits your workflow</p>

    <div class="billing-toggle">
      <span>Monthly</span>
      <input type="checkbox" id="billing-switch" onclick="toggleBilling()">
      <span>Annually</span>
    </div>

    <div class="pricing-cards">
      <div class="card starter">
        <h3>Starter</h3>
        <p class="price free">Free</p>
        <p>Free forever when you host with Debbi, free for freelancers with Client Billing</p>
        <ul>
          <li>1 Class</li>
          <li>25 Students</li>
          <li>Blogs</li>
          <li class="no-tick">Chat system</li> <!-- No checkmark here -->
          <li class="no-tick">Advertisements</li> <!-- No checkmark here -->
        </ul>
        <button class="plan-btn">Current plan</button>
      </div>

      <div class="card lite">
        <h3>Lite <span></span></h3>
        <p class="price">$<span class="price-amount">16</span>/Monthly</p>
        <p>Free forever when you host with Debbi, free for freelancers with Client Billing</p>
        <ul>
          <li>10 Classes</li>
          <li>70 Students</li>
          <li>Blogs</li>
          <li>Chat system</li>
          <li class="no-tick">Advertisements</li> <!-- No checkmark here -->
        </ul>
        <button class="plan-btn" onclick="addLite()">Upgrade plan</button>
      </div>

      <div class="card pro">
        <h3>Pro</h3>
        <p class="price">$<span class="price-amount">35</span>/Monthly</p>
        <p>Free forever when you host with Debbi, free for freelancers with Client Billing</p>
        <ul>
          <li>25+ Classes</li>
          <li>250+ Students</li>
          <li>Blogs</li>
          <li>Chat system</li>
          <li>Advertisements</li>
        </ul>
        <button class="plan-btn" onclick="addPro()">Upgrade plan</button>
      </div>
    </div>
  </div>

  <script src="./SubsScript.js"></script>
</body>
</html>
