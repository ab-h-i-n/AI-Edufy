

// to listen to on change event of the code editor
window.onmessage = function (e) {
  if (e.data && e.data.language) {
    console.log(e.data);
    // handle the e.data which contains the code object
  }
};

// to run the code
// var iFrame = document.getElementById('oc-editor');
// iFrame.contentWindow.postMessage({
//     eventType: 'triggerRun'
// }, "*");

