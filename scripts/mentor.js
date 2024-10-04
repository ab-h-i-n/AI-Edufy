import toast from "../utils/toaster.js";
import loader from "../utils/loader.js";

//modal close

const modal = document.querySelector(".modal");
const modalClose = () => {
  modal.classList.add("closed");
  document.querySelector("body").style.overflowY = "auto";
};

// Add new test case

const addBtn = document.querySelector(".add-btn");
var removeBtns = document.querySelectorAll(".remove-btn");

addBtn.addEventListener("click", addTestCase);

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
  testCase.remove();
}

//creating new quetions form submission

const inputFields = document.querySelectorAll('input[name="input[]"]');
const outputFields = document.querySelectorAll('input[name="output[]"]');
const titleField = document.getElementById("ques-title");
const descriptionField = document.getElementById("ques-desc");
const typeField = document.getElementById("ques-type");
const pointsField = document.getElementById("ques-points");
const userId = document.getElementById("user-id");

const form = document.querySelector("#create-question");

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  if (validateForm()) {
    try {
      toast.loading("Creating New Question...");

      const response = await fetch(
        "http://localhost/AI-Edufy/api/question/createQuestion.php",
        {
          method: "POST",
          body: JSON.stringify({
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
          }),
        }
      );

      console.log(response);

      const data = await response.json();

      console.log(data);

      if (data.status === 200) {
        toast.success(data.msg);
        form.reset();
        modalClose();
        setTimeout(() => {
          window.location.reload()
        }, 1000);
      } else {
        toast.error(data.msg);
      }
    } catch (error) {
      toast.error("Failed to create question. Please try again.");
      console.error(error);
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
