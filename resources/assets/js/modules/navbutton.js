// Template js
$(document).ready(function(){

    function navButton(button, tohide, toshow, ele=null, text=null){
        $(button).on('click', function(){
            if($(tohide).hasClass('show')){
                $(tohide).removeClass('show');
                $(tohide).addClass('hide');
                $(ele).text(text);
            }
            $(toshow).removeClass('hide');
            $(toshow).addClass('show');
        });
        
    }

    // Hide the Customer Table & Show the Customer Form
    navButton('#nav_add', '#table', '#form');
    // Hide the Customer Form & Show the Customer Table
    navButton('#nav_view', '#form', '#table');

});