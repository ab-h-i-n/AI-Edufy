import toast from "../utils/toaster.js";
import { askGemini } from "../utils/gemini.js";
import { confettiFire } from "../utils/confetti.js";

const iFrame = document.querySelector("iframe");
var code;
var lang;
var isValidResult;

// to listen to on change event of the code editor
window.onmessage = function (e) {
  if (e.data && e.data.language) {
    console.log(e.data);
    code = e.data.files[0].content;
    lang = e.data.language;
    isValidResult = e.data.result.success;
  }
};

// to run the code
const runBtn = document.querySelector(".run");

runBtn.addEventListener("click", async function () {
  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  console.log("Code:", code);
  console.log("Lang:", lang);
  console.log("Question:", question.innerText);
  console.log("Testcases:", testcases.innerText);

  iFrame.contentWindow.postMessage(
    {
      eventType: "triggerRun",
    },
    "*"
  );

  const req =
    await askGemini(`the question is "${question.innerText}" testcases are ${testcases.innerText} the code "${code}" in "${lang}" is corrent answer for the question provided and also check the testcases are same . give result in JSON FORMAT using {
    "isValid" : boolean,
    "reason" : str
    }`);
  console.log("Parsed Response:", req);

  if (req.isValid && isValidResult) {
    confettiFire(0.5, {
      spread: 120,
      startVelocity: 50,
      decay: 0.92,
      scalar: 1.5,
    });

    toast.success("Congratulations you completed the question 🎉")
  }
});

// to get hint for the code
const hintBtn = document.querySelector(".hint");

hintBtn.addEventListener("click", async function () {
  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  console.log("Code:", code);
  console.log("Lang:", lang);
  console.log("Question:", question.innerText);
  console.log("Testcases:", testcases.innerText);

  const req =
    await askGemini(`the question is "${question.innerText}" testcases are ${testcases.innerText} give a hint and next step about the code "${code}" in "${lang}" in 2 lines in JSON FORMAT using {
    "hint" : str,
    "nextstep" : str
    }`);
  console.log("Parsed Response:", req);
  toast.success(req.hint);
});

//to populate editor
// iFrame.contentWindow.postMessage({
//   eventType: 'populateCode',
//   language: 'python',
//   files: [
//    {
//      "name": "HelloWorld.py",
//      "content": "your code...."
//    }
// ]
// }, "*");
