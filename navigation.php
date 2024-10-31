<?php
function csqsmnavigation(){
    if (!empty($_GET['mode'])) {
        $_GET['mode'] = sanitize_text_field($_GET['mode']);
        if($_GET['mode']=="singlequiz"){
          echo csqsmreturnhomebutton();
          csqsmsinglequiz();
        }

        if($_GET['mode']=="savesinglequiz"){
          echo csqsmreturnhomebutton();
          csqsmsavesinglequiz();
        }

        if($_GET['mode']=="deletequiz"){
          csqsmdeletequiz(csqsmvalidateandsanitizeid($_GET['idquiz']));
          echo csqsmlistquestionssuite(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
        }

        if($_GET['mode']=="newsuitequiz"){
          echo csqsmreturnhomebutton();
          csqsmsuitequiz();
        }

        if($_GET['mode']=="singlesuite"){
          echo csqsmreturnhomebutton();
          csqsmsinglesuite();
        }

        if($_GET['mode']=="savesinglesuite"){
          csqsmsavesinglesuite();
        }

        if($_GET['mode']=="deletesuite"){
          csqsmdeletesuite(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
          echo "<p>L'entrée ".csqsmvalidateandsanitizeid($_GET['idsuitequiz'])." a été effacée.</p>";
          csqsmdisplayhomepage();
          echo csqsmnewsuitebutton();
        }

        if($_GET['mode']=="listquestionssuite"){
          echo csqsmreturnhomebutton();
          echo csqsmlistquestionssuite(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
          echo csqsmnewquestioninsuitebutton(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
        }

        if($_GET['mode']=="togglesuitevisibility"){
          csqsmtogglesuitevisibility(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
          csqsmdisplayhomepage();
        }

        if($_GET['mode']=="displayquiz"){
          csqsmdisplayquiz(csqsmvalidateandsanitizeid($_GET['idsuitequiz']),csqsmvalidateandsanitizeid($_GET['idquiz']));
        }

    		if($_GET['mode']=="displayanswer"){
          csqsmdisplayanswer(csqsmvalidateandsanitizeid($_GET['idsuitequiz']),csqsmvalidateandsanitizeid($_GET['idquiz']));
        }

        if($_GET['mode']=="homepage"){
          csqsmdisplayhomepage();
        }
    }else {
      csqsmdisplayhomepage();
      echo csqsmnewsuitebutton();
    }
}
 ?>
