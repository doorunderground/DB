<?php
   $con=mysqli_connect("localhost","root","","fbd") or die("MySQL 접속 실패 !!");
   $카테고리 = $_GET["카테고리"];
   $userID=$_GET["userID"];

  $sql = 
   "
   select 음식점.*,avg(리뷰.별점) as '평점' from 음식점, 리뷰 where 리뷰.음식점ID=음식점.음식점ID and 음식점.음식점ID=any(select 음식점ID from 분류 where 카테고리='".$카테고리."') group by (음식점.음식점ID)";
   
   
$ret = mysqli_query($con,$sql);

  echo "<h1> 음식점 조회 결과 </h1>";
  echo "<TABLE border =1>" ;
  echo "<TR>";
  echo "<TH>음식점이름</TH><TH>음식점로고</TH><TH>평점</TH><TH>둘러보기</TH>";
  echo "</TR>"; 
  while($row = mysqli_fetch_array($ret))
 {
   echo "<TR>";
   echo "<TD>", $row['음식점이름'],"</TD>";
   echo "<TD>", $row['음식점로고'],"</TD>";
   echo "<TD>", $row['평점'],"</TD>";
   echo"<TD>","<a href='Ras.php?ID=",$row['음식점ID'],"&userID=",$userID,"'>둘러보기</a></TD>";
   echo "<TR>";  
  }
mysqli_close($con);
 echo "</TABLE>"; 
 echo "<br> <a href='category.php?userID=",$userID,"'> <--카테고리선택창으로</a> ";
?>