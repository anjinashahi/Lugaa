document.addEventListener("DOMContentLoaded", () => {
  let editProfileBtn = document.getElementById("edit-profile-btn");
  let editProfileModal = document.getElementById("edit-profile-modal");
  let closeModal = document.getElementsByClassName("close")[0];

  // Show modal when the button is clicked
  editProfileBtn.addEventListener("click", () => {
      editProfileModal.style.display = "block";
  });

  // Hide modal when the close button is clicked
  closeModal.addEventListener("click", () => {
      editProfileModal.style.display = "none";
  });

  // Hide modal when user clicks outside of it
  window.addEventListener("click", (event) => {
      if (event.target == editProfileModal) {
          editProfileModal.style.display = "none";
      }
  });
});
