function csqsmvalidateForm() {
  var x = document.forms["displayquizform"]["reponse"].value;
  if (x == 0) {
    alert("Veuillez entrer une réponse.");
    return false;
  }
}

function csqsmvalidateForm2() {
  var x = document.forms["singlequizform"]["bonne_reponse"].value;
  if (x == 0) {
    alert("Veuillez cocher la réponse.");
    return false;
  }
  if(document.getElementById("question").value===""){
    alert("Veuillez entrer une question.");
    return false;
  }
  if(document.forms["singlequizform"]["reponse1"].value === "" || document.forms["singlequizform"]["reponse2"].value === ""){
    alert("Veuillez entrer au moins deux réponses dans les deux premiers champs.");
    return false;
  }

  if(document.forms["singlequizform"]["reponse3"].value === "" && (document.forms["singlequizform"]["reponse4"].value !== "" || document.forms["singlequizform"]["reponse5"].value !== "")){
    alert("Veuillez ne pas laisser de reponse vide entre les champs.");
    return false;
  }

  if(document.forms["singlequizform"]["reponse4"].value === "" && document.forms["singlequizform"]["reponse5"].value !== ""){
    alert("Veuillez ne pas laisser de reponse vide entre les champs.");
    return false;
  }
}

function csqsmvalidateForm3() {
  var x = document.forms["nomsuiteform"]["nomsuitequiz"].value;
  if (x === "") {
    alert("Veuillez entrer un nom de suite.");
    return false;
  }
}

function csqsmtruefalsequizbutton(){
document.forms["singlequizform"]["reponse1"].value = "Vrai";
document.forms["singlequizform"]["reponse2"].value = "Faux";

}
