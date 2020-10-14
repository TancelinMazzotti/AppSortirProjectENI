function onVilleChanged(){

    let selectVille = document.getElementById('select_ville')
    let idVille = selectVille.options[selectVille.selectedIndex].value
    requestLoadLieuxByVille(idVille)
}

function requestLoadLieuxByVille(idVille){
    let url = "http://localhost:8080/ville/" + idVille + "/lieux/"
    let httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = responseLoadLieuxByVille
    httpRequest.open("GET", url, true);
    httpRequest.setRequestHeader("Accept", "application/json");
    httpRequest.send();
}

function responseLoadLieuxByVille(){
    if (this.readyState === 4 && this.status === 200) {
        let lieux = JSON.parse(this.responseText);
        changeOptionSelectLieux(lieux);
    }
}

function changeOptionSelectLieux(lieux){
    let selectLieux = document.getElementById('select_lieux')
    selectLieux.innerHTML = ""

    for (let lieu in lieux){
        let option = document.createElement("option");
        option.value = lieu.id;
        option.text = lieu.nom;
        selectLieux.add(option);
    }
}