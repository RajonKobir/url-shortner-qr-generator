<?php

// Start the session
session_start();

// checking 5 clicks
$submit_click_counter = $_POST['submit_click_counter'];



if($submit_click_counter >= 5){
  // checking valid re captcha
if(empty($_POST['g_recaptcha_response'])){
  echo 'error';
}else{
  $secret_key = '6LdmovkZAAAAANjjqB2LJ7bPLIWi-nAN817juMPh';

  $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g_recaptcha_response']);
 
  $response_data = json_decode($response);
 
  if(!$response_data->success)
  {
   echo 'error';
  }else{
      // taking the posted long url
      //triming special characters
      $url = test_input($_POST['real_url']);

      // shorting the posted long url into small url
      shorten_url($url);
  }
}
}else{    // if($submit_click_counter == 5){ ends here
        // taking the posted long url
      //triming special characters
      $url = test_input($_POST['real_url']);

      // shorting the posted long url into small url
      shorten_url($url);
}   










function shorten_url($url){
  // including the shorting process file
  include 'shorten.php';

  // making the short url
  $outputurl = Shortener($url);

  // this short url will be sent on success data
  echo $outputurl;

}



// triming special characters
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>

