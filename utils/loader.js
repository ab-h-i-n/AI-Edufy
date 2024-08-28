class Loader {
  div = document.createElement("div");

  add(parent) {
    this.div.classList.add("loader");
    parent.innerHTML = "";
    parent.append(this.div);
  }

  remove(parent , defaultInnerHtml) {
    parent.remove(this.div);
    parent.innerHTML = defaultChild;
  }
}

const loader = new Loader();

export default loader;