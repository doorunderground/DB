<?php
$con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
$userID= $_GET["userID"];
$ID=$_GET["ID"];
$price=0;
$sql="select 고객.이름,음식점.음식점이름,sum(장바구니.총합가격) as '총합가격'
from 장바구니,고객,음식점
where 장바구니.고객ID='".$userID."' and 음식점.음식점ID=장바구니.음식점ID and 고객.고객ID='".$userID."'
group by(고객.이름)";
$ret=mysqli_query($con,$sql);
$row=mysqli_fetch_array($ret);
$prince=$row["총합가격"];
$R_name=$row["음식점이름"];
$U_name=$row["이름"];
?>

<IDOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
  음식점 :  <?php  echo $R_name,"<br>";?>
  <form method="get" action="order_input.php">
  요청사항 : <input type = "text" name ="request"> <br>
  결제수단 : <select name= "payment" size="1">
              <option>간편결제</option> <option>카드</option> 
              <option>현금</option> 
</select>
  배달여부 : <select name= "delivery" size="1">
              <option>예</option> <option>아니요</option> 
</Select>

<?php

$sql="select 장바구니.장바구니ID,메뉴판.메뉴이름,메뉴옵션.옵션,메뉴옵션.내용,장바구니.개수,장바구니.총합가격 from 메뉴판,메뉴옵션,장바구니 where 메뉴판.메뉴ID=장바구니.메뉴ID and 장바구니.옵션번호=메뉴옵션.옵션번호 and 고객ID='".$userID."'";
$ret=mysqli_query($con,$sql);

echo "<TABLE border=1>";
echo "<TR>";
echo "<TH>메뉴이름</TH><TH>옵션</TH><TH>내용</TH><TH>개수</TH><TH>총합가격</TH>";
echo"</TR>";

while($row=mysqli_fetch_array($ret))
{
    echo"<TR>";
    echo"<TD>",$row['메뉴이름'],"</TD>";
    echo"<TD>",$row['옵션'],"</TD>";
    echo"<TD>",$row['내용'],"</TD>";
    echo"<TD>",$row['개수'],"</TD>";
    echo"<TD>",$row['총합가격'],"</TD>";
    $price+=$row['총합가격'];
}
mysqli_close($con);
echo"</TABLE>";
?>

총합가격 : <?php echo $price ?>원 <br>

 <input type = "hidden" name="userID" value='<?php echo $userID ?>'>
 <input type = "hidden" name="ID" value='<?php echo $ID ?>'>
  <input type = "hidden" name="price" value='<?php echo $price ?>'>
<input type='submit' value='주문하기'>
</form>
</body>
</html>