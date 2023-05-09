<style>
   ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
      
}

 li {
    float: left;
    display: inline;
     width: 320px;
     height: 50px;
     font-size: 22px;
}

ul a:link, ul a:visited {
    display: block;
    width: 320px;
    font-family:Verdana, Geneva, sans-serif, bold;
    font-size: 60%;
    color: #FFFFFF;
    background-color: #817476;
    text-align: center;
    padding: 4px;
    text-decoration: none;
    text-transform: uppercase;
    
}

ul a:hover, ul a:active {
    background-color: #9bb7df;
}
</style>
<ul>
            <li  id="liMenu"><a href="index.php">Начало                   </a></li>
            <li id="liMenu" ><a href="userPage.php" id>Профил            </a></li>
            <?php if(isset($_SESSION['username'])) echo  "<li id=\"liMenu\"><a href=\"logout.php\">Изход </a></li>";
            else{
              echo"
             <li id=\"liMenu\" color=\"red\"><a href=\"login.php\" id>Вход            </a></li>
              <li id=\"liMenu\" color=\"red\"><a href=\"registration_1.php\" id>Регистрация            </a></li>";
            }
            ?>
            
</ul>




