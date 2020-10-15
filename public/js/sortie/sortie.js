function onVilleChanged(){

    let selectVille = document.getElementById('select_ville')
    let idVille = selectVille.options[selectVille.selectedIndex].value
    requestLoadLieuxByVille(idVille)
}

function requestLoadLieuxByVille(idVille){
    let url = "http://localhost:8000/api/ville/" + idVille + "/lieux/"
    let httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = responseLoadLieuxByVille
    httpRequest.open("GET", url, true);
    httpRequest.setRequestHeader("Accept", "application/json");
    httpRequest.send();
}

function responseLoadLieuxByVille(){
    if (this.readyState === 4 && this.status === 200) {
        console.log("success")
        let lieux = JSON.parse(this.responseText);
        console.log(lieux)
        changeOptionSelectLieux(lieux);
    }
}

function changeOptionSelectLieux(lieux){
    let selectLieux = document.getElementById('sortie_lieux')
    selectLieux.innerHTML = ""

    for (let lieu of lieux){
        let option = document.createElement("option");
        console.log(lieu)
        option.value = lieu.id;
        option.text = lieu.nom;
        selectLieux.add(option);
    }
}

function onLieuxChanged(){

    let selectLieux = document.getElementById('sortie_lieux')
    let idLieu = selectLieux.options[selectLieux.selectedIndex].value
    requestLoadLieu(idLieu)
}

function requestLoadLieu(idLieu){
    let url = "http://localhost:8000/api/lieux/" + idLieu
    let httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = responseLoadLieu
    httpRequest.open("GET", url, true);
    httpRequest.setRequestHeader("Accept", "application/json");
    httpRequest.send();
}

function responseLoadLieu(){
    if (this.readyState === 4 && this.status === 200) {
        console.log("success")
        let lieu = JSON.parse(this.responseText);
        console.log(lieu)
        changeLieu(lieu);
    }
}

function changeLieu(lieu){
    let pRue = document.getElementById('p_rue')
    let pCodePostal = document.getElementById('p_code_postal')
    let pLatitude = document.getElementById('p_latitude')
    let pLongitude = document.getElementById('p_longitude')
}

onVilleChanged()