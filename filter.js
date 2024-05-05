//to git all couse container
var myTable = document.getElementsByClassName("myTable")[0];

// multidimensional array for designers
const allDesigners = [
  { designer: '', specialty:['',''], linkRequest: '' , inHtml:myTable.children[1].innerHTML},
 
];

// arrays for designers and prerequisites
var designers = [...new Set(allDesigners.map(aDesigner => aDesigner.specialty))];
const linkForRequest = [...new Set(allDesigners.filter(aDesigner => aDesigner.linkRequest !== '').map(aDesigner => aDesigner.linkRequest))];

//// fill in the filter options from the array
//const tutorFilter = document.getElementById('selectTutor');
//designers.forEach(tutor => {
//  const anOption = document.createElement('option');
//  anOption.value = tutor;
//  anOption.textContent = tutor;
//  tutorFilter.appendChild(anOption);
//});

//const prerequisiteFilter = document.getElementById('selectprerequisite');
//prerequisites.forEach(prerequisite => {
//  const option = document.createElement('option');
//  option.value = prerequisite;
//  option.textContent = prerequisite;
//  prerequisiteFilter.appendChild(option);
//});

// function to filter allDesigners 
function filterDesigners() {
  const designerFilter = document.getElementById('DesignCatagory');  
  const selectedCatagory = designerFilter.value;
  
  const filteredDesigners = allDesigners.filter(aDesigner => {
    return (aDesigner.specialty === selectedCatagory);
  });
  
  // add the filtered allDesigners to the table
  myTable.innerHTML = ' <table class="myTable">';
  for (var i=0 ; i<filteredDesigners.length;i++){
    var aRow = filteredDesigners[i].inHtml;
    myTable.innerHTML += aRow ;
  }
  myTable.innerHTML += ' </table>';
  
}