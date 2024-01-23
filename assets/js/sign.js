let checker = 1;
let checker2 = 1;
btn_change.addEventListener( "click" , (e) =>{
    e.preventDefault();
    if (checker % 2 != 0){
        pass.type = "text";
        icon_of_view_2.style = "display:none";
        icon_of_view_1.style = "display:block"
    } 
    else {
        pass.type = "password";
        icon_of_view_1.style = "display:none";
        icon_of_view_2.style = "display:block"
    }
    
    checker++;
});


btn_change2.addEventListener( "click" , (e) =>{
    e.preventDefault();
    if (checker2 % 2 != 0){
        pass2.type = "text";
        icon_of_view2_2.style = "display:none";
        icon_of_view2_1.style = "display:block";
    } 
    else {
        pass2.type = "password";
        icon_of_view2_1.style = "display:none";
        icon_of_view2_2.style = "display:block"
    }
    
    checker2++;
});