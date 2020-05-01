function getResults() {
    let searchValue = this.value;
    if(searchValue.length >= 3){
        console.log("Send ajax request.");
    }
    
}

window.onload = function(){
    var searchField = document.querySelector('#search');
    searchField.addEventListener("keyup",getResults);
}
