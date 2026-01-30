<?php
   $con = mysqli_connect("localhost", "root", "", "fbd") or die("MySQL 접속 실패");
   
   $sql  = "SELECT * FROM 음식점";
   
   $ret = mysqli_query($con, $sql);

   if($ret) {
      $count = mysqli_num_rows($ret);
   }
   else {
      echo "userTBl 조회 실패". "<br>";
      echo "실패 원인 :".mysqli_error($con);
      exit();
   }
   $ID=$_GET["ID"];
   $userID=$_GET["userID"];
?>

<!DOCTYPE html>
<html>
<body>

<img src="logo.png" alt="food_logo" width="18%" height="150px" > 

<h1>&emsp;&emsp;&emsp;&nbsp;주문확인</h1>
<p>&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp; 소림마라(영남대점)</p> 

<div class="star-ratings">    
<div
    class="star-ratings-fill space-x-2 text-lg"
    :style="{ width: ratingToPercent + '%' }"
   >
   <span style="color:red">영업중</span> &emsp;&emsp;&emsp;&emsp;&nbsp;<span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
</div>
 
<hr align="left" style="border: solid 5px black; width: 20%">

<h5>소개 : 안녕하세요. 저희는 소림마라[영남대점]입니다. <br>
      &emsp;&emsp;&emsp;최고의 맛 최고의 서비스로 대접하도록 하겠습니다. </h5>
<h5>최소주문금액 : &nbsp;12,000원 </h5>
<h5>전화번호 : &nbsp;05312341234 </h5> 
<h5>위치 : &nbsp;경상북도 경산시 조용동 580-15 </h5>
<h5>영업시간 : &nbsp;10:30 ~ 24:00 </h5> 
<h5>평균배달시간 : &nbsp;40~50분 소요 예상 </h5>

<h3>
<tr>
 <table border="2">
    <th>&emsp;&emsp;&emsp;&emsp;메뉴&emsp;&emsp;&emsp;&emsp;</th>
    <th><a href = "review.php">&emsp;&emsp;&emsp;&emsp;리뷰&emsp;&emsp;&emsp;&emsp; </a></th>
</table>
</tr>
</h3>


<br>
<h3>

<form method="get" action="basket.php">
<input type = "hidden" name="userID" value=<?php echo $userID ?>>
    <input type = "hidden" name="ID" value=<?php echo $ID ?>>
    <input type = "hidden" name="menuID" value='R1-1'>
<input type="image" src="흑백화.png" alt="food_logo" width="8%" height="150px"/>
</form>
<br>JMT 마라탕 12000원<br>
<form method="get" action="basket.php">
<input type = "hidden" name="userID" value=<?php echo $userID ?>>
    <input type = "hidden" name="ID" value=<?php echo $ID ?>>
    <input type = "hidden" name="menuID" value='R1-2'>
<input type="image" src="흑백화.png" alt="food_logo" width="8%" height="150px"/>
<br>JMT 마라샹궈 15000원~25000원<br>
</form>
<form method="get" action="basket.php">
<input type = "hidden" name="userID" value=<?php echo $userID ?>>
    <input type = "hidden" name="ID" value=<?php echo $ID ?>>
    <input type = "hidden" name="menuID" value='R1-3'>
<input type="image" src="흑백화.png" alt="food_logo" width="8%" height="150px"/>
<br>JMT 꿔바로우 18000원<br>
</form>
</h3> <br>




</body>
</html>