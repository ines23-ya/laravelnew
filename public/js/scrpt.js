document.addEventListener("DOMContentLoaded", function () {
    var eyeIcon = document.getElementById("eyeIcon");
    var passwordInput = document.getElementById("password");

    if (eyeIcon && passwordInput) {
        eyeIcon.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        });
    }
});
