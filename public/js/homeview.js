// Get the current date
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; // January is 0
var yyyy = today.getFullYear();

if (dd < 10) {
  dd = "0" + dd;
}

if (mm < 10) {
  mm = "0" + mm;
}

today = yyyy + "-" + mm + "-" + dd;

// Set minimum and maximum date for departure date input
document.getElementById("depart-date").setAttribute("min", today);
document.getElementById("depart-date").setAttribute("max", addDays(today, 10));

// Function to add days to a date
function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  var dd = result.getDate();
  var mm = result.getMonth() + 1; // January is 0
  var yyyy = result.getFullYear();

  if (dd < 10) {
    dd = "0" + dd;
  }

  if (mm < 10) {
    mm = "0" + mm;
  }

  return yyyy + "-" + mm + "-" + dd;
}

// Validate origin and destination
document.getElementById("origin").addEventListener("change", function () {
  var destination = document.getElementById("destination").value;
  if (this.value === destination) {
    alert("Origin and destination cannot be the same.");
    this.value = "";
  }
});

document.getElementById("destination").addEventListener("change", function () {
  var origin = document.getElementById("origin").value;
  if (this.value === origin) {
    alert("Origin and destination cannot be the same.");
    this.value = "";
  }
});

// Get all navigation links
