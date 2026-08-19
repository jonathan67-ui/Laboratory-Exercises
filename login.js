const loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    const loginAlert = document.getElementById("loginAlert");

    if (username === "admin" && password === "password123") {

        localStorage.setItem("username", username);

        window.location.href = "dashboard.html";

    } else {

        loginAlert.innerHTML = `
            <div class="alert alert-danger">
                Invalid username or password.
            </div>
        `;

    }

});