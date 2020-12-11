// document dot ready function starts
// $(document).ready(function(){


// recaptcha ok event clicks the submit
var imNotARobot = function() {
  // taking input url value
  var real_url = $('#real_url').val();

// real url is not empty checking
if(real_url == ''){
  $('#error_message').html('Please Enter A Long URL!');
  $('#real_url').focus();
  grecaptcha.reset();
}else{ // real url is not empty

  if(validURL(real_url) == true){
  // alert("Button was clicked");
  $("#submit_button").removeAttr('disabled');
  $('#submit_button').click();

 }else{    // if(validURL(real_url) == true){ ends here
  $('#error_message').html('Invalid URL!');
  $('#real_url').focus();
  grecaptcha.reset();
 }



}

};



// // click counter
if (submit_click_counter >= 5){
  // showing re captha form
  $('#re_captcha').show();
}

// click counter becomes 0 after one day
setInterval(function(){ 
  $.ajax({
    url:"./actions/initialize_session_next_day.php",
    method:"POST",
    data:{
      submit_click_counter: submit_click_counter
    },
    success:function(data)
    {
      // alert(data);
      location.reload();
    }
  });

}, 24 * 60 * 60 * 1000 );
// end of setinterval


// same url twice checker
var url_twice_checker = '';

  // submit long url
  function submitLongUrl(){

    // taking input url value
    var real_url = $('#real_url').val();

    // same url twice checker
    if(url_twice_checker == '' || url_twice_checker != real_url){
      // if valid url
      if(validURL(real_url) == true){
        var g_recaptcha_response = $('#g-recaptcha-response').val();
        $.ajax({
          url:"./actions/create.php",
          method:"POST",
          data:{
            real_url: real_url,
            g_recaptcha_response: g_recaptcha_response,
            submit_click_counter: submit_click_counter
          },
          success:function(data)
          {
            if(data[0] == 'e'){
              // showing re captha form
              $('#re_captcha').show();
              $('#error_message').html('Please Fill Up Re-Captcha!');
              // disable input field
              $("#real_url").attr('disabled','disabled');
              $("#submit_button").attr('disabled','disabled');
            }else{
              // putting input url domain value in download button
              var real_url = $('#real_url').val();
              var domain = extractDomain(real_url);
              $("#download_button").attr('download', domain+'-urlshrt_short_url.jpg');
              // resetting the recaptcha
              $('#re_captcha').hide();
              grecaptcha.reset();
              $('#error_message').html('');
              $('#dummy_data').hide();
              $('#short_url_area').show();
              $('#left_qr_area').hide();
              $('#right_qr_area').hide();

// clearing the inner html first
$("#qr_code").html("");
$('#qr_code').qrcode({
  render: 'canvas', 
  width: 140, 
  height: 140, 
  text: data
});

              $("#left_qr_area").fadeIn(1000);
              $("#right_qr_area").fadeIn(1000);
              $('#left_qr_area').show();
              $('#right_qr_area').show();
              $('#short_url').val(data);

              

      // enable input field
      $("#real_url").removeAttr('disabled');
      $("#submit_button").removeAttr('disabled');

              // to download button
              var tooltip = document.getElementById("myTooltip2");
              tooltip.innerHTML = "Click To Download!";

              // click counter increases
              submit_click_counter++;

              $.ajax({
                url:"./actions/update_success_submit_count.php",
                method:"POST",
                data:{
                  submit_click_counter: submit_click_counter
                },
                success:function(data)
                {
                  // alert(submit_click_counter);
                }
              });


      // showing promotional dialog
      // showing promotional dialog
      // if(submit_click_counter >= 3){

      // // disable keyboard
      //   disable();

      // // blur the input field
      // $('#real_url').blur();

      //   // Get the modal_dialog
      // var modal_dialog = document.getElementById("myModal");

      // // Get the <span> element that closes the modal_dialog
      // var span = document.getElementsByClassName("close")[0];


      // // When the user clicks the button 3 times, open the modal_dialog 
      // modal_dialog.style.display = "block";


      // // When the user clicks on <span> (x), close the modal_dialog
      // span.onclick = function() {
      //   modal_dialog.style.display = "none";
      //   // focus the input field
      //   $('#real_url').focus();
      //   // enable keyboard again
      //   enable();
      // }

      // // When the user clicks anywhere outside of the modal_dialog, close it
      // window.onclick = function(event) {
      //   if (event.target == modal_dialog) {
      //     modal_dialog.style.display = "none";
      //       // focus the input field
      //       $('#real_url').focus();
      //       // enable keyboard again
      //       enable();
      //   }
      // }

      // }  //if(submit_click_counter == 3){ ends here
      // showing promotional dialog ends here
      // showing promotional dialog ends here


              // same url twice checker
              url_twice_checker = real_url;



      }  
      // error else ends here 

          }
          
        })
      }else{  // if invalid url

        $('#error_message').html('Invalid URL!');
      }
      }else{   // same url twice checker ends here
      $('#error_message').html('Please enter a new URL!');
      }  





  }   //   function submitLongUrl(){ ends here

    


  // copy short url
  function copyShortUrl(e){
    var short_url = $('#short_url').val();
    if(short_url == ''){
      // alert();
      var tooltip = document.getElementById("myTooltip");
      tooltip.innerHTML = "Empty!";
    }else{
      // alert();
      var copyText = document.getElementById("short_url");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      
      var tooltip = document.getElementById("myTooltip");
      tooltip.innerHTML = "Copied!";
    }

  }  // copy short url ends here




// share short url
function shareShortUrl(){

// blur the input field
$('#real_url').blur();

var short_url = $('#short_url').val();

// putting right href values
$("#twitter_icon_url").attr("href", "https://twitter.com/intent/tweet?text=Short%20Link%20From%20urlshrt.co%20is:%20&url="+short_url);
$("#facebook_icon_url").attr("href", "https://www.facebook.com/sharer.php?u="+short_url);
$("#gmail_icon_url").attr("href", "mailto:?subject=Short Link From urlshrt.co&body="+short_url);
$("#linkedin_icon_url").attr("href", "https://www.linkedin.com/sharing/share-offsite/?url=www."+short_url);


}  
// share short url ends here




// donate dialog starts here
// donate dialog starts here
function donateUrlshrt(e){
// disable keyboard
disable();

// blur the input field
$('#real_url').blur();

  // Get the modal_dialog
var modal_dialog = document.getElementById("myModal2");

// Get the <span> element that closes the modal_dialog
var span = document.getElementsByClassName("close")[1];

// When the user clicks the button 3 times, open the modal_dialog 
modal_dialog.style.display = "block";


// enable keybord on click on donate form
$("#paypal-button-container").click(function(){
    enable();
  });


// When the user clicks on <span> (x), close the modal_dialog
span.onclick = function() {
  modal_dialog.style.display = "none";
  // enable keyboard again
  enable();
}

// When the user clicks anywhere outside of the modal_dialog, close it
window.onclick = function(event) {
  if (event.target == modal_dialog) {
    modal_dialog.style.display = "none";
      // enable keyboard again
      enable();
  }
}

  }  
// donate dialog ends here
// donate dialog ends here





// tooltip on hover
function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Click To Copy!";
}



// download QR Code Image as JPG
// download QR Code Image as JPG
var download_button = document.getElementById('download_button');
download_button.addEventListener('click', function (e) {
    // e.preventDefault();
    // taking the created canvas element of the QR Code
    var canvas = document.getElementsByTagName('canvas')[0];
    if(canvas){
        // starts downloading the image
      var tmpJPG = canvas.toDataURL("image/jpg");
      download_button.href = tmpJPG;
    }else{
      // alert('no qr code');
      e.preventDefault();
      var tooltip = document.getElementById("myTooltip2");
      tooltip.innerHTML = "No QR Code Generated!";
    }
});
// download QR Code Image as JPG ends here
// download QR Code Image as JPG ends here




// url checker 
function validURL(str) {
  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  return !!pattern.test(str);
}


// how to extract domai name from a URL
function extractDomain(url) {
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (url.indexOf("://") > -1) {
      domain = url.split('/')[2];
    }
    else {
      domain = url.split('/')[0];
    }
    
    //find & remove www
    if (domain.indexOf("www.") > -1) { 
      domain = domain.split('www.')[1];
    }
    
    domain = domain.split(':')[0]; //find & remove port number
    domain = domain.split('?')[0]; //find & remove url params
  
    return domain;
  }
// extract domain name ends here



// enable and disable keyboard
function disable()
{
 document.onkeydown = function (e) 
 {
  return false;
 }
}
function enable()
{
 document.onkeydown = function (e) 
 {
  return true;
 }
}
// enable and disable keyboard ends here



// paypal button starts here
// paypal button starts here
function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'pill',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"Buy Me a Coffee","amount":{"currency_code":"USD","value":5}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name + '!');
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
// paypal button ends here
// paypal button ends here




// });
// document dot ready function ends