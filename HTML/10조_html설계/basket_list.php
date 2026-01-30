<?php
$con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
   
$userID=$_GET["userID"];

$sql="select 장바구니.장바구니ID,메뉴판.메뉴이름,메뉴옵션.옵션,메뉴옵션.내용,장바구니.개수,장바구니.총합가격 from 메뉴판,메뉴옵션,장바구니 where 메뉴판.메뉴ID=장바구니.메뉴ID and 장바구니.옵션번호=메뉴옵션.옵션번호 and 고객ID='".$userID."'";
$ret=mysqli_query($con,$sql);

echo "<h1> 장바구니 </h1>";
echo "<TABLE border=1>";
echo "<TR>";
echo "<TH>메뉴이름</TH><TH>옵션</TH><TH>내용</TH><TH>개수</TH><TH>총합가격</TH><TH>취소</TH>";
echo"</TR>";
while($row=mysqli_fetch_array($ret))
{
    echo"<TR>";
    echo"<TD>",$row['메뉴이름'],"</TD>";
    echo"<TD>",$row['옵션'],"</TD>";
    echo"<TD>",$row['내용'],"</TD>";
    echo"<TD>",$row['개수'],"</TD>";
    echo"<TD>",$row['총합가격'],"</TD>";
    echo"<TD>","<a href='basket_delete.php'장바구니ID=",$row['장바구니ID'],">삭제</a></TD>";
}

mysqli_close($con);
echo"</TABLE>";
$userID=$_GET["userID"];
$ID=$_GET["ID"];
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
    <form method="get" action="order_by_user.php">
<input type = "hidden" name="userID" value='<?php echo $userID ?>'>
<input type = "hidden" name="ID" value='<?php echo $ID ?>'>
<input type="submit" value="주문하기"/>
    </form>
</body>
</html>
