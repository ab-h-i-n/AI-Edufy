const modal = document.querySelector(".modal");
const modalCloseBtn = document.querySelector(".modal-close");
const modalOpenBtn = document.querySelector(".modal-open");

modalCloseBtn.addEventListener("click", () => {
  modal.classList.add("closed");
  document.querySelector("body").style.overflowY = "auto";
});

modalOpenBtn.addEventListener("click", () => {
  modal.classList.remove("closed");
  document.querySelector("body").style.overflowY = "hidden";
});
