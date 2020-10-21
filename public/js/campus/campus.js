window.onload = loadCampus();

function loadCampus(){

    $.getJSON(ROOL_URL +"api/campus/ListCampus/", function (data){
        for(var i = 0; i < Object.keys(data.list_Campus).length; i++){
            tableauCampus(data.list_Campus[i]);
        }
        tableauLigneAjout();
    })
}

function tableauCampus(Campus){
    var newTrHtml = '<tr id="' + Campus.id + '" class="campusTable"><td id="camp' + Campus.id + '">' + Campus.nomCampus + '</td><td class="border p-1">' +
        '<a  onclick="modifierCampus(' + Campus.id + ')" class="text-warning" href="#">Modifier</a> - <a  onclick="supprimerCampus(' + Campus.id + ')" class="text-danger" href="#">Supprimer</a></td></tr>';

    if (document.getElementById("ajout_campus") === null){
        document.getElementById("table_campus").innerHTML += newTrHtml;
    }
    else{
        document.getElementById("ajout_campus").insertAdjacentHTML('beforebegin',newTrHtml)
    }
}

function supprimerCampus(id){
    $.getJSON(ROOL_URL + "api/campus/Supprimer/"+ id, function (data){
        if (data.id != null){
            document.getElementById(data.id).remove();
        } else {

        }
    })
}

function tableauLigneAjout(){
    var trAjoutHtml = '<tr id="ajout_campus"><td class="border p-1" id="nom"><input id="inp_nom" type="text"></td>' +
        '<td class="border p-1"><a class="text-success" onclick="ajouterCampus(document.getElementById(\'ajout_campus\').children.namedItem(\'nom\').children.namedItem(\'inp_nom\'))" href="#">Ajouter</a></td></tr>';
    document.getElementById("table_campus").innerHTML += trAjoutHtml;
}


function rechercheCampus() {
var valeurRecherche = document.getElementById("rechercheCampus").value
    document.querySelectorAll('.campusTable').forEach(function(a){
        a.remove()
    })

    $.getJSON(ROOL_URL + "api/campus/ListCampus/"+valeurRecherche, function (data){
        for(var i = 0; i < Object.keys(data.list_Campus).length; i++){
            tableauCampus(data.list_Campus[i]);
        }
    })
}

function modifierCampus(id){

var tdNomCamp = document.getElementById("camp"+id)

    if( tdNomCamp.getElementsByTagName("INPUT").length ===0 ){
        var nomCamp = document.getElementById("camp"+id).innerHTML

        var input = document.createElement("INPUT");
        input.setAttribute("id", "inputCamp"+id);

        input.value = nomCamp
        tdNomCamp.innerHTML = null
        tdNomCamp.appendChild(input)
    }
 else {
        var nomCampinput = document.getElementById("inputCamp" + id).value

        $.getJSON(ROOL_URL + "api/campus/updateCampus/"+nomCampinput+"/"+ id, function (data){
            if (data.id != null){
                tdNomCamp.removeChild(tdNomCamp.firstChild)
                tdNomCamp.innerText = nomCampinput;
            } else {

            }
        })

    }
}

function ajouterCampus(nom){

    console.log(nom);

}