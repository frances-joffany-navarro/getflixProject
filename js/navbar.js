let searchInput = myInput.value.toUpperCase().trim();
window.onload = function (){
    let li = myTable.getElementsByTagName("li");
    for (let i = 0; i < li.length; i++) {
        // define the figcaption elements inside the list tags
        let figcaption = li[i].getElementsByTagName("figcaption");
        // hide the list items
        li[i].style.display = "none";
        // loop through figcaption tags at index "j"
        for (let j = 0; j < figcaption.length; j++) {
          // if there's a match
          if (figcaption[j].innerHTML.toUpperCase().indexOf(searchInput) > -1) {
            // show the whole list element
            li[i].style.display = "";
            // skip to the next list element
            // continue;
          }
        }
      }
}