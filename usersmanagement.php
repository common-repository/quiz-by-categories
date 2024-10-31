<?php

function csqsmgetuserid(){
// Cookie is not set !
if(!isset($_COOKIE['idtoken'])) return -1;
$iduser = csqsmgetiduserbytoken($_COOKIE['idtoken']);
// Token does not exist in database
if (empty($iduser)) return -2;

return $iduser;
}

function csqsmgethostipaddress(){
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
      $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;

}

function csqsmsetcookietoken(){
//CookieManager::setcookietoken();


  //if( !isset($_COOKIE['idtoken']) && is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $csqsmquizshortcodename) && !is_admin() ){
if( !isset($_COOKIE['idtoken']) &&   !is_admin() ){
    $token = csqsmgetToken(40);
    csqsmsetnewusertoken($token);
    setcookie("idtoken", $token, time()+31556926, COOKIEPATH, COOKIE_DOMAIN);
  //  echo "User id after insert : ". strval(getiduserbytoken($token));
  //  echo "<br>".gethostipaddress();
    //self::$createdcookiecalled++;
  //  echo self::$createdcookiecalled;


} else if (isset($_COOKIE['idtoken'])){
  if(empty(csqsmgetiduserbytoken($_COOKIE['idtoken']))){
     // token does not exist in database because it was deleted before
     $token = csqsmgetToken(40);
     csqsmsetnewusertoken($token);
     setcookie("idtoken", $token, time()+31556926, COOKIEPATH, COOKIE_DOMAIN);
     //echo "User id after insert : ". strval(getiduserbytoken($token));
     //echo "<br>".gethostipaddress();
  }

}

}

function csqsmgetiduserbytoken($token){
  if(strlen($token)!=40) {
    echo "Permission denied";
    return;
  }
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmusertoken';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE token=%s", $token),
              ARRAY_A
           );
  if(empty($results)) return [];
  return $results[0]['iduser'];
}

function csqsmsetnewusertoken($token){
  global $wpdb;
  //echo "setnewusertoken";
  //$currentip ="INET_ATON(".gethostipaddress().")";
 // Very important for some reason the server call the code with host ip as server ip causing db to make 2 entry.
 if(csqsmgethostipaddress() == $_SERVER['SERVER_ADDR']) return;
  $currentip = ip2long(csqsmgethostipaddress()) ;
/*
  if($currentip==ip2long($_SERVER['SERVER_ADDR'])){
    echo "good !!";
    return;
  }
  if($csqsmquizusercookietokenasbeenset) return;*/
  $users = csqsmgetuserbyip("",$currentip);
  //var_dump($users);
  if(count($users) > 50){
    // There is a maximum of 50 token for the same ip address if there is more, delete the older token and include new one.
    echo "More than one user registered under the same ip address. It should not...";
    $user = $users[0];
    $table_name = $wpdb->prefix . 'csqsmusertoken';


    $wpdb->delete(
              $table_name,
              array(
                'iduser' => $user['iduser'],
              ),
              array(
                  '%d'
              )
          );

    $table_name = $wpdb->prefix . 'csqsmusertoken';
    $wpdb->insert(
              $table_name,
              array(
                  'token' => $token,
                  'currentip' => $currentip,
              )
          );

  }
   else {
  // There is not entry yet.... Insert.
  $table_name = $wpdb->prefix . 'csqsmusertoken';
  $wpdb->insert(
            $table_name,
            array(
                'token' => $token,
                'currentip' => $currentip,
            )
        );

  // $idsuitequiz = $wpdb->insert_id;
  }

}

function csqsmgetuserbyip($stringip="",$intip=0){
if($intip==0 && $stringip!=""){
$intip = ip2long($stringip);
}
  global $wpdb;
  $table_name = $wpdb->prefix . 'csqsmusertoken';
  $results = $wpdb->get_results(
              $wpdb->prepare("SELECT * FROM $table_name WHERE currentip=%d ORDER BY lastupdated", $intip),
              ARRAY_A
           );
  if(empty($results)) return [];
  return $results;

}
// Random token generation functions
function csqsmcrypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function csqsmgetToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[csqsmcrypto_rand_secure(0, $max-1)];
    }

    return $token;
}


function csqsmdisplayusercookieauthorisation(){
echo "
<div class='grid-container'>
<div class='grid-item wholeline centeredelement'>Pour pouvoir mémoriser vos réponses et vous permettre de connaître quels quiz vous avez complétés, ce site utilise un témoin qui permettra au système de vous identifier.</div>
<div class='grid-item wholeline'><A href='?mode=homepage'><input class='centeredelement' type='submit' value='Je suis d&apos;accord.'></A></div>
</div>
";
}



?>
