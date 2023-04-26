jQuery(document).ready(function( $ ) {

    let element = $('input[type="range"]').rangeslider({
        polyfill: false,
    });

    element.on('input', function() {
        // console.log(this.value);
        // console.log($(this).parent().parent().find(".active"));
        let activeSlide = $(this).parent().parent().find(".active").hide().removeClass("active");
        $(this).parent().parent().find(`[data-slide="${this.value}"]`).show().addClass("active");
    })

    $('.skrollslider__slides').on('mousewheel', function (e){
       e.preventDefault();
       let range = $(this).parent().find(".range");
       let rangeMaxValue = Number(range.attr('max'));
       let rangeMinValue = Number(range.attr('min'));

       let rangeValue = range.val();

        if(e.originalEvent.wheelDelta / 120 > 0) {
            if (Number(rangeValue) < rangeMaxValue) {
                rangeValue = Number(rangeValue) + 1;
            }
            // console.log('scrolling up !');
        } else{
            // console.log('scrolling down !');
            if (Number(rangeValue) > rangeMinValue) {
                rangeValue = Number(rangeValue) - 1;
            }
        }

        let activeSlide = $(this).find('.active');
        activeSlide.hide().removeClass("active");
        $(this).find(`[data-slide="${rangeValue}"]`).show().addClass("active");

        range.val(rangeValue).change();
    })
    //Всплывающие картинки
    $('.skrollslider__slides')
        .rebox({ selector: 'a' });

});