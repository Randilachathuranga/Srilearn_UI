<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #eef2f3;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    .container {
      background: #fff;
      padding: 2.5rem;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      text-align: center;
      width: 360px;
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 1rem;
    }

    p.instructions {
      color: #555;
      font-size: 15px;
      margin-bottom: 20px;
    }

    input[type="email"],
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      background-color: #3498db;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      margin-top: 10px;
      width: 100%;
    }

    button:hover {
      background-color: #2980b9;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      width: 320px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .modal-content h3 {
      margin-bottom: 1rem;
      color: #333;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Forgot Password</h2>
  <p class="instructions">Enter your registered email address below. We'll send you an OTP to verify your identity.</p>
  <form id="emailForm">
    <input type="email" id="email" name="email" placeholder="Enter your registered email" required />
    <button type="submit">Send OTP</button>
  </form>
</div>

<!-- OTP Modal -->
<div class="modal" id="otpModal">
  <div class="modal-content">
    <h3>Enter the OTP</h3>
    <p class="instructions">We’ve sent a one-time password to your email. Enter it below to verify.</p>
    <form id="otpForm">
      <input type="text" id="otp" name="otp" placeholder="Enter OTP" required />
      <button type="submit">Verify OTP</button>
    </form>
  </div>
</div>

<!-- New Password Modal -->
<div class="modal" id="passwordModal">
  <div class="modal-content">
    <h3>Reset Your Password</h3>
    <p class="instructions">Enter your new password below.</p>
    <form id="passwordForm">
      <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required />
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" required />
      <button type="submit">Change Password</button>
    </form>
  </div>
</div>

<script>
  const emailForm = document.getElementById('emailForm');
  const otpModal = document.getElementById('otpModal');
  const otpForm = document.getElementById('otpForm');
  const passwordModal = document.getElementById('passwordModal');
  const passwordForm = document.getElementById('passwordForm');

  function generateOTP() {
    return Math.floor(100000 + Math.random() * 900000).toString();
  }

  let emailValue = ''; // Will store email for use in final password update

  emailForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const emailInput = document.getElementById('email');
    emailValue = emailInput.value.trim();
    const otp = generateOTP();

    // Save OTP locally for client-side validation
    sessionStorage.setItem('otp', otp);

    // Send email and OTP to backend
    fetch('http://localhost/group_project_1.0/public/ForgotPassword/sendotp', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: emailValue,
        otp: otp
      })
    })
    .then(response => {
      if (!response.ok) throw new Error('Failed to send OTP.');
      return response.json();
    })
    .then(data => {
      console.log('OTP sent:', data);
      otpModal.style.display = 'flex';
    })
    .catch(error => {
      console.error('Error:', error);
      alert('There was a problem sending the OTP. Please try again.');
    });
  });

  otpForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const enteredOtp = document.getElementById('otp').value.trim();
    const originalOtp = sessionStorage.getItem('otp');

    if (enteredOtp === originalOtp) {
      console.log('OTP verified.');
      otpModal.style.display = 'none';
      passwordModal.style.display = 'flex';
    } else {
      alert('Invalid OTP. Please try again.');
    }
  });

  passwordForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    if (newPassword !== confirmPassword) {
      alert('Passwords do not match.');
      return;
    }

    // Send new password to backend
    fetch('http://localhost/group_project_1.0/public/ForgotPassword/changepword', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: emailValue,
        password: newPassword
      })
    })
    .then(response => {
      if (!response.ok) throw new Error('Failed to change password.');
      return response.json();
    })
    .then(data => {
      console.log('Password changed successfully:', data);
      alert('Password changed successfully!');
      passwordModal.style.display = 'none';
      window.location.href = 'Signin'; // Redirect to signin page
    })
    .catch(error => {
      console.error('Error:', error);
      alert('There was a problem changing the password. Please try again.');
    });
  });
</script>

</body>
</html>
