window.onload = loadVille();

function loadVille(){
    $.getJSON(ROOL_URL + "Ville/apiListVille", function (data){
        for(var i = 0; i < Object.keys(data.list_ville).length; i++){
            tableauVille(data.list_ville[i]);
        }
        //tableauLigneAjout()
    })
}

function tableauVille(ville){
    var newTrHtml = '<tr id="' + ville.id + '"><td>' + ville.nom + '</td><td>' + ville.codePostal + '</td><td class="border p-1">' +
        '<a href="" onclick="">Modifier</a> - <a onclick="supprimerVille(' + ville.id + ')" href="#">Supprimer</a></td></tr>';
    document.getElementById("table_ville").innerHTML += newTrHtml;
}

function tableauLigneAjout(){
    var trAjoutHtml = '<tr id="ajoutVille"><td></td><td></td><td><a onclick="ajouterVille()" href="#"></a></td></tr>';
    document.getElementById("table_ville").innerHTML += trAjoutHtml;
}

function supprimerVille(id){
    $.getJSON(ROOL_URL + "Ville/Supprimer/"+ id, function (data){
        if (data.id != null){
            document.getElementById(data.id).remove();
        } else {

        }
    })
}

function modifierVille(id, nom, cp){

}

function ajouterVille(nom, cp){

}