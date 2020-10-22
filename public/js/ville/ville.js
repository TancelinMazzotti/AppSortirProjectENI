window.onload = loadVille();

function loadVille(){
    $.getJSON(ROOL_URL + "api/Ville/ListVille", function (data){
        for(var i = 0; i < Object.keys(data.list_ville).length; i++){
            tableauVille(data.list_ville[i]);
        }
        tableauLigneAjout();
    });
}

function tableauVille(ville){
    var newTrHtml = '<tr id="' + ville.id + '" class="ligneVille"><td class="border p-1 nom">' + ville.nom + '</td><td class="border p-1 cp">' + ville.codePostal + '</td>' +
        '<td class="border p-1"><a class="text-warning" onclick="modifierVille(' + ville.id + ')" href="#!">Modifier</a> - <a class="text-danger" onclick="supprimerVille(' + ville.id + ')" href="#!">Supprimer</a></td></tr>';
    if (document.getElementById("ajout_ville") === null){
        document.getElementById("table_ville").innerHTML += newTrHtml;
    }
    else{
        document.getElementById("ajout_ville").insertAdjacentHTML('beforebegin',newTrHtml);
    }
}

function tableauLigneAjout(){
    var trAjoutHtml = '<tr id="ajout_ville"><td class="border p-1 nom" id="nom"><input id="inp_nom" type="text"></td>' +
        '<td class="border p-1 cp" id="cp"><input id="inp_cp" type="text"></td>' +
        '<td class="border p-1"><a class="text-success" onclick="ajouterVille(document.getElementById(\'ajout_ville\').children.namedItem(\'nom\').children.namedItem(\'inp_nom\').value,' +
        'document.getElementById(\'ajout_ville\').children.namedItem(\'cp\').children.namedItem(\'inp_cp\').value)" href="#!">Ajouter</a></td></tr>';
    document.getElementById("table_ville").innerHTML += trAjoutHtml;
}

function ajouterVille(nom, cp){
    if (nom !== "" && cp !== "") {
        var villeAdd = {'nom': nom, 'cp': cp};
        $.post(ROOL_URL + "api/Ville/AddVille", villeAdd, function (data, textStatus) {
            if (textStatus === "success" && data.ville != null && data.ville.id != null && data.ville.nom != null && data.ville.codePostal != null) {
                tableauVille(data.ville);
                document.getElementById('ajout_ville').before(document.getElementById(data.ville.id));
                document.getElementById('ajout_ville').querySelector('.nom').querySelector('input').value = null;
                document.getElementById('ajout_ville').querySelector('.cp').querySelector('input').value = null;
            }
        }, "json");
    } else {
        alert('les champs Ville et Code postal doivent être remplis');
    }
}

function rechercheVille() {
    var valeurRecherche = document.getElementById("rechercheVille").value
    document.querySelectorAll('.ligneVille').forEach(function(a){
        a.remove();
    });
    $.getJSON(ROOL_URL + "api/Ville/ListVille/" + valeurRecherche, function (data){
        for(var i = 0; i < Object.keys(data.list_ville).length; i++){
            tableauVille(data.list_ville[i]);
        }
    });
}

function modifierVille(id){
    var tr = document.getElementById(id);
    var tdnom = tr.querySelector('.nom');
    var tdcp = tr.querySelector('.cp');

    if(tdnom.getElementsByTagName("INPUT").length === 0 || tdcp.getElementsByTagName("INPUT").length === 0){
        var villeNom = tdnom.innerHTML;
        var villeCp = tdcp.innerHTML;

        var inputNom = document.createElement("input");
        var inputCp = document.createElement("input");
        inputNom.setAttribute("id", "inp_nom_modif");
        inputCp.setAttribute("id","inp_cp_modif");
        inputNom.value = villeNom;
        inputCp.value = villeCp;

        tdnom.innerHTML = null;
        tdcp.innerHTML = null;
        tdnom.appendChild(inputNom);
        tdcp.appendChild(inputCp);
    } else {
        var villeNomInp = tdnom.querySelector('input').value;
        var villeCpInp = tdcp.querySelector('input').value;

        var villeModif = {'nom': villeNomInp, 'cp': villeCpInp, 'id': id};

        $.post(ROOL_URL + "api/Ville/updateVille", villeModif, function (data, textStatus) {
            if (textStatus === "success" && data.ville != null && data.ville.id != null && data.ville.nom != null && data.ville.codePostal != null) {
                tdnom.removeChild(tdnom.firstChild);
                tdcp.removeChild(tdcp.firstChild);

                tdnom.innerHTML = data.ville.nom;
                tdcp.innerHTML = data.ville.codePostal;
            }
        }, "json");
    }
}

function supprimerVille(id){
    $.getJSON(ROOL_URL + "api/Ville/Supprimer/"+ id, function (data){
        if (data.id != null){
            document.getElementById(data.id).remove();
        }
    });
}
