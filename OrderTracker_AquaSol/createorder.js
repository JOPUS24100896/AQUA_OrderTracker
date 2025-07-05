var p1 = document.getElementById("p1");
var p1add = document.getElementById("p1+");
var p1min = document.getElementById("p1-");
var p1val = document.getElementById("p1val");
var p2 = document.getElementById("p2");
var p2add = document.getElementById("p2+");
var p2min = document.getElementById("p2-");
var p2val = document.getElementById("p2val");
p1add.disabled=true;
p1min.disabled=true;
p1val.disabled=true;
p2add.disabled=true;
p2min.disabled=true;
p2val.disabled=true;


p1.addEventListener("change", function(){
    if(p1.checked){
        p1add.disabled=false;
        p1min.disabled=false;
        p1val.disabled=false;
        p1val.value = 1;
    }else{
        p1add.disabled=true;
        p1min.disabled=true;
        p1val.disabled=true;
    }
})

p1val.addEventListener("keydown", function(event){
    if(isNaN(parseInt(event.key)) && event.key != "Backspace") event.preventDefault();
})

p1val.addEventListener("change", function(){
    if(p1val.value == 0) p1val.value = 1;
})

p1min.addEventListener("click", function(){
    if(p1val.value - 1 > 0) p1val.value -= 1;
    else p1val.value = 1;
    
})

p1add.addEventListener("click", function(){
    p1val.value = parseInt(p1val.value) + 1;
})

p2.addEventListener("change", function(){
    if(p2.checked){
        p2add.disabled=false;
        p2min.disabled=false;
        p2val.disabled=false;
        p2val.value = 1;
    }else{
        p2add.disabled=true;
        p2min.disabled=true;
        p2val.disabled=true;
    }
})


p2val.addEventListener("keydown", function(event){
    if(isNaN(parseInt(event.key)) && event.key != "Backspace") event.preventDefault();
})

p2val.addEventListener("change", function(){
    if(p2val.value == 0) p2val.value = 1;
})

p2min.addEventListener("click", function(){
    if(p2val.value - 1 > 0) p2val.value -= 1;
    else p2val.value = 1;
    
})

p2add.addEventListener("click", function(){
    p2val.value = parseInt(p2val.value) + 1;
})




