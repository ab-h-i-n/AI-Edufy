import toast from "../utils/toast.js";
import { closeModal } from "./global.js";

const ctx = document.getElementById("progress-chart")?.getContext("2d");

// Pass PHP variables to JavaScript
const easySolved = Number(document.getElementById("easy-solved").innerText);
const mediumSolved = Number(document.getElementById("medium-solved").innerText);
const hardSolved = Number(document.getElementById("hard-solved").innerText);

const easyTotal = Number(document.getElementById("easy-total").innerText);
const mediumTotal = Number(document.getElementById("medium-total").innerText);
const hardTotal = Number(document.getElementById("hard-total").innerText);

const totalQuestions = easyTotal + mediumTotal + hardTotal;
const totalSolved = easySolved + mediumSolved + hardSolved;

const progressChart = new Chart(ctx, {
  type: "doughnut",
  data: {
    datasets: [
      {
        data: [
          easySolved,
          mediumSolved,
          hardSolved,
          totalQuestions - totalSolved,
        ],
        backgroundColor: ["#008000", "#ff4500", "#ff0000", "#2d2d2d"],
        borderWidth: 0,
        cutout: "70%",
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
      tooltip: {
        enabled: true,
      },
    },
  },
});

//update profile

//image select
const imageInput = document.querySelector("#profile-image-input");
const imagePreview = document.querySelector("#profile-image-photo");

imageInput.addEventListener("change", async (e) => {
  const file = e.target.files[0];
  const imageUrl = await toBase64(file);
  imagePreview.src = imageUrl;
});

const updateProfileForm = document.querySelector("#update-profile");
updateProfileForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const name = updateProfileForm.name.value;
  const email = updateProfileForm.email.value;
  const image = imageInput.files[0];


  if (!name || !email) {
    toast.error("Please fill all the fields!");
    return;
  }

  const formData = new FormData();
  formData.append("name", name);
  formData.append("email", email);
  formData.append("image", image);

 try {
  const response = await fetch(
    "http://localhost/AI-Edufy/api/user/update.php",
    {
      method: "POST",
      body: formData,
    }
  );

  const result = await response.json();

  console.log(result);
  
  if (result?.status != 200) {
    toast.error(result?.msg);
  } else {
    toast.success("Profile updated successfully!");
    closeModal();
    setTimeout(() => {
      window.location.reload();
    }, 1000);
  }
} catch (error) {
  toast.error("Something went wrong!");
  console.error(error);
}

});

function toBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
}
