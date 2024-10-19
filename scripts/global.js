const modal = document.querySelector(".modal");
const modalCloseBtn = document.querySelector(".modal-close");
const modalOpenBtn = document.querySelector(".modal-open");

export function closeModal() {
  modal.classList.add("closed");
  document.querySelector("body").style.overflowY = "auto";

  if (window.location.search.includes("update")) {
    window.location.href = "http://localhost/AI-Edufy/home";
  }
}

modalCloseBtn.addEventListener("click", closeModal);

modalOpenBtn.addEventListener("click", () => {
  modal.classList.remove("closed");
  document.querySelector("body").style.overflowY = "hidden";
});
