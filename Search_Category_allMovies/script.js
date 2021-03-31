document.getElementById("myInput").addEventListener("keyup", () => {
  //variables
  let input = document.getElementById("myInput");
  let filter = input.value.toUpperCase();
  let table = document.getElementById("myTable");
  let tr = table.getElementsByTagName("tr");
  document.body.style.backgroundColor = "#1F1C18";
  document.body.style.color = "black";

// Loop through all table rows, and hide those who don't match the search query
// Loop through first tbody's rows
  for (let i = 0; i < tr.length; i++) {
    // define the row's cells
    let td = tr[i].getElementsByTagName("td");
    // hide the row
    tr[i].style.display = "none";
    // loop through row cells
    for (let j = 0; j < td.length; j++) {
      // if there's a match
      if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        // show the row
        tr[i].style.display = "";
        // skip to the next row
        continue;
      }
    }
  }
})