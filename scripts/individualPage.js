// make the input field visible
const displayInputFieldBtn = document.querySelector('.search__form__btn');
const inputFieldToBeShown = document.querySelector('.search__form__field');

let visibleInputField = false;

displayInputFieldBtn.addEventListener('click', changeVisiblility);

inputFieldToBeShown.addEventListener('blur', () => {
   inputFieldToBeShown.classList.remove('search__form__field--display');
   displayInputFieldBtn.setAttribute('type', 'button');
   visibleInputField = false;
})

function changeVisiblility(e) {
   visibleInputField = !visibleInputField;
   if (visibleInputField) {
      inputFieldToBeShown.classList.add('search__form__field--display');
      inputFieldToBeShown.focus();
      setTimeout(() => { displayInputFieldBtn.setAttribute('type', 'submit') }, 100);
   } else {
      inputFieldToBeShown.classList.remove('search__form__field--display');
   }
}

const asideContainer = document.querySelectorAll('.aside__recomendation');

asideContainer.forEach((e) => {
   e.addEventListener('mouseover', () => {
      e.classList.add('aside__recomendation--recent__post');
      console.log('over');
   })
   e.addEventListener('mouseout', () => {
      e.classList.remove('aside__recomendation--recent__post');
      console.log('out');
   })
})

const commentCollection = document.querySelectorAll('.post__comment__remove__comment');

commentCollection.forEach((e) => {
   e.parentElement.addEventListener('mouseover', () => {
      e.classList.add('post__comment__remove__comment--visible');
   })
   e.parentElement.addEventListener('mouseout', () => {
      e.classList.remove('post__comment__remove__comment--visible');
   })

})