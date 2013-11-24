$(window).ready(function(){
    $(".cropped").each(function(){
        if (this.width > this.height){
            $(this).height(100);
        }
        else{
            $(this).width(100);
        }
    });
});
