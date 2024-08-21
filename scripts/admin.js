import toast from '../utils/toaster.js';
import loader from '../utils/loader.js';

const deleteBtns = document.querySelectorAll(".del-user");

deleteBtns.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", async() => {

    toast.loading("Deleting.....");
    const userId = deleteBtn.id;
    loader.add(deleteBtn);
    

  });
});
