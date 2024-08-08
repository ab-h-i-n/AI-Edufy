const passInput = document.querySelector('.auth-form input[name="password"]');
const eyeContainer = document.querySelector(".eye-container");
eyeContainer.onclick = () => {
  document.querySelector(".eye-open").classList.toggle("hidden");
  document.querySelector(".eye-closed").classList.toggle("hidden");

  const isPassword = passInput.type === "password";

  passInput.type = isPassword ? "text" : "password";
};

// auth
const baseUrl = "http://localhost/AI-Edufy/api";

//login
const loginForm = document.querySelector(".auth-form.login");
loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  try {
    const response = await fetch(`${baseUrl}/auth/login.php`, {
      method: "POST",
      body: JSON.stringify({
        email: loginForm.email.value,
        password: loginForm.password.value,
      }),
    });

    const result = await response.text();

    console.log(result);
  } catch (error) {
    console.error(error);
  }
});


function LoginVerfication(email, pass) {}
