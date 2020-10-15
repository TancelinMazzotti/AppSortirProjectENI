window.onload = loadVille();

function loadVille(){
    $.getJSON(ROOL_URL + "Ville/apiListVille", function (data){
        for(var i = 0; i < Object.keys(data.list_ville).length; i++){
            tableauVille(data.list_ville[i]);
        }
    })
}

function tableauVille(ville){
    var newTrHtml = '<tr><td>' + ville.nom + '</td><td>' + ville.codePostal + '</td><td class="border p-1">' +
        '<a href="" onclick="">Modifier</a> - <a href="" onclick="supprimerVille(' + ville.id + ')">Supprimer</a></td></tr>';
    document.getElementById("table_ville").innerHTML += newTrHtml;
}

async function supprimerVille(id){
    /*xhr = creerXHR();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.response);
            //document.getElementById(xhr.responseText).remove();
        }
    }
    xhr.open("GET", "http://localhost/AppSortirProjectENI/public/Ville/Supprimer/"+ id, true);
    xhr.send();*/
    let response = await fetch(ROOL_URL + 'Ville/Supprimer/'+ id)
    console.log(response);
    if(response.status === 200){
        let data = await response.text();
        console.log(data);
    }
}

function modifierVille(id, nom, cp){

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