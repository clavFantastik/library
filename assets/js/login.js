let checker = 1;
btn_change.addEventListener( "click" , (e) =>{
    e.preventDefault();
    if (checker % 2 != 0){
        icon_of_view_2.style = "display:none";
        pass.type = "text";
        icon_of_view_1.style = "display:block";
    } 
    else {
        pass.type = "password";
        icon_of_view_1.style = "display:none";
        icon_of_view_2.style = "display:block";
    }
    
    checker++;
});