function onVilleChanged(){

    let selectVille = document.getElementById('select_ville')
    let idVille = selectVille.options[selectVille.selectedIndex].value
    requestLoadLieuxByVille(idVille)
}

function requestLoadLieuxByVille(idVille){
    let url = ROOL_URL + "api/ville/" + idVille + "/lieux"
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
    let selectLieux = document.getElementById('sortie_lieux')
    selectLieux.innerHTML = ""

    for (let lieu of lieux){
        let option = document.createElement("option");
        option.value = lieu.id;
        option.text = lieu.nom;
        selectLieux.add(option);
    }
    onLieuxChanged()
}

function onLieuxChanged(){

    let selectLieux = document.getElementById('sortie_lieux')
    if (selectLieux.options[selectLieux.selectedIndex])
    {
        let idLieu = selectLieux.options[selectLieux.selectedIndex].value
        requestLoadLieu(idLieu)
    }
    else changeLieu(null)

}

function requestLoadLieu(idLieu){
    let url = ROOL_URL + "api/lieu/" + idLieu
    let httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = responseLoadLieu
    httpRequest.open("GET", url, true);
    httpRequest.setRequestHeader("Accept", "application/json");
    httpRequest.send();
}

function responseLoadLieu(){
    if (this.readyState === 4 && this.status === 200) {
        let lieu = JSON.parse(this.responseText);
        changeLieu(lieu);
    }
}

function changeLieu(lieu){
    let rue = document.getElementById('rue')
    let elementCodePostal = document.getElementById('codepostal')
    let latitude = document.getElementById('latitude')
    let longitude = document.getElementById('longitude')
    console.log(elementCodePostal)
    console.log(lieu)

    if(lieu != null) {
        rue.innerHTML = lieu.rue
        elementCodePostal = lieu.codePostal
        latitude.innerHTML = lieu.latitude
        longitude.innerHTML = lieu.longitude
    }
    else {
        rue.innerHTML = ''
        elementCodePostal = ''
        latitude.innerHTML = ''
        longitude.innerHTML = ''
    }
}

onVilleChanged()

function onOpenModal(){
    let modal = document.getElementById('myModal')
    modal.setAttribute('style', 'display: flex');
}

function onCloseModal(){
    let modal = document.getElementById('myModal')
    modal.setAttribute('style', 'display: none');
}