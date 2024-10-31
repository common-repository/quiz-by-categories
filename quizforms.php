<?php
function csqsmsinglequiz() {

if(!csqsmhaseditorright()){
  csqsmechouserdenied();
  return;
}

// wrong notation quick fix
if(empty($_GET['quizid'])&& !empty($_GET['idquiz'])) $_GET['quizid'] = csqsmvalidateandsanitizeid($_GET['idquiz']);
    if (!empty($_GET['quizid'])){
      $_GET['quizid'] = csqsmvalidateandsanitizeid($_GET['quizid']);
      global $wpdb;
      $table_name = $wpdb->prefix . 'csqsmquiz';
      $results = $wpdb->get_results(
                  $wpdb->prepare("SELECT * FROM $table_name WHERE idquiz=%d", csqsmvalidateandsanitizeid($_GET['quizid'])),
    							ARRAY_A
               );

      $idquiz = (int)$results[0]['idquiz'] ;
      $idsuitequiz = (int)$results[0]['idsuitequiz'] ;
      $question = addslashes(esc_attr(sanitize_text_field( $results[0]['question']))) ;
      $reponse1 = addslashes(esc_attr(sanitize_text_field( $results[0]['reponse1']))) ;
      $reponse2 = addslashes(esc_attr(sanitize_text_field( $results[0]['reponse2']))) ;
      $reponse3 = addslashes(esc_attr(sanitize_text_field( $results[0]['reponse3']))) ;
      $reponse4 = addslashes(esc_attr(sanitize_text_field( $results[0]['reponse4']))) ;
      $reponse5 = addslashes(esc_attr(sanitize_text_field( $results[0]['reponse5']))) ;
      $bonne_reponse = (int)$results[0]['bonne_reponse'] ;
      $texte_bonne_reponse = addslashes(esc_attr(sanitize_text_field( $results[0]['texte_bonne_reponse']))) ;
      $texte_mauvaise_reponse = addslashes(esc_attr(sanitize_text_field( $results[0]['texte_mauvaise_reponse']))) ;
    }else{
      $idquiz = 0 ;
      $idsuitequiz = "" ;
      if(!empty($_GET['idsuitequiz'])) $idsuitequiz = csqsmvalidateandsanitizeid($_GET['idsuitequiz']);
      $question = "" ;
      $reponse1 = "" ;
      $reponse2 = "" ;
      $reponse3 = "" ;
      $reponse4 = ""  ;
      $reponse5 = "" ;
      $bonne_reponse = "" ;
      $texte_bonne_reponse = "" ;
      $texte_mauvaise_reponse = "" ;
    }

$check1 = "";
$check2 = "";
$check3 = "";
$check4 = "";
$check5 = "";

switch ($bonne_reponse) {
    case 1:
    $check1 = " checked='checked'";
    break;

    case 2:
    $check2 = " checked='checked'";
    break;

    case 3:
    $check3 = " checked='checked'";
    break;

    case 4:
    $check4 = " checked='checked'";
    break;

    case 5:
    $check5 = " checked='checked'";
    break;
}

  $droplistcontent = csqsmgeneratesuitequizdroplist($idsuitequiz);

  $token = csqsmreturnvalidatedandsanitizedtoken();
  // For translation from french
  $choosequizstring = esc_html__( 'Choisissez une suite de quiz :', 'quiz-by-categories' );
  $questionstring = esc_html__( 'Question :', 'quiz-by-categories' );
  $answer1string = esc_html__( 'Reponse 1 : ', 'quiz-by-categories' );
  $answer2string = esc_html__( 'Reponse 2 : ', 'quiz-by-categories' );
  $answer3string = esc_html__( 'Reponse 3 : ', 'quiz-by-categories' );
  $answer4string = esc_html__( 'Reponse 4 : ', 'quiz-by-categories' );
  $answer5string = esc_html__( 'Reponse 5 : ', 'quiz-by-categories' );
  $goodanswerstring = esc_html__( 'Texte pour la bonne réponse', 'quiz-by-categories' );
  $badanswerstring = esc_html__( 'Texte pour la mauvaise réponse', 'quiz-by-categories' );
  $savebuttonstring = esc_attr__( 'Enregistrer', 'quiz-by-categories' );

  echo " <form autocomplete='off' name='singlequizform' onsubmit='return csqsmvalidateForm2()' >
  <input type='hidden' id='mode' name='mode' value='savesinglequiz'>
  <input type='hidden' id='idquiz' name='idquiz' value='$idquiz'>
  <input type='hidden' id='quizid' name='quizid' value='$idquiz'>
  <input type='hidden' id='idsuitequiz' name='idsuitequiz' value='$idsuitequiz'>
  <input type='hidden' id='bonne_reponse' name='bonne_reponse' value='0'>


  <div class='grid-container'>
      <div class='grid-item wholeline'>
      <label for='suitequiz'>$choosequizstring</label>
           <select name='suitequiz' id='suitequiz' style='display: inline-block;'>
            $droplistcontent
            </select>
      </div>
      <div class='grid-item wholeline'><label for='question'>$questionstring</label>
      <textarea name='question' id='question' cols='40' rows='3'>$question</textarea></div>

        <div class='grid-item toplabel'><label for='reponse1'>$answer1string</label>
        <textarea name='reponse1' cols='40' rows='3'>$reponse1</textarea></div>
        <div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' $check1 id='question1radio' name='bonne_reponse' value='1'><span class='checkmark'></span></label> </div>
        <div class='grid-item toplabel'><label for='reponse2'>$answer2string</label>
        <textarea name='reponse2' cols='40' rows='3'>$reponse2</textarea> </div>
        <div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' $check2 id='question1radio' name='bonne_reponse' value='2'><span class='checkmark'></span></label> </div>
        <div class='grid-item toplabel'><label for='reponse3'>$answer3string</label>
        <textarea name='reponse3' cols='40' rows='3'>$reponse3</textarea> </div>
        <div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' $check3 id='question1radio' name='bonne_reponse' value='3'><span class='checkmark'></span></label> </div>
        <div class='grid-item toplabel'>  <label for='reponse4'>$answer4string</label>
        <textarea name='reponse4' cols='40' rows='3'>$reponse4</textarea></div>
        <div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' $check4 id='question1radio' name='bonne_reponse' value='4'><span class='checkmark'></span></label> </div>
        <div class='grid-item toplabel'><label for='reponse5'>$answer5string</label>
        <textarea name='reponse5' cols='40' rows='3'>$reponse5</textarea></div>
        <div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' $check5 id='question1radio' name='bonne_reponse' value='5'><span class='checkmark'></span></label> </div>



      <br>
      <div class='grid-item wholeline'><label for='texte_bonne_reponse'>$goodanswerstring</label><br>
      <textarea  id='texte_bonne_reponse' name='texte_bonne_reponse' cols='40' rows='3'>$texte_bonne_reponse</textarea></div>
      <div class='grid-item wholeline'><label for='texte_mauvaise_reponse'>$badanswerstring</label><br>
      <textarea  id='texte_mauvaise_reponse' name='texte_mauvaise_reponse' cols='40' rows='3'>$texte_mauvaise_reponse</textarea>
      </div>
  </div>
  <br>
  <center><input type='submit' value='$savebuttonstring'></center>
  </form> ";
  return;
}


function csqsmsavesinglequiz(){
if(!csqsmhaseditorright()){
    csqsmechouserdenied();
    return;
}

if(empty($_GET['question']) || empty($_GET['reponse1']) || empty($_GET['reponse2']) || empty($_GET['bonne_reponse'])){
  echo "Data entry failed data validation test.";
  return;
}

if(filter_var($_GET['bonne_reponse'], FILTER_VALIDATE_INT) === false ){
  echo "Must be a number";
  return;
}

if($_GET['bonne_reponse'] < 0 || $_GET['bonne_reponse'] > 5){
  echo "Answer must be a number between 1 and 5";
  return;
}

global $wpdb;
$table_name = $wpdb->prefix . 'csqsmquiz';
// If there is no record yet, create on. Else, modify existing one
if($_GET['idquiz'] == 0){
    $wpdb->insert(
              $table_name,
              array(
                  'idsuitequiz' => csqsmvalidateandsanitizeid($_GET['suitequiz']),
                  'question' => stripslashes(sanitize_text_field($_GET['question'])),
                  'reponse1' => stripslashes(sanitize_text_field($_GET['reponse1'])),
                  'reponse2' => stripslashes(sanitize_text_field($_GET['reponse2'])),
                  'reponse3' => stripslashes(sanitize_text_field($_GET['reponse3'])),
                  'reponse4' => stripslashes(sanitize_text_field($_GET['reponse4'])),
                  'reponse5' => stripslashes(sanitize_text_field($_GET['reponse5'])),
                  'bonne_reponse' => (int)$_GET['bonne_reponse'],
                  'texte_bonne_reponse' => stripslashes(sanitize_text_field($_GET['texte_bonne_reponse'])),
                  'texte_mauvaise_reponse' => stripslashes(sanitize_text_field($_GET['texte_mauvaise_reponse'])),
              )
          );
  }
else
  {
    $wpdb->update(
              $table_name,
              array(
                'idsuitequiz' => csqsmvalidateandsanitizeid($_GET['suitequiz']),
                'question' => stripslashes(sanitize_text_field($_GET['question'])),
                'reponse1' => stripslashes(sanitize_text_field($_GET['reponse1'])),
                'reponse2' => stripslashes(sanitize_text_field($_GET['reponse2'])),
                'reponse3' => stripslashes(sanitize_text_field($_GET['reponse3'])),
                'reponse4' => stripslashes(sanitize_text_field($_GET['reponse4'])),
                'reponse5' => stripslashes(sanitize_text_field($_GET['reponse5'])),
                'bonne_reponse' => (int)$_GET['bonne_reponse'],
                'texte_bonne_reponse' => stripslashes(sanitize_text_field($_GET['texte_bonne_reponse'])),
                'texte_mauvaise_reponse' => stripslashes(sanitize_text_field($_GET['texte_mauvaise_reponse'])),
              ),
              array(
                  'idquiz' => csqsmvalidateandsanitizeid($_GET['idquiz'])
              )
          );
  }
  if(!empty($_GET['idsuitequiz'])) {
    echo csqsmlistquestionssuite(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
    echo csqsmnewquestioninsuitebutton(csqsmvalidateandsanitizeid($_GET['idsuitequiz']));
  }else{
    csqsmsinglequiz();
  }
}


function csqsmdeletequiz($idquiz=0){
  if(!csqsmhaseditorright()){
    csqsmechouserdenied();
    return;
  }
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $wpdb->delete(
      $table_name,
      array(
        'idquiz' => (int)$idquiz
      )
    );

}


function csqsmlistquestionssuite($idsuitequiz){
  $idsuitequiz = (int)$idsuitequiz;
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              "SELECT * FROM $table_name WHERE idsuitequiz=$idsuitequiz",
              ARRAY_A
           );
  // get suite name for display
  $table_name = $wpdb->prefix . 'csqsmsuitequiz';
  $results2 = $wpdb->get_results(
              "SELECT nomsuitequiz FROM $table_name WHERE idsuitequiz=$idsuitequiz",
              ARRAY_A
           );
  $suitenamestring = esc_html__( 'Nom de la suite : ', 'quiz-by-categories' );
  $modifystring = esc_html__( 'Modifier', 'quiz-by-categories' );
  $deletestring = esc_html__( 'Supprimer', 'quiz-by-categories' );
  $buttonshtml = "<div class='grid-container'><div class='grid-item wholeline'>$suitenamestring<b>".sanitize_text_field($results2[0]['nomsuitequiz'])."</b></div>";
  foreach ($results as $row) {
    $idquiz = (int)$row['idquiz'];
    $idsuitequiz = (int)$row['idsuitequiz'];
    $question = sanitize_text_field($row['question']);
    $buttonshtml .= "<div class='grid-item'><P>$question</P></div>";
    $buttonshtml .= "<div class='grid-item'><A href='?mode=singlequiz&idquiz=$idquiz'>$modifystring</A><br><A href='?mode=deletequiz&idquiz=$idquiz&idsuitequiz=$idsuitequiz'>$deletestring</A></div>";
  }
  $buttonshtml .= "</div>";
  return $buttonshtml;
}


function csqsmgetfirstquizinsuite($idsuitequiz){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d", (int)$idsuitequiz),
              ARRAY_A
           );
  return $results[0];
}


function csqsmgetquizcountinsuite($idsuitequiz){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d", (int)$idsuitequiz),
              ARRAY_A
           );
  return count($results);
}


function csqsmgetnextidquizinsuite($idquizcurrent,$idsuitequiz){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d", (int)$idsuitequiz),
              ARRAY_A
           );
    // If array empty, somethings wrong. Return -2
    if(count($results)==0){
      return -2;
    }
$nextquizid=0;
 foreach ($results as $row) {
   // In case the current element id is selected, browse to the next element and then return it's id and exit function
   if($nextquizid == -1){
     return (int)$row['idquiz'];
   }
   if((int)$row['idquiz'] == $idquizcurrent){
     $nextquizid = -1;
   }
  }
// If all the list was browsed and no match was found then it must be the last element. Return -1
return -1;
}


function csqsmgetquizbyid($idquiz){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idquiz=%d", (int)$idquiz),
              ARRAY_A
           );
  return $results[0];
}


function csqsmtestanswer($idquiz,$answer){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idquiz=%d",(int) $idquiz),
              ARRAY_A
           );
 return ($results[0]['bonne_reponse'] == $answer);
}


function csqsmgetquizindexinsuite($idquiz, $idsuitequiz){
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmquiz';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE idsuitequiz=%d",(int)$idsuitequiz),
              ARRAY_A
           );
 $index = 1;
 foreach ($results as $row) {

   if((int)$row['idquiz'] == $idquiz){
     return $index;
   }
   $index++;
  }
// Error
return -1;
}


function csqsmhtmldisplayquiz($myquiz){
$myquiz['idquiz']=(int)$myquiz['idquiz'];
$myquiz['idsuitequiz']=(int)$myquiz['idsuitequiz'];
$myquiz['question']=sanitize_text_field($myquiz['question']);
$myquiz['reponse1']=sanitize_text_field($myquiz['reponse1']);
$myquiz['reponse2']=sanitize_text_field($myquiz['reponse2']);
$myquiz['reponse3']=sanitize_text_field($myquiz['reponse3']);
$myquiz['reponse4']=sanitize_text_field($myquiz['reponse4']);
$myquiz['reponse5']=sanitize_text_field($myquiz['reponse5']);

$answerstring = esc_attr__( 'Répondre', 'quiz-by-categories' );

$quizindex = csqsmgetquizindexinsuite($myquiz['idquiz'], $myquiz['idsuitequiz']);
$token = csqsmreturnvalidatedandsanitizedtoken();

  echo "
    <form autocomplete='off' name='displayquizform' onsubmit='return csqsmvalidateForm()' >
    <input type='hidden' id='mode' name='mode' value='displayanswer'>
    <input type='hidden' id='idquiz' name='idquiz' value='{$myquiz['idquiz']}'>
    <input type='hidden' id='idsuitequiz' name='idsuitequiz' value='{$myquiz['idsuitequiz']}'>
    <input type='hidden' id='reponse' name='reponse' value='0'>
    <div class='grid-container'>
        <div class='grid-item wholeline'>$quizindex. {$myquiz['question']}</div>";
        if($myquiz['reponse1']!=""){
        echo "<div class='grid-item'>{$myquiz['reponse1']}</div><div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' id='reponse11radio' name='reponse' value='1'><span class='checkmark'></span></label> </div>" ;
        }
        if($myquiz['reponse2']!=""){
        echo "<div class='grid-item'>{$myquiz['reponse2']}</div><div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' id='reponse12radio' name='reponse' value='2'><span class='checkmark'></span></label> </div>" ;
        }
        if($myquiz['reponse3']!=""){
        echo "<div class='grid-item'>{$myquiz['reponse3']}</div><div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' id='reponse13radio' name='reponse' value='3'><span class='checkmark'></span></label> </div>" ;
        }
        if($myquiz['reponse4']!=""){
        echo "<div class='grid-item'>{$myquiz['reponse4']}</div><div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' id='reponse14radio' name='reponse' value='4'><span class='checkmark'></span></label> </div>" ;
        }
        if($myquiz['reponse5']!=""){
        echo "<div class='grid-item'>{$myquiz['reponse5']}</div><div class='grid-item-radiobutton'><label class='containerradio'><input type='radio' id='reponse15radio' name='reponse' value='5'><span class='checkmark'></span></label> </div>" ;
        }
       echo "<div class='grid-item wholeline'> <input type='submit' value='$answerstring' class='centeredelement'> </div>
   </div>
   </form>";
}


function csqsmhtmldisplayanswer($myquiz,$idnextquiz,$answer,$explaination = "",$goodanswer=-1, $totalanswer=-1){
  $answertext = "";
  if($answer){
  $answertext = esc_html__( 'Bonne réponse !', 'quiz-by-categories' );
  }else{
  $answertext = esc_html__( 'Mauvaise réponse...', 'quiz-by-categories' );
  }
  $mode = "displayquiz";
  $submitbuttoncaption = esc_attr__( 'Prochaine question', 'quiz-by-categories' );
  $score = "";
  if($idnextquiz == -1){
  $mode = "homepage";
  $submitbuttoncaption = esc_attr__( 'Retourner à la&#10;liste des quiz', 'quiz-by-categories' );
  $goodanswer= (int)$goodanswer;
  $totalanswer= (int)$totalanswer;
  $yourscorestring = esc_html__( 'Votre score est de ', 'quiz-by-categories' );
  $score = "<div class='grid-item wholeline'><h2>$yourscorestring $goodanswer/$totalanswer</h2></div>";
  }
  $token = csqsmreturnvalidatedandsanitizedtoken();

  if($explaination != ""){
  sanitize_text_field($explaination);
  $explaination = "<div class='grid-item wholeline'>$explaination</div>";
  }else{
  $explaination = "";
  }
  $myquiz['idsuitequiz'] = (int)$myquiz['idsuitequiz'];
  echo "
    <form autocomplete='off'>
    <input type='hidden' id='mode' name='mode' value='$mode'>
    <input type='hidden' id='idquiz' name='idquiz' value='$idnextquiz'>
    <input type='hidden' id='idsuitequiz' name='idsuitequiz' value='{$myquiz['idsuitequiz']}'>

    <div class='grid-container'>
        <div class='grid-item wholeline'>$answertext</div>
        $explaination
        $score";

       echo "<div class='grid-item wholeline'> <input type='submit' value='$submitbuttoncaption' class='centeredelement'> </div>
   </div>
   </form>";
}


function csqsmdisplayquiz($idsuitequiz,$idquiz) {
    $currentquiz = array();
    // The user has already answered the quiz so remove the database entry and restart the quiz
    if($idquiz==-1){
      csqsmdeletesuitescore($idsuitequiz,csqsmgetuserid());
      $currentquiz = csqsmgetfirstquizinsuite($idsuitequiz);
    }
    // Answer suite at start
    elseif($idquiz==0){
      $currentquiz = csqsmgetfirstquizinsuite($idsuitequiz);

    }else{
      $currentquiz = csqsmgetquizbyid($idquiz);
    }
    csqsmhtmldisplayquiz($currentquiz);
}


function csqsmdisplayanswer($idsuitequiz,$idquiz){
  if(empty($_GET['reponse']) ){
    echo "Data entry failed data validation test.";
    return;
  }
  if(filter_var($_GET['reponse'], FILTER_VALIDATE_INT) === false ){
    echo "Must be a number";
    return;
  }
  if($_GET['reponse'] < 0 || $_GET['reponse'] > 5){
    echo "Answer must be a number between 1 and 5";
    return;
  }
// In case it's the good answer
$currentquiz = csqsmgetquizbyid($idquiz);
$idnextquiz =  csqsmgetnextidquizinsuite($idquiz,$idsuitequiz);
$answer = csqsmtestanswer($idquiz,(int)$_GET['reponse']);
csqsmsetsuitescore($idsuitequiz,$idquiz,$answer,csqsmgetuserid());
$goodanswer = csqsmgetgoodanswernumberinsuite($idsuitequiz,csqsmgetuserid());
$totalanswer = csqsmgetquizcountinsuite($idsuitequiz);
    if(csqsmtestanswer($idquiz,(int)$_GET['reponse'])){
      $explaination = sanitize_text_field($currentquiz['texte_bonne_reponse']);
    } else {
      $explaination = sanitize_text_field($currentquiz['texte_mauvaise_reponse']);
    }
csqsmhtmldisplayanswer($currentquiz,$idnextquiz,$answer,$explaination, $goodanswer, $totalanswer);
}
?>
