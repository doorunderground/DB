<?php
$con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
$userID= $_GET["userID"];
$ID=$_GET["ID"];
$payment=$_GET["payment"];
$request=$_GET["request"];
$price=$_GET["price"];
$delivery=$_GET["delivery"];


if($delivery=="예")
{
    $time=date("Y-m-d H:i:s");
    $sql="INSERT INTO `fbd`.`주문` (배달업체ID,고객ID, 음식점ID,생성일,수정일,요청사항 ,결제수단, 총합가격) 
    VALUES ('I1','".$userID."', '".$ID."','".$time."','".$time."','".$request."' ,'".$payment."', '".$price."')";
    $ret=mysqli_query($con,$sql);
    
    echo $time;

    if($ret)
    {
        echo "주문이 완료되었습니다!<br>";
        $sql="update 장바구니 set 주문ID = (select 주문ID from 주문 where 고객ID='".$userID."' and 음식점ID='".$ID."' and 생성일='".$time."' and 수정일='".$time."') where 주문ID is null
        ";
        $ret2=mysqli_query($con,$sql);

        if($ret2)
        {
        }
        else{echo "안돼!";}
    

    }
    else
    {
        echo "주문 실패!";
    }
}
else
{
    $sql="INSERT INTO `fbd`.`주문` (고객ID, 음식점ID,요청사항 ,결제수단, 총합가격)
    VALUES ('".$userID."', '".$ID."','".$request."' ,'".$payment."', '".$price."');";

$ret=mysqli_query($con,$sql);

    if($ret)
    {
        echo "주문이 완료되었습니다!";    
    }
    else
    {
        echo "주문 실패!";
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>

        <form method="get" action="myinformation.php">
        <input type = "hidden" name="userID" value='<?php echo $userID ?>'>
        <input type="submit" value="메인으로 돌아가기"/>
    </form>

    </body>
</html>