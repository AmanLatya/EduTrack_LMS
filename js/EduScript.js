$(document).ready(function () {
    let $toggleCourse = $("#viewAll");

    $toggleCourse.text("View All");

    $toggleCourse.click(function () {
        if ($toggleCourse.text() === "View All") {
            $toggleCourse.text("View Less");
        } else {
            $toggleCourse.text("View All");
        }
    });
});

// -----------------------Start Course Detail---------------------------
function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => {
        tab.classList.add('d-none');
    });
    document.getElementById(tabId).classList.remove('d-none');

    const tabLinks = document.querySelectorAll('.tab-link');
    tabLinks.forEach(link => {
        link.classList.remove('active-tab');
        link.classList.add('text-muted');
    });
    event.target.classList.add('active-tab');
    event.target.classList.remove('text-muted');
}

// Display the "Description" tab by default
document.addEventListener('DOMContentLoaded', function() {
    showTab('description');
});

// -----------------------End Course Detail---------------------------



// -----------------------------Start Admin Dashboard--------------------------------

// js
document.getElementById("sidebarToggle").addEventListener("click", function() {
    document.getElementById("sidebar").classList.toggle("active");
});

// -----------------------------End Admin Dashboard--------------------------------