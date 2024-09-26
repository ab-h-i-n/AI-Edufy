function addTestCase() {
    const testCaseContainer = document.querySelector('.test-cases-container');
    const newTestCase = document.createElement('div');
    newTestCase.className = 'test-case';

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