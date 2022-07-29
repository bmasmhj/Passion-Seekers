const validationInputs = document.querySelectorAll('.validation__input');

validationInputs.forEach((e)=>{
   e.addEventListener('blur',()=>{
      hasClassInputEmpty = e.classList.contains('validation__input--empty');
      console.log(hasClassInputEmpty);

      if(e.value == ''){
         e.classList.add('validation__input--empty');
      }else{
         e.classList.remove('validation__input--empty');
      }
      
   })
})