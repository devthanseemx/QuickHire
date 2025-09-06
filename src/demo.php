yesBtn.addEventListener("click", () => {
      confirmModal.classList.add("hidden");
      showToast("You clicked Yes!", "success", "description working");
    });

    noBtn.addEventListener("click", () => {
      confirmModal.classList.add("hidden");
      showToast("You clicked No!", "error");
    });
