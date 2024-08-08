const currentPath = window.location.pathname.split("/")[2];

switch (currentPath) {
  case "login":
    document.querySelector("header .login-btn").classList.add("hidden");
    break;
  case "signup":
    document.querySelector("header .signup-btn").classList.add("hidden");
    break;
}
