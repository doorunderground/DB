<?php
 $con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
$userID = $_GET["userID"];
$pwd = $_GET["pwd"];
$sql = "SELECT * from 고객 where 고객ID ='$userID' and  비밀번호 ='$pwd'";
$ret = mysqli_query($con,$sql);

echo "<h1> My정보 </h1>";
echo "<TABLE border =1>" ;
echo "<TR>";
echo "<TH>고객이름</TH><TH>고객ID</TH><TH>휴대폰번호</TH><TH>등급</TH><TH>생성일</TH><TH>수정일</TH><TH>계정상태</TH><TH>고객유형</TH>";
echo "</TR>"; 
while($row = mysqli_fetch_array($ret))
{
echo "<TR>";
echo "<TD>", $row['이름'],"</TD>";
echo "<TD>", $row['고객ID'],"</TD>";
echo "<TD>", $row['휴대폰번호'],"</TD>";
echo "<TD>", $row['등급'],"</TD>";
echo "<TD>", $row['생성일'],"</TD>";
echo "<TD>", $row['수정일'],"</TD>";
echo "<TD>", $row['계정상태'],"</TD>";
echo "<TD>", $row['고객유형'],"</TD>";
echo "<TR>";  
}
mysqli_close($con);
echo "</TABLE>"; 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
    </head>
    <body>

        <form method="get" action="category.php">
        <input type = "hidden" name="userID" value='<?php echo $userID ?>'>
        <input type="submit" value="주문시작하기"/>
    </form>

    </body>
</html>