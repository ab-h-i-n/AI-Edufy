import toast from "../utils/toast.js";
import loader from "../utils/loader.js";
import { closeModal } from "./global.js";

// Add new test case

const addBtn = document.querySelector(".add-testcase");
var removeBtns = document.querySelectorAll(".remove-btn");
var removedTestCase = [];

addBtn?.addEventListener("click", addTestCase);
removeBtns.forEach((button) => {
  button.addEventListener("click", () => {
    removeTestCase(button);
  });
});

function addTestCase() {
  const testCaseContainer = document.querySelector(".test-cases-container");
  const newTestCase = document.createElement("div");
  newTestCase.className = "test-case";

  newTestCase.innerHTML = `
       
            <label>Input</label>
            <input type="text" name="input[]" placeholder="Input" required>
            <label>Output</label>
            <input type="text" name="output[]" placeholder="Output" required>
            <div class="add-btn-container remove-btn">
                <span class="add-btn">
                <span class="add-label">Remove</span>
                    <img src="../public/icons/minus.svg" alt="plus">
                </span>
  
    `;
  testCaseContainer.appendChild(newTestCase);

  // add event listener to remove button of new test case
  removeBtns = document.querySelectorAll(".remove-btn");
  removeBtns.forEach((button) => {
    button.addEventListener("click", () => {
      removeTestCase(button);
    });
  });
}

function removeTestCase(button) {
  const testCase = button.parentElement;
  console.log(button.id);

  if (button.id) {
    testCase.classList.add("hidden");
    removedTestCase.push(button.id);
  } else {
    testCase.remove();
  }
}

//creating new / updating quetions form submission

const titleField = document.getElementById("ques-title");
const descriptionField = document.getElementById("ques-desc");
const typeField = document.getElementById("ques-type");
const pointsField = document.getElementById("ques-points");
const userId = document.getElementById("user-id");

const form = document.querySelector("#create-question");

form?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const quesId = document.getElementById("ques-id")?.value;
  const submitBtn = document.querySelector(
    "#create-question button[name='create']"
  );

  const inputFields = document.querySelectorAll('input[name="input[]"]');
  const outputFields = document.querySelectorAll('input[name="output[]"]');

  if (validateForm()) {
    if (!quesId) {
      try {
        toast.loading("Creating New Question...");

        const dataBody = {
          userId: userId.value,
          title: titleField.value,
          description: descriptionField.value,
          type: typeField.value,
          points: pointsField.value,
          testCases: Array.from(inputFields).map((inputField, index) => {
            return {
              input: inputField.value,
              output: outputFields[index].value,
            };
          }),
        };

        console.log(dataBody);

        const response = await fetch(
          "http://localhost/AI-Edufy/api/question/createQuestion.php",
          {
            method: "POST",
            body: JSON.stringify(dataBody),
          }
        );

        console.log(response);

        const data = await response.json();

        if (data.status === 200) {
          toast.success(data.msg);
          form.reset();
          closeModal();
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          toast.error(data.msg);
        }
      } catch (error) {
        toast.error("Failed to create question. Please try again.");
        console.error(error);
      }
    } else {
      try {
        const updateBtn = document.querySelector(
          "#create-question button[name='update']"
        );
        toast.loading("Updating Question...");

        const inputFields = document.querySelectorAll('input[name="input[]"]');
        const outputFields = document.querySelectorAll(
          'input[name="output[]"]'
        );

        const bodyData = {
          quesId: quesId,
          userId: userId.value,
          title: titleField.value,
          description: descriptionField.value,
          type: typeField.value,
          points: pointsField.value,
          testCases: Array.from(inputFields).map((inputField, index) => {
            return {
              input: inputField.value,
              output: outputFields[index].value,
              id: inputField.id || null,
              deleted: removedTestCase.includes(inputField.id),
            };
          }),
        };

        console.log(bodyData);

        const response = await fetch(
          "http://localhost/AI-Edufy/api/question/updateQuestion.php",
          {
            method: "POST",
            body: JSON.stringify(bodyData),
          }
        );

        console.log(response);

        const data = await response.json();

        console.log(data);
        loader.add(updateBtn);

        if (data.status === 200) {
          toast.success(data.msg);
          setTimeout(() => {
            closeModal();
          }, 1000);
        } else {
          toast.error(data.msg);
        }
      } catch (error) {
        toast.error("Failed to update question. Please try again.");
        console.error(error);
      }
    }
  }
});

function validateForm() {
  let hasTestCase = false;

  // Validate title
  if (!titleField.value) {
    toast.error("Title cannot be empty.");
    return false;
  }

  // Validate description
  if (!descriptionField.value) {
    toast.error("Description cannot be empty.");
    return false;
  }

  // Validate type
  if (!typeField.value) {
    toast.error("Please select a question type.");
    return false;
  }

  // Validate points
  if (!pointsField.value || pointsField.value <= 0) {
    toast.error("Points must be a positive number.");
    return false;
  }

  const inputFields = document.querySelectorAll('input[name="input[]"]');
  const outputFields = document.querySelectorAll('input[name="output[]"]');

  // Validate test cases
  for (let i = 0; i < inputFields.length; i++) {
    if (!inputFields[i].value) {
      toast.error(`Input field ${i + 1} cannot be empty.`);
      return false;
    }

    if (!outputFields[i].value) {
      toast.error(`Output field ${i + 1} cannot be empty.`);
      return false;
    }

    if (inputFields[i].value && outputFields[i].value) {
      hasTestCase = true;
    }
  }

  if (!hasTestCase) {
    toast.error(
      "Please add at least one test case with both input and output."
    );
    return false;
  }

  return true;
}

//delete question

const deleteBtn = document.querySelector("button[name='delete']");

deleteBtn?.addEventListener("click", async () => {
  try {
    const quesId = document.getElementById("ques-id")?.value;

    if (quesId) {
      toast.loading("Deleting Question...");

      const response = await fetch(
        `http://localhost/AI-Edufy/api/question/delete.php?id=${quesId}`
      );

      const data = await response.json();
      loader.add(deleteBtn);

      if (data.status === 200) {
        toast.success(data.message);
        setTimeout(() => {
          closeModal();
        }, 1000);
      } else {
        toast.error(data.message);
      }
    }
  } catch (error) {
    toast.error("Failed to delete question. Please try again.");
    console.error(error);
  }
});

//update mentor profile

//image select
const imageInput = document.querySelector("#profile-image-input");
const imagePreview = document.querySelector("#profile-image-photo");

imageInput?.addEventListener("change", async (e) => {
  const file = e.target.files[0];
  const imageUrl = await toBase64(file);
  imagePreview.src = imageUrl;
});

const updateProfileForm = document.querySelector("#update-profile");
updateProfileForm?.addEventListener("submit", async (e) => {
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
