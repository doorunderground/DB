<?php
$con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
   
$userID=$_GET["userID"];
$menuID=$_GET["menuID"];
$ID=$_GET["ID"];
$ADD=$_GET["add"];
$num=$_GET["num"];


if($ADD!=null)
{

    $sql="select 가격 from 메뉴옵션 where 옵션번호='".$ADD."'";
    $ret1=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($ret1);
    $option=$row['가격'];
    $sql="select 가격 from 메뉴판 where 메뉴ID='".$menuID."'";
    $ret1=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($ret1);
    $menu=$row['가격'];
    $price=$num*($menu+$option);

$sql="insert into 장바구니 (고객ID,메뉴ID,음식점ID,옵션번호,개수,총합가격) values('".$userID."','".$menuID."','".$ID."','".$ADD."','".$num."','".$price."')";
    $ret2=mysqli_query($con,$sql);
    if($ret2)
    {
$sql="select 메뉴판.메뉴이름, 메뉴옵션.옵션,메뉴옵션.내용 from 메뉴판,메뉴옵션 where 메뉴판.메뉴ID='".$menuID."' and 메뉴옵션.옵션번호='".$ADD."'";
        $ret3=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($ret3);
        echo "| ",$row['메뉴이름'], " " ,$row['옵션']," " ,$row['내용']," ";
        echo "| 장바구니에 담겼습니다!","<br>";
    }
    else
    {
        echo "담기 실패! <br>";
    } 
}
else
{
    $sql="select 가격 from 메뉴판 where 메뉴ID='".$menuID."'";
    $ret1=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($ret1);
    $menu=$row['가격'];
    $price=$num*($menu);
    $sql="insert into 장바구니 (고객ID,메뉴ID,음식점ID,개수,총합가격) values('".$userID."','".$menuID."','".$ID."','".$num."','".$price."')";
    $ret2=mysqli_query($con,$sql);
    if($ret2)
    {

        $sql="select 메뉴판.메뉴이름, 메뉴옵션.옵션,메뉴옵션.내용 from 메뉴판,메뉴옵션 where 메뉴판.메뉴ID='".$menuID."' and 메뉴옵션.옵션번호='".$ADD."'";
        $ret3=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($ret3);
        echo "| ",$row['메뉴이름'], " " ,$row['옵션']," " ,$row['내용']," ";
        echo "| 장바구니에 담겼습니다!","<br>";
}

}
?>

<IDOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<form method="get" action="Ras.php">
<input type = "hidden" name="userID" value='<?php echo $userID ?>'>
<input type = "hidden" name="ID" value='<?php echo $ID ?>'>
<input type="submit" value="음식점으로"/>
    </form>

<form method="get" action="basket_list.php">
<input type = "hidden" name="userID" value='<?php echo $userID ?>'>
<input type = "hidden" name="ID" value='<?php echo $ID ?>'>
<input type="submit" value="장바구니로"/>
    </form>
</body>
</html>