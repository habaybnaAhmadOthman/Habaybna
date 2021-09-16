$('.list').each(function(index){
    var topli = $(this).children(":first-child");
    topli.click(function(){
        var parent = $(this).parent();
        var sublis = parent.find(".sub");

        if(sublis.is(':visible')){

            sublis.slideUp();
            topli.find('i').removeClass('rotatedown');

        }else{
            sublis.slideDown();

            topli.find('i').addClass('rotatedown');

        }
    })

});



