
import toast  from "../utils/toaster.js";
import {askGemini} from "../utils/gemini.js";


const iFrame = document.querySelector("iframe");
var code;
var lang;


// to listen to on change event of the code editor
window.onmessage = function (e) {
  if (e.data && e.data.language) {
    console.log(e.data);
    code = e.data.files[0].content;
    lang = e.data.language;
  }
};

// to run the code
const runBtn = document.querySelector(".run");

runBtn.addEventListener("click", async function () {
  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  console.log("Code:", code);
  console.log("Lang:", lang);
  console.log("Question:", question.innerHTML);
  console.log("Testcases:", testcases.innerHTML);
  

  iFrame.contentWindow.postMessage(
    {
      eventType: "triggerRun",
    },
    "*"
  );

  const req = await askGemini(`the question is "${question.innerHTML}" testcases are ${testcases} the code "${code}" in "${lang}" is corrent answer for the question provided . give result in JSON FORMAT using {
    "isValid" : boolean
    }`);
  console.log("Parsed Response:", req);
});

// to get hint for the code
const hintBtn = document.querySelector(".hint");

hintBtn.addEventListener("click", async function () {
  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  console.log("Code:", code);
  console.log("Lang:", lang);
  console.log("Question:", question.innerHTML);
  console.log("Testcases:", testcases.innerHTML);
  

  const req = await askGemini(`the question is "${question.innerHTML}" testcases are ${testcases} give a hint and next step about the code "${code}" in "${lang}" in 2 lines in JSON FORMAT using {
    "hint" : str
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