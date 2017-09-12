// $(window).unload(function(){
// return "Are you sure you want to leave this page.";
// });

// window.onbeforeunload = confirmExit;
// function confirmExit()
// {
//   return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
// }
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