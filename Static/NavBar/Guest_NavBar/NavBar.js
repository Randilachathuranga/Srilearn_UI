// Toggle the mobile overlay menu
function toggleMenu() {
    const navOverlay = document.getElementById("navOverlay");
    const navBackground = document.getElementById("navBackground");
    
    // Toggle 'show' class for the sidebar
    navOverlay.classList.toggle("show");

    // Toggle 'active' class for background overlay
    navBackground.classList.toggle("show");
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
    // Close dropdown menu if clicking outside
    if (!event.target.matches('.dropdown-toggle')) {
        const dropdowns = document.getElementsByClassName('dropdown-content');
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }

    // Close nav overlay if clicking outside of it
    const navOverlay = document.getElementById('navOverlay');
    if (navOverlay.style.display === 'flex' && !event.target.closest('.menu-icon') && !event.target.closest('.nav-overlay')) {
        navOverlay.style.display = 'none';
    }
};

function Login(){
    alert("login")
}

function singup(){
    alert("signup")
}
