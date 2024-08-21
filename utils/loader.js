class Loader {
  div = document.createElement("div");

  add(parent) {
    this.div.classList.add("loader");
    parent.innerHTML = "";
    parent.append(this.div);
  }

  remove(parent) {
    parent.remove(this.div);
  }
}

const loader = new Loader();

export default loader;