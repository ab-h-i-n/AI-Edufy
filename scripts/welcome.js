const wordContainer = document.querySelector(".home-section .title span");
const words = ["POTENTIAL" , "SKILL" , "POWER" , "TALENT" , "ABILITY" , "EXPERTISE"];

var wordIndex = 0;
var charIndex = 0;
var isDeleting = false;

const typeEffect = () => {

    const currentWord = words[wordIndex];
    const currentChar = currentWord.substring(0,charIndex);
    wordContainer.innerText = currentChar;

    if (!isDeleting && charIndex < currentWord.length){

        charIndex++;
        setTimeout(typeEffect,150)

    }else if (isDeleting && charIndex > 0 ){

        charIndex--;
        setTimeout(typeEffect,70)

    }else {
        isDeleting = !isDeleting;
        wordIndex = !isDeleting ? ( wordIndex + 1) % words.length : wordIndex;
        setTimeout(typeEffect , 1000)
    }
}

typeEffect();
