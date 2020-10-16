window.onload = loadVille();

function loadVille(){
    $.getJSON(ROOL_URL + "api/Ville/ListVille", function (data){
        for(var i = 0; i < Object.keys(data.list_ville).length; i++){
            tableauVille(data.list_ville[i]);
        }
        tableauLigneAjout();
    })
}

function tableauVille(ville){
    var newTrHtml = '<tr id="' + ville.id + '"><td class="border p-1" id="nom">' + ville.nom + '</td><td class="border p-1" id="cp">' + ville.codePostal + '</td>' +
        '<td class="border p-1"><a href="" onclick="">Modifier</a> - <a onclick="supprimerVille(' + ville.id + ')" href="#">Supprimer</a></td></tr>';
    document.getElementById("table_ville").innerHTML += newTrHtml;
}

function tableauLigneAjout(){
    var trAjoutHtml = '<tr id="ajout_ville"><td class="border p-1" id="nom"><input id="inp_nom" type="text"></td>' +
        '<td class="border p-1" id="cp"><input id="inp_cp" type="text"></td>' +
        '<td class="border p-1"><a onclick="ajouterVille(document.getElementById(\'ajout_ville\').children.namedItem(\'nom\').children.namedItem(\'inp_nom\'),' +
        'document.getElementById(\'ajout_ville\').children.namedItem(\'cp\').children.namedItem(\'inp_cp\'))" href="#">Ajouter</a></td></tr>';
    document.getElementById("table_ville").innerHTML += trAjoutHtml;
}

function supprimerVille(id){
    $.getJSON(ROOL_URL + "api/Ville/Supprimer/"+ id, function (data){
        if (data.id != null){
            document.getElementById(data.id).remove();
        } else {

        }
    })
}

function modifierVille(id, nom, cp){

}

function ajouterVille(nom, cp){

    console.log(nom,cp);

}