import toast from "../utils/toast.js";
import loader from "../utils/loader.js";

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
