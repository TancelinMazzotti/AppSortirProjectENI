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
function myFunction(){
    console.log("salut")
}

console.log("slt")
// window.onload = loadCampus();

function loadCampus(){
    console.log("slt")
    // $.getJSON("https://127.0.0.1:8000/api/Campus/apiListCampus", function (data){
    //     for(var i = 0; i < Object.keys(data.list_campus).length; i++){
    //         tableauCampus(data.list_campus[i]);
    //     }
    // })
}

function tableauCampus(Campus){
    var newTrHtml = '<tr><td>' + campus.nomCampus + '</td><td class="border p-1">' +
        '<a href="" onclick="">Modifier</a> - <a href="" onclick="supprimerCampus(' + campus.id + ')">Supprimer</a></td></tr>';
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
    xhr.open("GET", "https://127.0.0.1:8000/api/Campus/Supprimer/"+ id, true);
    xhr.send();
}