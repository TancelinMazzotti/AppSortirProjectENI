window.onload = loadCampus();

function loadCampus(){

    $.getJSON(ROOL_URL +"api/Campus/ListCampus/", function (data){
        for(var i = 0; i < Object.keys(data.list_Campus).length; i++){
            tableauCampus(data.list_Campus[i]);
        }
    })
}

function tableauCampus(Campus){
    var newTrHtml = '<tr id="' + Campus.id + '" class="campusTable"><td id="camp' + Campus.id + '">' + Campus.nomCampus + '</td><td class="border p-1">' +
        '<a  onclick="modifierCampus(' + Campus.id + ')" class="text-warning" href="#">Modifier</a> - <a  onclick="supprimerCampus(' + Campus.id + ')" class="text-danger" href="#">Supprimer</a></td></tr>';
     document.getElementById("table_campus").innerHTML += newTrHtml;
}
// var newTrHtml = '<tr id="' + ville.id + '"><td>' + ville.nom + '</td><td>' + ville.codePostal + '</td><td class="border p-1">' +
//     '<a href="" onclick="">Modifier</a> - <a onclick="supprimerVille(' + ville.id + ')" href="#">Supprimer</a></td></tr>';
// document.getElementById("table_ville").innerHTML += newTrHtml;


function supprimerCampus(id){
    $.getJSON(ROOL_URL + "api/Campus/Supprimer/"+ id, function (data){
        if (data.id != null){
            document.getElementById(data.id).remove();
        } else {

        }
    })
}

function rechercheCampus() {
var valeurRecherche = document.getElementById("rechercheCampus").value
    document.querySelectorAll('.campusTable').forEach(function(a){
        a.remove()
    })

    $.getJSON(ROOL_URL + "api/Campus/ListCampus/"+valeurRecherche, function (data){
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

        $.getJSON(ROOL_URL + "api/Campus/updateCampus/"+nomCampinput+"/"+ id, function (data){
            if (data.id != null){
                tdNomCamp.removeChild(tdNomCamp.firstChild)
                tdNomCamp.innerText = nomCampinput;
            } else {

            }
        })

    }
}