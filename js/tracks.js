var counter = 1; // initializing the counter
var limit = 25; // setting limit for the counter
function addInput(pName){
if (counter == limit)  {
    alert("You have reached the limit of adding " + counter + " inputs");
}
else {
    var newP = document.createElement('p');
    newP.innerHTML = "Track " + (counter + 1) + " <br><input type='text' class='trackInput' name='trackName[]'>";
    document.getElementById(pName).appendChild(newP);
    counter++;
      }
}
// targeting the add tracks element
var trckadd = document.getElementById('tracks');
trckadd.style.display = 'block';
var newTracks = document.getElementById('addTracks');
newTracks.onclick = function () {
    var dynamic = document.getElementById('dynamicInput');
    var sel = newTracks.checked;
    dynamic.parentNode.style.display = sel ? 'block' : 'none';
}
