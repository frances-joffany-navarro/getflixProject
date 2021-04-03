//the filter will begin proceeding once whe type on any key of the keyboard and the following script will begin performing
document.getElementById("myInput").addEventListener("keyup", () => {
  //first declare variables
  let input = document.getElementById("myInput");
  let filter = input.value.toUpperCase().trim();
  let table = document.getElementById("myTable");
  let li = table.getElementsByTagName("li");


// Loop through all list items, and hide those who don't match the search query

// Loop through the list items
  for (let i = 0; i < li.length; i++) {
    // define the figcaption elements inside the list tags
    let figcaption = li[i].getElementsByTagName("figcaption");
    // hide the list items
    li[i].style.display = "none";
    // loop through figcaption tags at index "j"
    for (let j = 0; j < figcaption.length; j++) {
      // if there's a match
      if (figcaption[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        // show the whole list element 
        li[i].style.display = "";
        // skip to the next list element
        continue;
      }
    }
  }
})