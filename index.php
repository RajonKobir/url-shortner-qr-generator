<?php

// Start the session
session_start();

// including configuration file
include './config.php';

if(!isset($_SESSION["submit_click_counter"])){
  $_SESSION["submit_click_counter"] = 1;
}


//triming special characters
$_SERVER['REQUEST_URI'] = test_input($_SERVER['REQUEST_URI']);


// checking URL extensions
foreach (explode('/', $_SERVER['REQUEST_URI']) as $part) {
  $elem = $part;
}
if($elem != ''){

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn -> connect_error){
  die("Conn failed");
}
// making secured query string
$elem  = mysqli_real_escape_string($conn, $elem);

$sql = "SELECT * FROM urls WHERE shorturl='$elem'";

if($result = mysqli_query($conn,$sql)){
  $getRes = mysqli_fetch_assoc($result);
  $url = $getRes['url'];

// checking http:// esists
if(strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
  $url = 'http://'.$url;
}

  // if exists in db
  header("Location: $url");
}else{
  // doesn't exist in db
  // echo '<script>window.location.assign("https://urlshrt.co/");</script>';
  $url = 'http://urlshrt.co/';
  header("Location: $url");
}

$conn->close();
die();
  

} // if($elem != ''){ ends here


// triming special characters
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>URL Shortner and QR code generator - URLSHRT</title>
    <link rel="shortcut icon" href="./assets/images/main_images/favicon_0.5x.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="description" content="Create a shortened URL and QR code for free. Perfect website to transform your long urls to short urls and exportable QR codes. Visit www.urlshrt.co">
    <meta name="keywords" content="URL, url, short, long url, long, qr code, QR Code">
    <meta name="author" content="URLSHRT">
    <!-- preview image  -->
    <meta property="og:image" content="./assets/images/preview_image/urlshrt_url_shortner.jpg">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--bootstrap min css-->
<link href="./assets/css/bootstrap.min-v4.0.0.css" rel="stylesheet">
<!--style css-->
<link href="./assets/css/style.css" rel="stylesheet" type="text/css">
<!--responsive css-->
<link href="./assets/css/responsive.css" rel="stylesheet" type="text/css">


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JH2CZ59CSR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JH2CZ59CSR');
</script>

</head>

<body>
   <div class="main_contant">

    <!-- header_start -->
<header>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo">
                        <a href="https://www.urlshrt.co">
                          <img src="./assets/images/main_images/Pagelogo.png" alt="logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </header>
    <!-- header_end -->


    <!-- input_area start-->
    <div class="input_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <form id="captcha_form" action="javascript:;" onsubmit="submitLongUrl(this)" class="general_form">
                        <div class="real_url_input_area form-group">
                            <label>Past your long URL here:</label>
                            <input type="text" value="" id="real_url" name="real_url" class="form-control leb_1" placeholder="www.abd.com/efgh" required autocomplete="off">
                            <!-- <label class="leb_1"></label> -->
                            <i class="fas fa-paperclip"></i>
                            <button id="submit_button" type="submit" class="btn btn_1 text-uppercase">SUBMIT</button>
                        </div>
                        <div class="form-group">
                          <p id="error_message" class="text-danger"></p>
                        </div>
                        <div id="re_captcha" class="form-group">
                          <div class="g-recaptcha" data-callback="imNotARobot" data-sitekey="<?php echo $sitekey; ?>"></div>
                          <span id="captcha_error" class="text-danger"></span>
                        </div>
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    </form>


<div id="dummy_data" class="dummy_data">
<div class="helping_image">
  <img src="./assets/images/helping_images/Group4@2x.jpg" alt="Image Not Found!">
</div>

</div>


<!-- The Modal for promotion dialog -->
<div id="myModal" class="modal_dialog">

  <!-- Modal content -->
  <div class="modal_dialog-content">
    <div class="modal_dialog-body text-center py-3">
      <span class="close">&times;</span>
      <a target="_blank" href="https://urlshrt.co">
        <img src="./assets/images/main_images/Pagelogo@2x.png" alt="Image Not Found!">
      </a>
    </div>
  </div>

</div>
<!-- The Modal ends here -->


                    <div id="short_url_area" class="general_form">
                        <div class="form-group">
                            <label>Your short URL:</label>
                            <input type="text" id="short_url" name="short_url"  class="form-control leb_1" value="" placeholder="www.abd.com/efgh" readonly autocomplete="off">
                            <!-- <label class="leb_1"></label> -->
                            <i class="fas fa-paperclip"></i>
                            <div class="tooltip_style">
                                <button onclick="copyShortUrl()" onmouseout="outFunc()" class="btn btn_2 text-uppercase">COPY</button>
                                <span class="tooltiptext1" id="myTooltip">Click To Copy!</span>
                            </div>
                        </div>
                    </div>
                    <div id="qr_area" class="row qr_area">
                        <div id="left_qr_area" class="col-lg-4">
                            <div id="qr_code" class="qr_code">
                                
                            </div>
                        </div>
                        <div id="right_qr_area" class="col-lg-8">
                            <div class="text">
                                <h2><span>Download</span> this QR code as a JPG</h2>
                            </div>
                            <div class="btn_group">
                                <div class="tooltip_style">
                                    <!-- <a href="" class="btn_2">DOWNLOAD</a> -->
                                    <a href="" target="_blank" download="urlshrt.co.jpg" id="download_button" class="btn btn_2 text-uppercase">Download</a>
                                    <span class="tooltiptext" id="myTooltip2">Click To Download!</span>
                                </div>
                                  <div class="dropdown">
                                    <div class="tooltip_style">
                                      <a id="share_button" class="btn btn_1" type="button" data-toggle="dropdown" onclick="shareShortUrl()">
                                        SHARE
                                      </a>
                                      <ul id="dropdown_menu" class="dropdown-menu">
                                        <li><a id="twitter_icon_url" target="_blank" href=""><i class="fab fa-twitter"></i></a></li>
                                        <li><a id="facebook_icon_url" target="_blank" href=""><i class="fab fa-facebook"></i></a></li>
                                        <li><a id="gmail_icon_url" target="_blank" href=""><i class="fas fa-envelope"></i></a></li>
                                        <li><a id="linkedin_icon_url" target="_blank" href=""><i class="fab fa-linkedin"></i></a></li>
                                      </ul>
                                      <span class="tooltiptext" id="myTooltip2">
                                        Click To Share!
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="bg_image">
                        <img src="./assets/images/Image5@1X.png" alt="Image Not Found!">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- input_area  end-->





    <div class="call_to_action">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer_item">
                        <a href="#"><img src="./assets/images/Img_1.png" alt="Image Not Found!"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>



<!-- The Modal for donate button -->
<div id="myModal2" class="modal_dialog">

  <!-- Modal content -->
  <div class="modal_dialog-content">
    <div class="modal_dialog-body text-center py-3">
      <span class="close">&times;</span>
      <div id="urlshrt_donate_paypal">
        <h6 class="text-center text-dark">Buy Me A Coffee For Using URLSHRT</h6>
        <div id="smart-button-container">
          <div style="text-align: center;">
            <div id="paypal-button-container"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- The Modal ends here -->



    <!--Footer Start-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <p>&copy; 2020 Urlshrt. All rights reserved.</p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <ul>
                        <li><a id="donate_button" onclick="donateUrlshrt()">Buy Me Coffee</a></li>
                        <li><a href="mailto:contact@urlshrt.co?subject=General Inquiry&body=I want to know more about this website!">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer  End-->




<script>
  // click counter
var submit_click_counter = '<?php echo $_SESSION["submit_click_counter"]; ?>';

</script>


    <!--font awesome-->
    <link href="./assets/css/fontawesome-all.min-5.0.10.css" rel="stylesheet">
    <!--jquery min js-->
    <script src="./assets/js/jquery.min.v3.1.1.js"></script>
    <!--jquery migrate-->
    <!-- <script src="./assets/js/jquery-migrate-3.0.1.js"></script> -->
    <!-- QR Code JS -->
    <script type="text/javascript" src="./assets/js/jquery.qrcode.min.js"></script>
    <!--popper min js-->
    <script src="./assets/js/popper.min.js"></script>
    <!--Bootstrap min js-->
    <script src="./assets/js/bootstrap.min-v4.0.0.js"></script>
    <!--Owl Carousel min js-->
    <!-- <script src="./assets/js/owl.carousel.min.js"></script> -->
    <!--Paypal Button JS-->
    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD" data-sdk-integration-source="button-factory"></script>
    <!-- Google Re-Captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!--Main js-->
    <script src="./assets/js/main.js"></script>









</body>

</html>