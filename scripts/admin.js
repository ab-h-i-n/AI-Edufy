import toast from '../utils/toaster.js';
import loader from '../utils/loader.js';

const deleteBtns = document.querySelectorAll(".del-user");

deleteBtns.forEach((deleteBtn) => {
  deleteBtn.addEventListener("click", async() => {

    toast.loading("Deleting.....");
    const userId = deleteBtn.id;
    loader.add(deleteBtn);
    

    const response = await fetch(`http://localhost/AI-Edufy/api/user/delete.php?userid=${userId}`);

    const result = await response.json();

    console.log(result);
    
  });
});
