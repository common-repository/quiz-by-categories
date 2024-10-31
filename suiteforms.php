<?php
function csqsmsinglesuite() {
if(!csqsmhaseditorright()){
  csqsmechouserdenied();
  return;
}

if (!empty($_GET['idsuitequiz']) && $_GET['idsuitequiz'] != 0 ){
  $_GET['idsuitequiz'] = csqsmvalidateandsanitizeid($_GET['idsuitequiz']);
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idquiz=%d", csqsmvalidateandsanitizeid($_GET['idsuitequiz'])),
							ARRAY_A
           );
  $idsuitequiz = (int)$results[0]['idsuitequiz'] ;
  $nomsuitequiz = sanitize_text_field($results[0]['nomsuitequiz']) ;
  $ishidden = (int)$results[0]['ishidden'] ;
}else{
  $idsuitequiz = 0 ;
  $nomsuitequiz = "" ;
  $ishidden = 0;
}

$checked = "";

if($ishidden == 1){
$checked = " checked";
}
$suitenamestring = esc_html__( 'Nom de la suite :', 'quiz-by-categories' );
$issuitevisiblestring = esc_html__( '  La suite est visible ?', 'quiz-by-categories' );
$savesuitestring = esc_attr__( 'Enregistrer', 'quiz-by-categories' );

  echo " <form autocomplete='off' name='nomsuiteform' onsubmit='return csqsmvalidateForm3()'>
  <input type='hidden' id='mode' name='mode' value='savesinglesuite'>
  <input type='hidden' id='idsuitequiz' name='idsuitequiz' value='$idsuitequiz'>
  <input type='hidden' name='ishidden' value='1' />
  <div class='grid-container'>
    <div class='grid-item wholeline'>$suitenamestring</div>
    <div class='grid-item wholeline'><input type='text' id='nomsuitequiz' name='nomsuitequiz' value='$nomsuitequiz'></div>
    <div class='grid-item '>$issuitevisiblestring</div>
    <div class='grid-item-centered'><label class='containercheckbox'>
      <input type='checkbox'  id='ishidden' name='ishidden' value='0' $checked>
      <span class='checkmark'></span></label>
    </div>
  </div>
  <br>
  <center><input type='submit' value='$savesuitestring'></center>
  </form> ";
  return;
}


function csqsmgeneratesuitequizdroplist($idsuitequizselected){
  $droplistcontent = "";
  if($idsuitequizselected==0){
  $droplistcontent ="<option value='0' selected >Choisissez une suite de quiz</option>";
  }
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results = $wpdb->get_results(
              "SELECT * FROM $table_name",
              ARRAY_A
           );
   foreach ($results as $row) {
     $idsuitequiz = (int)$row['idsuitequiz'];
     $nomsuitequiz = sanitize_text_field($row['nomsuitequiz']);
      if($idsuitequiz==$idsuitequizselected){
        $droplistcontent = $droplistcontent."<option value='$idsuitequiz' selected>$nomsuitequiz</option>"."\r\n";

      }else{
        $droplistcontent = $droplistcontent."<option value='$idsuitequiz'>$nomsuitequiz</option>"."\r\n";
      }
    }
return $droplistcontent;
}


function csqsmsuitequiz($idsuitequiz = 0){
$nomsuitequiz="";
if ($idsuitequiz != 0 || !empty($_GET['idsuitequiz'])){
  if(!empty($_GET['idsuitequiz'])) $idsuitequiz = csqsmvalidateandsanitizeid($_GET['idsuitequiz']) ;
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d", $idsuitequiz),
              ARRAY_A
           );

  $nomsuitequiz = sanitize_text_field($results[0]['nomsuitequiz']) ;
}
$suitenamestring = esc_html__( 'Créer une nouvelle suite', 'quiz-by-categories' );
$createsuitestring = esc_html__( 'Nom de la suite :', 'quiz-by-categories' );
$listsuitestring = esc_html__( 'Lister toutes les suites', 'quiz-by-categories' );

echo "
  <form autocomplete='off' >
  <input type='hidden' id='mode' name='mode' value='savesinglesuite'>
  <input type='hidden' id='idsuitequiz' name='idsuitequiz' value='$idsuitequiz'>

  <div class='grid-container'>
  <div class='grid-item wholeline'><label for='nomsuitequiz'>$suitenamestring</label>
  <input type='text' id='nomsuitequiz' name='nomsuitequiz' value='$nomsuitequiz'></div>
  </div>
  <br>
  <input type='submit' value='Submit'>
  </form>
  <A href='?mode=newsuitequiz'>$suitenamestring</A><br>
  <A href='?mode=listquizsuite'>$listsuitestring</A><br>
";
}


function csqsmsavesinglesuite(){
  if(!csqsmhaseditorright()){
    csqsmechouserdenied();
    return;
  }

  if(empty($_GET['nomsuitequiz'])  ){
    echo "Enter valid suite name.";
    return;
  }
  if(filter_var($_GET['ishidden'], FILTER_VALIDATE_INT) === false ){
    echo "Must be a number";
    return;
  }
  if($_GET['ishidden'] < 0 || $_GET['ishidden'] > 1){
    echo "Answer must be a binary";
    return;
  }

global $wpdb;
$table_name = $wpdb->prefix . 'csqsmsuitequiz';
// If there is no record yet, create on. Else, modify existing one
if($_GET['idsuitequiz'] == 0){
    $wpdb->insert(
              $table_name,
              array(
                  'idcategorie' => 0,
                  'nomsuitequiz' => stripslashes(sanitize_text_field($_GET['nomsuitequiz'])),
                  'ishidden' => (int)$_GET['ishidden'],
              )
          );
    $idsuitequiz = $wpdb->insert_id;
  }
  else
  {
    $wpdb->update(
              $table_name,
              array(
                'idcategorie' => 0,
                'nomsuitequiz' => stripslashes(sanitize_text_field($_GET['nomsuitequiz'])),
                'ishidden' => (int)$_GET['ishidden'],
              ),
              array(
                  'idsuitequiz' => (int)$_GET['idsuitequiz']
              )
          );
    $idsuitequiz = csqsmvalidateandsanitizeid($_GET['idsuitequiz']);
  }
csqsmdisplayhomepage();
echo csqsmnewsuitebutton();
}


function csqsmlistquizsuite(){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results = $wpdb->get_results(
              "SELECT * FROM $table_name",
              ARRAY_A
           );
   echo "<center><A href='?mode=newsuitequiz&idsuitequiz=0'><h3>Nouvelle suite</h3></A></center>";
   foreach ($results as $row) {
     $idsuitequiz = (int)$row['idsuitequiz'];
     $nomsuitequiz = sanitize_text_field($row['nomsuitequiz']);
     $quizsuiteanchor = "?mode=newsuitequiz&idsuitequiz=$idsuitequiz";
     $suitenamestring = esc_html__( 'Nom de la suite :', 'quiz-by-categories' );
     $deletesuitestring = esc_html__( 'Effacer cette suite', 'quiz-by-categories' );
     echo("<A href='$quizsuiteanchor'><p>$suitenamestring $nomsuitequiz</A>, <A href='?mode=deletesuite&idsuitequiz=$idsuitequiz' style='color:red'>$deletesuitestring</A></p>");
    }
  $nomsuitequiz = sanitize_text_field($results[0]['nomsuitequiz']) ;
}


function csqsmdeletesuite($idsuitequiz=0){
  if(!csqsmhaseditorright()){
    csqsmechouserdenied();
    return;
  }
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $wpdb->delete(
      $table_name,
      array(
        'idsuitequiz' => (int)$idsuitequiz
      )
    );
}


function csqsmnewquestioninsuitebutton($idsuitequiz){
$newquestionstring = esc_html__( 'Entrer une nouvelle question dans cette suite.', 'quiz-by-categories' );
$button = "<center><A href='?mode=singlequiz&idsuitequiz=$idsuitequiz'><button class='centeredelement isstrechedtocell buttonenabled'>$newquestionstring</button></A></center>";
return $button;
}


function csqsmnewsuitebutton($idsuitequiz=0){
if(!csqsmhaseditorright()) return "";
$newsuitestring = esc_html__( 'Créer une suite', 'quiz-by-categories' );
$button = "<center><A href='?mode=singlesuite&idsuitequiz=$idsuitequiz'><button class='centeredelement isstrechedtocell buttonenabled'>$newsuitestring</button></A></center>";
return $button;
}


function csqsmsetsuitevisibility($idsuitequiz,$ishidden){
  if(!csqsmhaseditorright()){
    csqsmechouserdenied();
    return;
  }
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $wpdb->update(
            $table_name,
            array(
              'ishidden' => (int)$ishidden,
            ),
            array(
                'idsuitequiz' => (int)$idsuitequiz
            )
        );
}


function csqsmtogglesuitevisibility($idsuitequiz){
$isvisible = csqsmgetsuitevisibility($idsuitequiz);
csqsmsetsuitevisibility($idsuitequiz,!$isvisible);
}


function csqsmgetsuitevisibility($idsuitequiz){
global $wpdb;
$table_name = $wpdb->prefix . 'csqsmsuitequiz';
$results = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d", (int)$idsuitequiz),
            ARRAY_A
         );
if(!empty($results)) return (int)$results[0]['ishidden'] ;
return false;
}


function csqsmdisplayquizsuitebuttons(){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results = $wpdb->get_results(
              "SELECT * FROM $table_name",
              ARRAY_A
           );
   $buttonshtml = "";
   foreach ($results as $row) {
     $grade = "";
     $isansweredclass = "";
     $editionoptions = "";
     $buttoncolorclass = "buttondisabled";
     $idsuitequiz = (int)$row['idsuitequiz'];
     $nomsuitequiz = sanitize_text_field($row['nomsuitequiz']);
     $suitescore = csqsmgetsuitescorebysuiteid($idsuitequiz,csqsmgetuserid());
       if(!empty($suitescore)){
         $answeredquestionsnumber = (int)$suitescore[0]['nbrquestionsrepondues'];
         $goodanswernumber = (int)$suitescore[0]['nbrbonnesreponses'];
       }else{
         $answeredquestionsnumber = -1;
         $goodanswernumber = -1;
       }
     $totalquestionsnumber = csqsmgetquizcountinsuite($idsuitequiz);
     $quizsuiteanchor = "?mode=displayquiz&idsuitequiz=$idsuitequiz&idquiz=0";
       if($answeredquestionsnumber != -1 ){
         $gradestring = esc_html__( 'Note&nbsp;:', 'quiz-by-categories' );
         $grade = "<div class='grid-item scoredisplay'><span class='bold'>$gradestring</span>&nbsp;$goodanswernumber/$totalquestionsnumber</div> \n\r";
         $quizsuiteanchor = "?mode=displayquiz&idsuitequiz=$idsuitequiz&idquiz=-1";

       } else {
         $isansweredclass = " wholeline ";
         $buttoncolorclass = " buttonenabled ";
       }
    $ishiddennotice = "";
    $quizsuitebuttonlinkdisabled= "";
      if(csqsmhaseditorright()) {
        $suitevisibilitydisplay = "";
        $quizsuitebuttonlinkdisabled = " class='disabled'";
        $buttoncolorclass = " buttonreallydisabled";
        if(csqsmgetsuitevisibility($idsuitequiz)){
        $suitevisibilitydisplay = "Rendre visible";
        $suitenotvisiblestring = esc_html__( "Cet suite de question n'est pas visible à l'utilisateur", 'quiz-by-categories' );
        $ishiddennotice = "<center><p style='font-size:large;'>$suitenotvisiblestring</p></center>";
        }else{
        $suitevisibilitydisplay = "Rendre invisible";
        }
        $editionoptions = "<div class='grid-item' ><A href='?mode=listquestionssuite&idsuitequiz=$idsuitequiz'>Ajouter/Modifier</A><br><A href='?mode=togglesuitevisibility&idsuitequiz=$idsuitequiz'>$suitevisibilitydisplay</A><br><A href='?mode=deletesuite&idsuitequiz=$idsuitequiz'>Supprimer</A></div> \n\r";
        $grade = "";
        $isansweredclass = "";
      }

     if(($totalquestionsnumber>0 && !$row['ishidden']) || csqsmhaseditorright()){
     $buttonshtml .= "
     <div class='grid-item $isansweredclass'><A href='$quizsuiteanchor' $quizsuitebuttonlinkdisabled><button class='centeredelement isstrechedtocell $buttoncolorclass'>$nomsuitequiz</button></A>$ishiddennotice</div> \n\r
     $grade \n\r $editionoptions
     ";
      }
    }
return $buttonshtml;
}


function csqsmgetsuitescorebysuiteid($idsuitequiz,$iduser=0){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d AND iduser=%d", (int)$idsuitequiz, (int)$iduser),
              ARRAY_A
           );
  return $results;
}


function csqsmgetgoodanswernumberinsuite($idsuitequiz,$iduser=0){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d AND iduser=%d", (int)$idsuitequiz, (int)$iduser),
              ARRAY_A
           );
  if(empty($results)) return -1;
  return (int)$results[0]['nbrbonnesreponses'];
}


function csqsmgetresponsesuiteitembyidsuitequiz($idsuitequiz, $iduser){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d AND iduser=%d",(int)$idsuitequiz, (int)$iduser),
              ARRAY_A
           );

  return $results[0];
}


function csqsmdeletesuitescore($idsuitequiz,$iduser=0){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $wpdb->delete(
      $table_name,
      array(
        'idsuitequiz' => (int)$idsuitequiz,
        'iduser' => (int)$iduser
      )
    );
}


function csqsmsetsuitescore($idsuitequiz,$idquiz,$answer,$iduser=0){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmreponsesuite';
  $nbrbonnesreponses=0;
  $nbrquestionsrepondues = csqsmgetquizindexinsuite($idquiz,$idsuitequiz);

  if(empty(csqsmgetsuitescorebysuiteid($idsuitequiz,$iduser)))
  {
    $nbrbonnesreponses = $answer ? 1 : 0 ;
    $wpdb->insert(
              $table_name,
              array(
                  'iduser' => (int)$iduser,
                  'idsuitequiz' => (int)$idsuitequiz,
                  'nbrquestionsrepondues' => 1,
                  'nbrbonnesreponses' => (int)$nbrbonnesreponses,

              )
          );
  }else{
    if($nbrquestionsrepondues <= (int)csqsmgetresponsesuiteitembyidsuitequiz($idsuitequiz, $iduser)['nbrquestionsrepondues'] ){
       $noanswer2timesstring = esc_html__( "Vous ne pouvez pas répondre à la même question deux fois.", 'quiz-by-categories' );
       echo $noanswer2timesstring;
       return;
    }

    $nbrbonnesreponses = csqsmgetgoodanswernumberinsuite($idsuitequiz,$iduser);
    if($answer) $nbrbonnesreponses++;
    $wpdb->update(
              $table_name,
              array(
                  'iduser' => (int)$iduser,
                  'idsuitequiz' => (int)$idsuitequiz,
                  'nbrquestionsrepondues' => (int)$nbrquestionsrepondues,
                  'nbrbonnesreponses' => (int)$nbrbonnesreponses,

              ),
              array(
                  'idsuitequiz' => (int)$idsuitequiz,
                  'iduser' => (int)$iduser
              )
          );
  }
}



?>
