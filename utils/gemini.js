const apiKey = "AIzaSyD5gwNeYP8AjdDynsQtf9bYI4QlkVMLS5E";
const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`;

export async function askGemini(prompt) {
  const requestBody = {
    contents: [
      {
        parts: [
          {
            text: prompt
          },
        ],
      },
    ],
    generationConfig: {
      response_mime_type: "application/json",
    },
  };

  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(requestBody),
    });

    const data = await response.json();
    console.log("Full Response:", data);

    if (data.error) {
      throw new Error(data.error.message);
    }else{
      return JSON.parse(data.candidates[0].content.parts[0].text || "{}");
    }

  } catch (error) {
    console.error("Error:", error);
  }
}

//example

// (async () => {
//   const req = await askGemini(`List a few popular cookie recipes using this JSON schema:

//   Recipe = {"recipe_name": str}
//   Return: list[Recipe]`);
//   console.log("Parsed Response:", req);
// })();
