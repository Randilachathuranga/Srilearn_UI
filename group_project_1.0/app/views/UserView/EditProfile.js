document.addEventListener("DOMContentLoaded", () => {
    // Form and fields
    const form = document.querySelector("form");
    const fields = {
        F_name: document.querySelector('input[name="F_name"]'),
        L_name: document.querySelector('input[name="L_name"]'),
        Email: document.querySelector('input[name="Email"]'),
        District: document.querySelector('input[name="District"]'),
        Phone_number: document.querySelector('input[name="Phone_number"]'),
        Address: document.querySelector('input[name="Address"]'),
        Password: document.querySelector('input[name="Password"]')
    };

    // Validation logic
    function validateField(field, value) {
        let errorMessage = "";

        switch (field) {
            case "F_name":
            case "L_name":
                if (value.trim().length < 2) {
                    errorMessage = `${field.replace("_", " ")} must be at least 2 characters long.`;
                }
                break;
            case "Email":
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errorMessage = "Invalid email format.";
                }
                break;
            case "Phone_number":
                if (!/^\d{10}$/.test(value)) {
                    errorMessage = "Phone number must be exactly 10 digits.";
                }
                break;
            case "District":
            case "Address":
                if (value.trim() === "") {
                    errorMessage = `${field.replace("_", " ")} cannot be empty.`;
                }
                break;
            case "Password":
                if (value && value.length < 8) {
                    errorMessage = "Password must be at least 8 characters long.";
                }
                break;
            default:
                break;
        }

        return errorMessage;
    }

    // Add validation on form submit
    form.addEventListener("submit", (e) => {
        e.preventDefault(); // Prevent default submission

        const errors = [];
        const formData = {};

        // Validate each field
        for (const [field, input] of Object.entries(fields)) {
            const error = validateField(field, input.value);
            if (error) {
                errors.push(error);
                input.classList.add("error"); // Add error class
            } else {
                input.classList.remove("error"); // Remove error class if valid
            }
            formData[field] = input.value; // Collect field values
        }

        // Display errors or submit the form
        const errorBox = document.getElementById("errorBox");
        const successBox = document.getElementById("successBox");

        if (errors.length > 0) {
            // Show errors
            errorBox.innerHTML = errors.map((error) => `<p>${error}</p>`).join("");
            errorBox.style.display = "block";
            successBox.style.display = "none";
        } else {
            // Submit the form
            errorBox.style.display = "none";
            successBox.style.display = "block";
            successBox.textContent = "Profile updated successfully!";

            // Simulate form submission (AJAX can be added here for real submission)
            setTimeout(() => {
                form.submit(); // Submit the form after validation
            }, 1000);
        }
    });

    // Clear error messages on input focus
    for (const input of Object.values(fields)) {
        input.addEventListener("focus", () => {
            input.classList.remove("error");
            const errorBox = document.getElementById("errorBox");
            errorBox.style.display = "none";
        });
    }
});
