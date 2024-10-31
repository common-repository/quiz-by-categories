<?php
//var_dump(haseditorright());
function csqsmhaseditorright(){
  if( is_user_logged_in() ) {
   $user = wp_get_current_user();
   $roles = ( array ) $user->roles;
   foreach ($roles as $role) {
     if($role == "administrator" || $role == "editor") return true;
   }
  }
return false;
}

function csqsmechouserdenied(){
  echo "<p style='color:red;'>Vous n'avez pas les droits nécessaires pour effectuer cette opération.</p>";

}

function csqsmreturnvalidatedandsanitizedtoken(){
$token = null;
  if(!isset($_COOKIE['idtoken'])){
    if(strlen($_COOKIE['idtoken'])==40 && ctype_alnum($_COOKIE['idtoken'])){
      $token = sanitize_text_field($_COOKIE['idtoken']);
    }
    else{
      echo "token problem";
    }
  }
return $token;
}

function csqsmvalidateandsanitizeid($id){
$id = (int)$id;
return $id;
}

?>
