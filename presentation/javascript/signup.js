	// Get the elements
    const form = document.getElementById("signup-form");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const passwordMismatchError = document.getElementById("password-mismatch-error");
    const signupButton = document.getElementById("signup-button");

    // Check password
    function checkPassword() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            passwordMismatchError.textContent = "Passwords did not match";
            signupButton.disabled = true;
        } else {
            passwordMismatchError.textContent = "";
            signupButton.disabled = false;
        }
    }

    passwordInput.addEventListener("input", checkPassword);
    confirmPasswordInput.addEventListener("input", checkPassword);

    // Submit form
    form.addEventListener("submit", (event) => {
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault();
            passwordMismatchError.textContent = "Passwords did not match";
            signupButton.disabled = true;
        }
    });