const filterButton = document.getElementById("dropButton");
const filterStat = document.getElementById("dropdownStat");
filterStat.style.display="none"
function updateFilterInput(key){
    switch(key){
        case 0:
        case 1:
        case 2:
            filterButton.style.display="default";
            filterStat.style.display="none";
        break;
        case 3:
            filterButton.style.display="none";
            filterStat.style.display="default";
        break;
    }
}