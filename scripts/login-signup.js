const passInput = document.querySelector('.auth-form input[name="password"]');
const eyeContainer = document.querySelector(".eye-container");

eyeContainer.onclick = () => {
  document.querySelector(".eye-open").classList.toggle("hidden");
  document.querySelector(".eye-closed").classList.toggle("hidden");

  const isPassword = passInput.type === "password";

  passInput.type = isPassword ? "text" : "password";
};
