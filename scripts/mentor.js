import toast from "../utils/toaster.js";
import loader from "../utils/loader.js";

// Add new test case
function addTestCase() {
  const testCaseContainer = document.querySelector(".test-cases-container");
  const newTestCase = document.createElement("div");
  newTestCase.className = "test-case";

  newTestCase.innerHTML = `
       
            <label>Input</label>
            <input type="text" name="input[]" placeholder="Input" required>
            <label>Output</label>
            <input type="text" name="output[]" placeholder="Output" required>
            <div onclick="removeTestCase(this)" class="add-btn-container">
                <span class="add-btn">
                <span class="add-label">Remove</span>
                    <img src="../public/icons/minus.svg" alt="plus">
                </span>
  
    `;
  testCaseContainer.appendChild(newTestCase);
}

function removeTestCase(button) {
  const testCase = button.parentElement;
  testCase.remove();
}

//creating new quetions form submission

const form = document.querySelector("#create-question");

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  console.log('form submitted');
  if (validateForm()) {
    toast.success("New Question Created Successfully");
  }
});

function validateForm() {
    const inputFields = document.querySelectorAll('input[name="input[]"]');
    const outputFields = document.querySelectorAll('input[name="output[]"]');
    const titleField = document.getElementById('ques-title');
    const descriptionField = document.getElementById('ques-desc');
    const typeField = document.getElementById('ques-type');
    const languageField = document.getElementById('ques-lang');
    const pointsField = document.getElementById('ques-points');
    
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
  
    // Validate language
    if (!languageField.value) {
      toast.error("Please select a programming language.");
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
      toast.error("Please add at least one test case with both input and output.");
      return false;
    }
  
    return true;
  }
  