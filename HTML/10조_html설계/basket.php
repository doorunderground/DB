<?php
$userID= $_GET["userID"];
$menuID= $_GET["menuID"];
$ID= $_GET["ID"];

?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>

    <form method="get" action="basket_input.php">
        <img src="흑백화.PNG" alt="good_logo"width="10%" height="150px"><br>
       <h2>JMT 마라탕</h2>
        <h3>추가</h3>
        <input type="radio" name="add" value="20"/>
        알배추 1000원 
        <input type="radio" name="add" value="21"/>
        라면사리 1000원 
        <input type="radio" name="add" value="22"/>
        삼겹살 2000원 
        <input type="radio" name="add" value="18"/>
        오뎅꼬치 1000원<br>

        개수 : <input type="text" name="num" value="1"/><br>
        <input type = "hidden" name="userID" value='<?php echo $userID ?>'>
    <input type = "hidden" name="menuID" value='<?php echo $menuID ?>'>
    <input type = "hidden" name="ID" value='<?php echo $ID ?>'>
        <input type="submit" value="담기"/>
    </form>
        <?php
        echo "<br> <a href='Ras.php'><--음식점</a>";
        ?>


    </body>
</html>