const toaster = document.querySelector(".toast");
const msg = document.querySelector(".toast .msg");
const icon = document.querySelector(".toast .icon");


class Toast {
  success(message) {
    this.showToast(message, "✅");
  }

  error(message) {
    this.showToast(message, "❌");
  }

  warning(message) {
    this.showToast(message, "⚠️");
  }

  loading(message) {
    this.showToast(message || "loading..", "⏳", false);
  }

  hint(message) {
    msg.innerText = message;
    icon.innerText = "💡";
    toaster.classList.add("active");
    toaster.classList.remove("fade-out");
    setTimeout(() => {
      this.dismiss();
    }, 15000);
  }

  dismiss() {
    toaster.classList.add("fade-out");
    setTimeout(() => {
      toaster.classList.remove("active", "fade-out");
    }, 500);
  }

  showToast(message, iconText, hasTimeout = true) {
    msg.innerText = message;
    icon.innerText = iconText;
    toaster.classList.add("active");
    toaster.classList.remove("fade-out");

    if (hasTimeout) {
      setTimeout(() => {
        this.dismiss();
      }, 3000);
    }
  }
}

const toast = new Toast();

export default toast;
