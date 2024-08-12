import toast from "../utils/toaster.js";
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
loginForm?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const email = loginForm.email.value;
  const pass = loginForm.password.value;

  const isValid = LoginVerification(email, pass);

  if (!isValid) {
    return;
  }

  try {
    toast.loading("Logging in....");
    const response = await fetch(`${baseUrl}/auth/login.php`, {
      method: "POST",
      body: JSON.stringify({
        email: email,
        password: pass,
      }),
    });

    const result = await response.json();

    if (result?.status != 200) {
      toast.error(result?.msg);
    } else {
      toast.success("Logged in successfully!");
      window.location.href = "/AI-Edufy/home";
    }
  } catch (error) {
    console.error(error);
  }
});

function LoginVerification(email, password) {
  if (!email || !password) {
    toast.warning("Input all the fields!");
    return false;
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    toast.warning("Invalid  email!");
    return false;
  }

  return true;
}

//signup
const signUpFrom = document.querySelector(".auth-form.signup");
signUpFrom?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const name = signUpFrom.name.value;
  const email = signUpFrom.email.value;
  const pass = signUpFrom.password.value;
  const role = signUpFrom.role.value;
  var image = signUpFrom.image.files[0];

  image = image ? await toBase64(image) : null;

  const isValid = SignUpVerification(name, email, pass, role);

  if (!isValid) {
    return;
  }

  try {
    toast.loading("Logging in....");
    const response = await fetch(`${baseUrl}/auth/signup.php`, {
      method: "POST",
      body: JSON.stringify({
        email: email,
        password: pass,
        name : name,
        role : role,
        image : image,
      }),
    });

    const result = await response.text();

    console.log(result);
    

    // if (result?.status != 200) {
    //   toast.error(result?.msg);
    // } else {
    //   toast.success("Signed up successfully!");
    //   window.location.href = "/AI-Edufy/home";
    // }
  } catch (error) {
    console.error(error);
  }
});

function SignUpVerification(name, email, password, role) {
  if (!email || !password || !name || !role) {
    toast.warning("Input all the fields!");
    return false;
  }
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    toast.warning("Invalid  email!");
    return false;
  }
  if (password.length < 5) {
    toast.warning("Password should be greater than 5 characters");
    return false;
  }

  return true;
}

function toBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
}
