<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        :root {
            --primary-color: #030457; /* Dark blue */
            --secondary-color: #0608BD; /* Slightly lighter blue */
            --text-color: #333;
            --light-bg: #f5f7ff;
            --footer-text-color: #ffffff;
            --footer-link-hover: #bbdefb;
        }

        body {
            margin-top: 20px;
            padding: 0;
            color: var(--text-color);
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--footer-text-color);
            padding: 2rem 1.5rem 1rem;
        }

        .footer-content {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            align-items: center;
            margin-bottom: 70px;
        }

        .footer-logo img {
            height: 150px;
            margin-bottom: 0.5rem;
            margin-top: 0.5rem;
        }

        .footer-logo, .quick-links, .contact-info, .social-links {
            flex: 1;
            min-width: 200px;
        }

        .quick-links ul, .social-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .quick-links a, .social-links a {
            color: var(--footer-text-color);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .quick-links a:hover, .social-links a:hover {
            color: var(--footer-link-hover);
        }

        .contact-info p {
            margin: 0.2rem 0;
            font-size: 1rem;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Social Icons Styling */
        .social-links a {
            display: flex;
            align-items: center;
        }

        .social-links i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .footer-content {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .footer-logo img {
                height: 130px;
            }
        }

        @media (max-width: 480px) {
            .footer-content {
                gap: 1rem;
            }
            .footer-logo img {
                height: 100px; /* Smaller logo for mobile */
            }
            .quick-links a, .social-links a {
                font-size: 0.9rem; /* Smaller font size */
            }
            .footer-bottom {
                font-size: 0.8rem; /* Smaller footer text */
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="../Footer/logo.png" alt="Logo">
            </div>
            <div class="quick-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="contact-info">
                <h3>Contact Us</h3>
                <p>Email: support@yourplatform.com</p>
                <p>Phone: +123 456 7890</p>
                <p>Address: 123 Learning St., Knowledge City</p>
            </div>
            <div class="social-links">
                <h3>Follow Us</h3>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 SaiLearn All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
