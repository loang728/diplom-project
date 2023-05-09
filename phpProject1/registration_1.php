<!DOCTYPE html>
<html>
<head>
	<title> Регистрация </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
	<script src="codebase/dhtmlx.js"></script>
        <style>
            .left {
                position: absolute;
                left: 0px;
                top:  60px;
                width: 400px;
                background-color: #87e14e;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 12px;
            }
            
            .right {
                position: absolute;
                right: 0px;
                top:530px;
                width: 400px;
                background-color: #87e14e;
                font-family: Verdana, Geneva, sans-serif;
                font-size: 12px;
                 
            }
            
            
        </style>
	<script>
		var myForm, formData;
		function doOnLoad() {
			myForm = new dhtmlXForm("myForm");
			myForm.loadStruct("json/registration.json", function(){});
                        myForm.setFontSize("15px");
                        myForm.attachEvent("onButtonClick", function (id) {
                            if (id == "send") {
                                alert("button clicked");
                                if(myForm.validate()){
                                    if(myForm.getItemValue("pPass")==myForm.getItemValue("pPass2")){
                                        myForm.send("registerme.php", "post", function (loader, response) {
                                        alert(response);
                                        });
                                     }
                                     else {
                                         alert("Паролите не съвпадат!"); 
                                     }
                                 }
                           }
                        });
		}
               
	</script>
        
</head>
<body onload="doOnLoad();"  background="common/imgs/signing.jpg">
   <?php include('menu.php') ?>    
	<div id="myForm" style="height:100px;  position:relative;   left: 340px; top: 140px" ></div>
        <div class="left">
  <p> &nbsp; Регистрирайте се за да използвате приложението.</p>
  
</div>
        
         <div class="right">
  <p> &nbsp; &nbsp;<a href="login.php">Напред към страницата за вход!</a></p>
  
</div>
</body>
</html>
