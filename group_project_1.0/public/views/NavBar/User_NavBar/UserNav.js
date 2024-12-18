// Toggle the mobile overlay menu
function toggleMenu() {
    const navOverlay = document.getElementById("navOverlay");
    const navBackground = document.getElementById("navBackground");
    navOverlay.classList.toggle("show");
    navBackground.classList.toggle("show");
}

function toggleProfile(){
    const profileOverlay = document.getElementById("profileOverlay");
    const profileBackground = document.getElementById("profileBackground");
    profileOverlay.classList.toggle("show");
    profileBackground.classList.toggle("show");
}

// Toggle the dropdown menu for Search Hub
function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

// Close overlay when clicking outside
document.addEventListener("click", function(event) {
    const navOverlay = document.getElementById("navOverlay");
    if (navOverlay.style.display === "flex" && !event.target.closest(".navbar, .nav-overlay")) {
        navOverlay.style.display = "none";
    }
});

// Close dropdown and overlay if clicked outside
window.onclick = function(event) {
    if (!event.target.matches('.dropdown-toggle')) {
        const dropdowns = document.getElementsByClassName('dropdown-content');
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }
    const navOverlay = document.getElementById('navOverlay');
    if (navOverlay.style.display === 'flex' && !event.target.closest('.menu-icon') && !event.target.closest('.nav-overlay')) {
        navOverlay.style.display = 'none';
    }
};

function Logout(){
    alert("You have been logged out");
}

// Select the badge and the bell icon
const notificationBadge = document.getElementById('notificationBadge');
const notificationBell = document.querySelector('.notification-bell');

// Example function to update the badge count
function updateNotifications(count) {
    if (count > 0) {
        notificationBadge.textContent = count; // Update the badge number
        notificationBadge.style.display = 'inline'; // Show the badge
        notificationBell.classList.add('active'); // Add active class
    } else {
        notificationBadge.style.display = 'none'; // Hide the badge
        notificationBell.classList.remove('active'); // Remove active class
    }
}

// Example usage: Updating notifications dynamically
// Simulate fetching notification count
setTimeout(() => {
    updateNotifications(0); // Replace '3' with the actual notification count
}); // Updates after 2 seconds

// Optionally clear notifications on click
notificationBell.addEventListener('click', () => {
    updateNotifications(0); // Clears notifications
});
