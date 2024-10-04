class Loader {
  div = document.createElement("div");

  add(parent) {
    this.div.classList.add("loader");
    parent.innerHTML = "";  
    parent.append(this.div); 
  }

  remove(parent, defaultInnerHtml) {
    this.div.remove(); 
    parent.innerHTML = defaultInnerHtml; 
  }
}


export default new Loader();