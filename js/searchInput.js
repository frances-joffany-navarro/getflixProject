document.getElementById('button-addon2').addEventListener('click', ()=>{
    let userInput  = document.getElementById("myInput").value;
    window.location = "index.php?search="+userInput;
})

let input = document.getElementById("myInput").addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("button-addon2").click();
    }
});

if(myInput.value !== ""){
let filterText = document.getElementById('myInput').value,
    lis = document.querySelectorAll('figcaption'),
    x;

for (x = 0; x < lis.length; x++) {
    if (filterText === '' || lis[x].innerHTML.indexOf(filterText) > -1) {
        lis[x].removeAttribute('hidden');
    }
    else {
        lis[x].setAttribute('hidden', true);
    }
}
}