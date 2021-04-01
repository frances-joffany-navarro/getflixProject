document.getElementById("myInput").addEventListener("keyup", () => {
  //variables
  let input = document.getElementById("myInput");
  let filter = input.value.toUpperCase();
  let table = document.getElementById("myTable");
  let li = table.getElementsByTagName("li");
  document.body.style.backgroundColor = "#1F1C18";
  document.body.style.color = "black";

// Loop through all table rows, and hide those who don't match the search query
// Loop through first tbody's rows
  for (let i = 0; i < li.length; i++) {
    // define the row's cells
    let figcaption = li[i].getElementsByTagName("figcaption");
    // hide the row
    li[i].style.display = "none";
    // loop through row cells
    for (let j = 0; j < figcaption.length; j++) {
      // if there's a match
      if (figcaption[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        // show the row
        li[i].style.display = "";
        // skip to the next row
        continue;
      }
    }
  }
})