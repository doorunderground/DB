<?php
$userID= $_GET["userID"];
?>
<!DOCTYPE html>
<html>
<HEAD>
<META http-eqoipv="contsnt-type" content=text/html; charset="utf-8">
</HEAD>

<BODY>
<h3> Select 카테고리 </h3>
<form method ="get" action="menu_search.php">
<div class="search">
     메뉴검색: <input type="text" name="메뉴" placeholder="search" />
                  <input type='submit' value='조회'>
</div>
</form>
<br>
<script> 
  function submit2(frm) { 
    frm.action="category_R2.php"; 
    frm.submit(); 
    return true; 
  } 
</script>
<form method="get" action="category_R.php">
  <div class="search">
  카테고리: <select name= "카테고리" size="1">
              <option>양식</option> <option>한식</option> 
              <option>중식</option> <option>일식</option>
              <option>디저트</option> <option>아시안</option>
              <option>분식</option> <option>패스트푸드</option>
              <option>야식</option>
         </select>
         <input type = "hidden" name="userID" value='<?php echo $userID ?>'>
<input type='submit' value='조회'>
<input type='submit' value='별점순조회' onclick='return submit2(this.form);'>
</form>
</body>
</html>