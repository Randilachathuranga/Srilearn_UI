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