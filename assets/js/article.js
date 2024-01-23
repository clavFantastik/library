let vary = (vari.value);
let movy = movi.innerHTML;
let content = vary.split(';');
let m = movy.split(';');

if (vary == 'rer'){
    let foo = '';
}else{
    for (let i = 0; i < content.length; i++){
    
    let btn = document.createElement('button');
    btn.style = "background-color: white;color:black;border:2px solid #80dbca;margin-right:20px; border-radius:10px; padding:10px;transition:0.5s";

    btn.addEventListener("click", ()=>{
        rov.value = i
    })

    btn.addEventListener("mouseover", ()=>{
        btn.style = "background-color: #80dbca;color:white;border:2px solid #80dbca;margin-right:20px; border-radius:10px; padding:10px; transition:0.5s";
    })

    btn.addEventListener("mouseout", ()=>{
        btn.style = "background-color: white;color:black;border:2px solid #80dbca;margin-right:20px; border-radius:10px; padding:10px;transition:0.5s";
    })

    btn.innerHTML = "<p>" + content[i] + "</p><b>{ " + m[i].trim() + " }</b>";
    content_of_var.append(btn);
}

}

