let range = document.getElementById("range");

let rangeMaxValue = Number(range.getAttribute('max'));
let rangeMinValue = Number(range.getAttribute('min'));
let rangeCurrentValue = Number(range.getAttribute('value'));

let slide = document.querySelector('.active');

let skrolPhoto = document.querySelector('.skrol-photo');

skrolPhoto.addEventListener('wheel', (e) => {
   let activeSlide = document.querySelector('.active');
   if(e.deltaY >= 0) {
      if(rangeCurrentValue < rangeMaxValue) {
         rangeCurrentValue += 1;
      }
	   console.log(rangeCurrentValue);
   } else {
      if(rangeCurrentValue > rangeMinValue) {
         rangeCurrentValue -= 1;
      }
      console.log(rangeCurrentValue);
   }
   range.value = rangeCurrentValue;
   console.log(range.value);

   activeSlide.classList.remove("active");

   activeSlide = document.querySelector(`[data-slide="${String(range.value)}"]`);
   activeSlide.classList.add("active");


   e.preventDefault();
});


range.oninput = function(){
   let activeSlide = document.querySelector('.active');
   activeSlide.classList.remove("active");
   activeSlide = document.querySelector(`[data-slide="${String(range.value)}"]`);
   activeSlide.classList.add("active");
   rangeCurrentValue = range.value;
}