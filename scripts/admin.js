import toast from "../utils/toast.js";
import loader from "../utils/loader.js";
import { closeModal } from "./global.js";

const deleUser = document.querySelectorAll(".del-user");

deleUser.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", async () => {
    toast.loading("Deleting.....");
    const userId = deleteBtn.id;
    loader.add(deleteBtn);

    const response = await fetch(
      `http://localhost/AI-Edufy/api/user/delete.php?userid=${userId}`
    );

    const result = await response.json();

    console.log(result);
    loader.remove(deleteBtn, "Delete");

    if (result.status === 200) {
      toast.success(result.message);
    } else {
      toast.error(result.message);
    }
  });
});

const delQues = document.querySelectorAll(".del-ques");

delQues.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", async () => {
    toast.loading("Deleting.....");
    const quesId = deleteBtn.id;
    loader.add(deleteBtn);

    const response = await fetch(
      `http://localhost/AI-Edufy/api/question/delete.php?id=${quesId}`
    );

    const result = await response.json();

    console.log(result);
    loader.remove(deleteBtn, "Delete");

    if (result?.status === 200) {
      toast.success(result.message);
      setTimeout(() => {
        window.location.reload();
      }, 2000);
    } else {
      toast.error(result.message);
    }
  });
});

const delLevel = document.querySelectorAll(".del-level");

delLevel.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", async () => {
    toast.loading("Deleting.....");
    const levelId = deleteBtn.id;
    loader.add(deleteBtn);

    const response = await fetch(
      `http://localhost/AI-Edufy/api/level/delete.php?id=${levelId}`
    );

    const result = await response.json();

    console.log(result);
    loader.remove(deleteBtn, "Delete");

    if (result?.status === 200) {
      toast.success(result.msg);
      setTimeout(() => {
        window.location.reload();
      }, 2000);
    } else {
      toast.error(result.msg);
    }
  });
});

const levelForm = document.querySelector("#level-form");
const submitBtn = document.querySelector("#level-form button");

levelForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(levelForm);
  const data = Object.fromEntries(formData.entries());

  console.log(data);

  if (!data?.level_title || !data?.level_points) {
    return toast.error("Please fill all the fields");
  }

  if (!data?.level_id) {
    // Add Level
    try {
      toast.loading("Adding Level.....");
      const response = await fetch(
        "http://localhost/AI-Edufy/api/level/create.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            level_title: data?.level_title,
            points_required: data?.level_points,
          }),
        }
      );

      const result = await response.json();

      console.log(result);

      if (result?.status === 200) {
        toast.success(result.msg);
        loader.add(submitBtn);
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      } else {
        toast.error(result.msg);
      }
    } catch (error) {
      console.log(error);
      toast.error("Something went wrong");
    }
  }else {

    // Update Level
    try {
      toast.loading("Updating Level.....");
      const response = await fetch(
        "http://localhost/AI-Edufy/api/level/update.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            level_id: data?.level_id,
            level_title: data?.level_title,
            points_required: data?.level_points,
          }),
        }
      );

      const result = await response.json();

      console.log(result);

      if (result?.status === 200) {
        toast.success(result.msg);
        loader.add(submitBtn);
        setTimeout(() => {
          closeModal();
        }, 1000);

      } else {
        toast.error(result.msg);
      }
    } catch (error) {
      console.log(error);
      toast.error("Something went wrong");
    }
  }
});
