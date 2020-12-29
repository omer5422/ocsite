<?php
session_start();

function createForm(){
?>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center">
          <tr><td colspan="2">Lütfen nickinizi giriniz!</td></tr>
          <tr><td>Nick: </td>
          <td><input class="text" type="text" name="name" /></td></tr>
          <tr><td colspan="2" align="center">
             <input class="text" type="submit" name="submitBtn" value="Giriş" />
          </td></tr>
        </table>
      </form>
<?php
}

if (isset($_GET['u'])){
   unset($_SESSION['nickname']);
}

// Process login info
if (isset($_POST['submitBtn'])){
      $name    = isset($_POST['name']) ? $_POST['name'] : "İsimsiz";
      $_SESSION['nickname'] = $name;
}

$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : "Hidden";   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
 	
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
   <title>Veritabansız Türkçe Sohbet Scripti</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript">
    <!--
      var httpObject = null;
      var link = "";
      var timerID = 0;
      var nickName = "<?php echo $nickname; ?>";

      // Get the HTTP Object
      function getHTTPObject(){
         if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
         else if (window.XMLHttpRequest) return new XMLHttpRequest();
         else {
            alert("Your browser does not support AJAX.");
            return null;
         }
      }   

      // Change the value of the outputText field
      function setOutput(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML += response;
            objDiv.scrollTop = objDiv.scrollHeight;
            var inpObj = document.getElementById("msg");
            inpObj.value = "";
            inpObj.focus();
         }
      }

      // Change the value of the outputText field
      function setAll(){
         if(httpObject.readyState == 4){
            var response = httpObject.responseText;
            var objDiv = document.getElementById("result");
            objDiv.innerHTML = response;
            objDiv.scrollTop = objDiv.scrollHeight;
         }
      }

      // Implement business logic    
      function doWork(){    
         httpObject = getHTTPObject();
         if (httpObject != null) {
            link = "message.php?nick="+nickName+"&msg="+document.getElementById('msg').value;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setOutput;
            httpObject.send(null);
         }
      }

      // Implement business logic    
      function doReload(){    
         httpObject = getHTTPObject();
         var randomnumber=Math.floor(Math.random()*10000);
         if (httpObject != null) {
            link = "message.php?all=1&rnd="+randomnumber;
            httpObject.open("GET", link , true);
            httpObject.onreadystatechange = setAll;
            httpObject.send(null);
         }
      }

      function UpdateTimer() {
         doReload();   
         timerID = setTimeout("UpdateTimer()", 5000);
      }
    
    
      function keypressed(e){
         if(e.keyCode=='13'){
            doWork();
         }
      }
    //-->
    </script>   
</head>
<body onload="UpdateTimer();">
    <div id="main">
      <div id="caption">Veritabansız Türkçe Sohbet Scripti</div>
      <div id="icon">&nbsp;</div>
<?php 

if (!isset($_SESSION['nickname']) ){ 
    createForm();
} else  { 
      $name    = isset($_POST['name']) ? $_POST['name'] : "İsimsiz";
      $_SESSION['nickname'] = $name;
    ?>
      
     <div id="result">
     <?php 
        $data = file("msg.html");
        foreach ($data as $line) {
        	echo $line;
        }
     ?>
      </div>
      <div id="sender" onkeyup="keypressed(event);">
         Mesaj: <input type="text" name="msg" size="30" id="msg" />
         <button onclick="doWork();">Gönder</button>
      </div>   
<?php            
    }

?>
    </div>
</body>