// // const addCampusBtn = document.getElementById("add_campus");
// //
// // //pour le mettre sous écoute du clic
// // //au clic, déclencher la requête ajax
// // addCampusBtn.addEventListener("click", addCampus);
// //
// // function addCampus(event) {
// //     let catId = event.currentTarget.dataset.catId;
// //     let url = event.currentTarget.dataset.ajaxUrl;
// //     axios.post(url, {
// //         id: catId
// //     })
// //         .then(function (response) {
// //             console.log(response);
// //         });
// // }


window.onload = loadCampus();

function loadCampus(){

    $.getJSON(ROOL_URL +"api/Campus/apiListCampus/", function (data){
        for(var i = 0; i < Object.keys(data.list_Campus).length; i++){
            tableauCampus(data.list_Campus[i]);
        }
    })
}

function tableauCampus(Campus){
    var newTrHtml = '<tr class="campusTable"><td>' + Campus.nomCampus + '</td><td class="border p-1">' +
        '<a href="" onclick="">Modifier</a> - <a href="" onclick="supprimerCampus(' + Campus.id + ')">Supprimer</a></td></tr>';
     document.getElementById("table_campus").innerHTML += newTrHtml;
}

function creerXHR() {
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else {
        // Merci IE
        xhr = new ActiveXObject("Msxml12.XMLHTTP");
    }
    return xhr;
}

function supprimerCampus(id){
    xhr = creerXHR();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById(xhr.responseText).remove();
        }
    }
    xhr.open("GET", ROOL_URL + "api/Campus/Supprimer/"+ id, true);
    xhr.send();
}

function rechercheCampus() {
var valeurRecherche = document.getElementById("rechercheCampus").value
    document.querySelectorAll('.campusTable').forEach(function(a){
        a.remove()
    })

    $.getJSON(ROOL_URL + "api/Campus/apiListCampus/"+valeurRecherche, function (data){
        for(var i = 0; i < Object.keys(data.list_Campus).length; i++){
            tableauCampus(data.list_Campus[i]);
        }
    })
}