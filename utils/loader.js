class Loader {
  div = document.createElement("div");

  add(parent) {
    this.div.classList.add("loader");
    parent.disabled = true;
    parent.style.pointerEvents = "none";
    parent.innerHTML = "";  
    parent.append(this.div); 
  }

  remove(parent, defaultInnerHtml) {
    this.div.remove(); 
    parent.innerHTML = defaultInnerHtml; 
  }
}


export default new Loader();