<?php


// getting short URL
function Shortener($url){
  include '../config.php';
  $return_url = short_url($url);
  return $domain.$return_url;
}


// getting short URL extension
function short_url($url){
  $randomNumber = rand(3,7);
  $shorturl = getRandomSlug($randomNumber);

  include '../config.php';

  $conn = new mysqli($servername,$username,$password,$dbname);
  if($conn -> connect_error){
    die("Conn failed");
  }

  
// making secured query string
$url  = mysqli_real_escape_string($conn, $url);
$shorturl  = mysqli_real_escape_string($conn, $shorturl);

  $sql = "SELECT * FROM urls WHERE shorturl='$shorturl'";

  // if any results found
  // change the shorturl
  if ($result = mysqli_query($conn,$sql)) {
    $shorturl .= getRandomSlug(1);
    $sql = "SELECT * FROM urls WHERE shorturl='$shorturl'";
    if ($result = mysqli_query($conn,$sql)) {
      $shorturl .= getRandomSlug(1);
    }
  }

  $sql = "INSERT INTO urls(url, shorturl, created_at) VALUES('$url', '$shorturl', now())";

  if($conn->query($sql)===TRUE){
    // created successfully
  }

  else{
    echo 'Error';
  }

  $conn -> close();

  return $shorturl;


}  //function short_url($url){ ends here




// getting random string
function getRandomSlug($length)
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $characterlength = strlen($characters);
  $randomString = '';

  for($i=0;$i<$length;$i++){
    $randomString .= $characters[rand(0,$characterlength-1)];
  }
  return $randomString;
}


// call the function deleteOldData()
deleteOldData();


// auto delete old entries from database
function deleteOldData(){
  include '../config.php';
  $conn = new mysqli($servername,$username,$password,$dbname);

// making secured query string
$validity  = mysqli_real_escape_string($conn, $validity);

  $query = "DELETE FROM Urls WHERE created_at < (now() - INTERVAL $validity)";
  // $conn->query($query);
  if($conn->query($query)===TRUE){
    // deleted successfully
  }
  
} 



 ?>
