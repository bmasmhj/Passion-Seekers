//for corousel 
let slideIndex = 1;
let slides = document.getElementsByClassName("slides");

showSlides(slideIndex);

// function plusSlides(n) {
//    showSlides(slideIndex += n);
// }

function currentSlide(n) {
   showSlides(slideIndex = n);
}


function showSlides(n) {
   // console.log(slideIndex);   
   let i;
   let dots = document.getElementsByClassName("dot");
   // if (n > slides.length) { slideIndex = 1 }
   // if (n < 1) { slideIndex = slides.length }
   for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
   }
   for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
   }
   slides[slideIndex - 1].style.display = "block";
   dots[slideIndex - 1].className += " active";
}

setInterval(() => {
   if (slideIndex > slides.length) {
      slideIndex = 1;
   } else {
      slideIndex;
   }
   currentSlide(slideIndex);
   slideIndex++;
}, 5000)

// make the input field visible
// const displayInputFieldBtn = document.querySelector('.search__form__btn');
// const inputFieldToBeShown = document.querySelector('.search__form__field');

// let visibleInputField = false;

// displayInputFieldBtn.addEventListener('click', changeVisiblility);

// inputFieldToBeShown.addEventListener('blur', () => {
//    inputFieldToBeShown.classList.remove('search__form__field--display');
//    displayInputFieldBtn.setAttribute('type', 'button');
//    visibleInputField = false;
// })

// function changeVisiblility(e) {
//    visibleInputField = !visibleInputField;
//    if (visibleInputField) {
//       inputFieldToBeShown.classList.add('search__form__field--display');
//       inputFieldToBeShown.focus();
//       setTimeout(() => { displayInputFieldBtn.setAttribute('type', 'submit') }, 100);
//    } else {
//       inputFieldToBeShown.classList.remove('search__form__field--display');
//    }
// }