<?php
include_once 'security.php'; // Deal with administrator rights
include_once 'navigation.php'; // Allow user to navigate different pages content
include_once 'quizforms.php'; // All quiz related functions
include_once 'suiteforms.php'; // All suite related functions
global $post;

// Update the post so we get a different page each time (imperative)!
$update = array( 'ID' => get_the_ID() );
wp_update_post( $update );
//include 'screensize.htm'; // for screen size testing
// Test if there is a cookie set to track the user scores. If not, ask for user consent.
if(!isset($_COOKIE['idtoken'])) {
  csqsmdisplayusercookieauthorisation();
  return;
}

// Use de ?mode parameter to display the right page content
csqsmnavigation();



function csqsmreturnhomebutton(){
$returnhomebuttonstring = esc_html__( "Retour à la page d'accueil", 'quiz-by-categories' );
$button = "<center><A href='?'><button class='centeredelement isstrechedtocell buttonenabled'>$returnhomebuttonstring</button></A></center>";
return $button;
}


function csqsmdisplayhomepage(){
$quizbuttons = csqsmdisplayquizsuitebuttons();
$scorenotice = "";
if(csqsmhaseditorright()) $scorenotice ="<p>".esc_html__( "Vous ne pouvez pas répondre au quiz lorsque vous êtes connecté en mode administrateur ou éditeur. Pour le résultat fini, ouvrir sur un autre navigateur ou en mode incognito. Vous pouvez aussi vous déconnecter.", 'quiz-by-categories' )."</p>";
echo "
$scorenotice
<div class='grid-container'>
$quizbuttons
</div>
";
}


?>
