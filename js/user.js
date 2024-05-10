document.addEventListener("DOMContentLoaded", function() {
    var editProfileBtn = document.getElementById("edit-profile-btn");
    var editProfileSection = document.getElementById("edit-profile");
    var editProfileForm = document.getElementById("edit-profile-form");

    // Show popup section when the button is clicked
    editProfileBtn.addEventListener("click", function() {
        editProfileSection.style.display = "block";
        editProfileForm.style.display = "block";
    });

    // Hide popup section when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target !== editProfileBtn && !editProfileForm.contains(event.target)) {
            editProfileSection.style.display = "none";
            editProfileForm.style.display = "none";
        }
    });
});
