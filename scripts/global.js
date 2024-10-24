const modal = document.querySelector(".modal");
const modalCloseBtn = document.querySelector(".modal-close");
const modalOpenBtn = document.querySelector(".modal-open");

export function closeModal() {
  modal.classList.add("closed");
  document.querySelector("body").style.overflowY = "auto";

  const url = new URL(window.location.href);
  const searchParams = new URLSearchParams(url.search);

  if (searchParams.has("update")) {
    searchParams.delete("update");
    url.search = searchParams.toString();
    window.location.href = url.href;
  }
}

modalCloseBtn.addEventListener("click", closeModal);

modalOpenBtn.addEventListener("click", () => {
  modal.classList.remove("closed");
  document.querySelector("body").style.overflowY = "hidden";
});
