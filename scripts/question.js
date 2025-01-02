import { askGemini } from "../utils/gemini.js";
import { confettiFire } from "../utils/confetti.js";
import toast from "../utils/toast.js";

const iFrame = document.querySelector("iframe");
var code;
var lang;
var isValidResult;
var result;
var action;
const completeTaskBtn = document.querySelector("button.complete");

//to populate editor
const completedAns = document.querySelector(".completed-ans");
const completedLang = document.querySelector(".completed-lang");

const languages = {
  python: "py",
  java: "java",
  javascript: "js",
  c: "c",
  cpp: "cpp",
  php: "php",
};

const populateEditor = async () => {
  if ((completedAns, completedLang)) {
    iFrame.contentWindow.postMessage(
      {
        eventType: "populateCode",
        language: completedLang.innerText,
        files: [
          {
            name: "main." + languages[completedLang.innerText],
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
window.onmessage = async function (e) {
  if (e.data && e.data.language) {
    console.log(e.data);
    code = e.data.files[0].content;
    lang = e.data.language;
    isValidResult = e.data.result?.success;
    result = e.data.result?.output;
    action = e.data.action;

    if (action == "runComplete") {
      await checkCode();
    }
  }
};

// to run the code
const runBtn = document.querySelector(".run");

runBtn.addEventListener("click", async function () {

  iFrame.contentWindow.postMessage(
    {
      eventType: "triggerRun",
    },
    "*"
  );
});

async function checkCode() {

  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  const query = `I want Gemini to check if the given output matches the expected result for the programming question and its test cases. The validation should consider the provided code, question, and test cases. 

  Input details:
  - Question: ${question?.innerText}
  - Test Cases: ${testcases?.innerText}
  - Code in ${lang}: ${code}
  - Obtained Output: ${result}

  Gemini should return the result in the following JSON format:
  {
      "isValid": boolean,
      "reason": string
  }

  Notes:
  1. Ensure the input and ouput is same as testcase any one input and output.
  2. Dont take user input for this question.
  3. Input from the user is not necessary for this question.
  4. Only need to satisfy anyone of the testcases provided.
`;

  console.log("Query:", query);
  document.querySelector(".hint-content").innerText =
    "⏳ Checking the code ... ";
  let req = await askGemini(query);
  console.log("Parsed Response:", req);

  if (req?.isValid && isValidResult && code) {
    confettiFire(0.5, {
      spread: 120,
      startVelocity: 50,
      decay: 0.92,
      scalar: 1.5,
    });

    toast.success("Congratulations you completed the question 🎉");
    document.querySelector(".hint-content").innerText =
      "Congratulations you completed the question 🎉";
    completeTaskBtn.disabled = false;
  } else {
    if (req?.reason) {
      // toast.hint(req.reason);
      document.querySelector(".hint-content").innerText =
        "🔧 Fix: " + req?.reason;
    }
  }
}

const generateHint = async (question, testcases) => {
  

  try {
    const query = `i want gemini to check the code and provide hint and nextstep.It is not necessary to take input from the user .if no error , question : ${question.innerText} , testcases : ${testcases.innerText} , code : ${code} , runlog : ${result}  .Return the reuslt in json format {
    "hint" : str,
    "nextstep" : str
    } if error is found in code syntax language ${lang} use format {
     "error" : str
      "howtofix" : str
    }`;

    const req = await askGemini(query);
    console.log("Parsed Response:", req);

    if (!code) {
      toast.hint("Please initialize the input as a variable to start !");
      return;
    }

    if (!req) {
      throw new Error("Failed to get hint");
    }

    toast.dismiss();
    return req;
  } catch (error) {
    toast.dismiss();
    toast.error(error);
    console.error(error);
  }
};
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
  document.querySelector(".hint-content").innerText = "Getting Hint ...";
  const res = await generateHint(question, testcases);

  setTimeout(() => {
    // toast.hint(res.hint);
    document.querySelector(".hint-content").innerText = "💡 Hint: " + res?.hint;
  }, 500);
});

const nextStepBtn = document.querySelector(".next-step");

nextStepBtn.addEventListener("click", async function () {
  const question = document.querySelector(".question-desc");
  const testcases = document.querySelector("#alltestcases");

  console.log("Code:", code);
  console.log("Lang:", lang);
  console.log("Question:", question.innerText);
  console.log("Testcases:", testcases.innerText);

  toast.loading("Getting next step ...");
  document.querySelector(".hint-content").innerText = "Getting Next Step ...";
  const res = await generateHint(question, testcases);
  setTimeout(() => {
    // toast.hint(res.nextstep);
    document.querySelector(".hint-content").innerText =
      "🚀 Next Step: " + res?.nextstep;
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
  } catch (error) {
    console.error(error);
  }
});
