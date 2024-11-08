import { askGemini } from "../utils/gemini.js";
import { confettiFire } from "../utils/confetti.js";
import toast from "../utils/toast.js";

const iFrame = document.querySelector("iframe");
var code;
var lang;
var isValidResult;
const completeTaskBtn = document.querySelector("button.complete");

//to populate editor
const completedAns = document.querySelector(".completed-ans");
const completedLang = document.querySelector(".completed-lang");

const populateEditor = async () => {
  if ((completedAns, completedLang)) {
    iFrame.contentWindow.postMessage(
      {
        eventType: "populateCode",
        language: completedLang.innerText,
        files: [
          {
            name: "main",
            content: completedAns.innerText,
          },
        ],
      },
      "*"
    );
  }
};

setTimeout(() => {
  populateEditor();
}, 2000);

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
    await askGemini(`the question is "${question.innerText}" testcases are ${testcases.innerText} the code "${code}" in "${lang}" is corrent answer for the question provided and also check the testcases are same and the program should contain code to print the output . give result in JSON FORMAT using {
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

    toast.success("Congratulations you completed the question 🎉");
    completeTaskBtn.disabled = false;
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

  toast.loading("Getting Hint ...");
  const req =
    await askGemini(`help beginner to solve  the question is "${question.innerText}" testcases are ${testcases.innerText} give a hint for next step also the next step code , if any errors in code please mention it also "${code}" in "${lang}" in 2 lines in JSON FORMAT using {
    "hint" : str,
    "nextstep" : str
    }`);
  console.log("Parsed Response:", req);

  toast.dismiss();
  setTimeout(() => {
    toast.hint(req.hint);
  }, 500);
});

//handle completed task

completeTaskBtn.addEventListener("click", async function () {
  console.log("Task Completed");
  const quesId = window.location.search.split("=")[1];

  try {
    const req = await fetch(
      `http://localhost/AI-Edufy/api/question/complete.php?qId=${quesId}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          answer: code,
          language: lang,
        }),
      }
    );

    const res = await req.json();

    console.log(res);

    if (res.status === 200) {
      toast.success("Task Completed Successfully");
      window.location.reload();
    } else {
      toast.error("Task Completion Failed");
    }

    console.log(res);
  } catch (error) {
    console.error(error);
  }
});
