use fbd;

-- my정보 확인부분
create view v_address as 
select 도로명 from 주소 where ID = (select 고객ID from 고객 where 고객ID = 'U1')and 대표주소여부 = '우리집'; -- 우리집에 맞는 도로명 주소view
select * from 고객, v_address where 고객ID = 'U1';

-- --------------------------------------------------------------------------------------
/*고객*/

create view v_serch as
select 도로명 from 주소 where ID ='U4' and 대표주소여부 ='우리집';
-- 해당 ID의 대표주소여부를 활용하여 해당 ID의 소유자에게 정보를 출력함.

create view v_find as
select 음식점ID from 배달가능 where 도로명 = (select 도로명 from v_serch);
 -- 배달가능 테이블을 활용하여 지정된 도로명에 배달이 가능한 음식점을 뷰로 생성함.
 
-- 카테고리 상관없이 배달 가능한 음식점 구하기
create view v_store as 
select 음식점이름, 평균배달시간, 최소배달금액, 음식점로고 from 음식점 where 음식점ID = any (select 음식점ID from v_find);

-- 배달 가능한 음식점 중 검색기능
create view v_search as
select 음식점이름, 평균배달시간, 최소배달금액, 음식점로고 from v_store where 음식점이름 like '%한식%';

-- 메뉴로 검색
create view v_store_search as
select 음식점ID from 메뉴판 where 메뉴이름 like '라%' and 음식점ID=any(select 음식점ID from v_find);

-- 선택한 음식점의 메뉴 리스트 출력
create view v_menu_list as
select 메뉴판.메뉴이름, 메뉴판.가격, 메뉴판.소개, 메뉴판.사진 from 메뉴판 where 메뉴판.음식점ID='R1';

-- 선택한 메뉴의 옵션 리스트 출력
create view v_menu_option_list as
select 메뉴옵션.옵션번호, 메뉴옵션.옵션, 메뉴옵션.가격, 메뉴옵션.내용 from 메뉴옵션 where 메뉴옵션.메뉴ID='R1-1';

-- 아래 코드들은 평점을 계산하여 가게를 평점순으로 나열하는 과정에 해당함.
create view v_ava as
select 음식점ID,avg(별점) as '평점' from 리뷰 group by 음식점ID;
select * from v_AVA;
-- 음식점 ID별로 평점 계산

create view v_order_point as 
select 음식점.*, v_AVA.평점 from 음식점,v_AVA where 음식점.음식점ID=v_AVA.음식점ID;
--  음식점과 평점을 연결해서 생성.
select * from v_order_point order by 평점 desc;
-- 음식점을 평점을 기준으로 정렬(내림차순)

 select * from v_order_point where 음식점ID = any(select 음식점ID from v_find) and 개점여부 = '영업중' order by 평점 desc;
 
 drop view v_serch;
 drop view v_find;
 drop view v_ava;
 drop view v_order_point;

-- ---------------아래코드는 장바구니를 생성하는 쿼리에 해당함---------------------------------

create view v_option_price as
select 옵션번호,가격 from 메뉴옵션 where 옵션번호 = '7' and 메뉴ID='R2-1';
-- UI를 통해서 입력받은 옵션번호와 메뉴ID를 파악하여 옵션 가격을 뷰로 생성함.

create view v_menu_price as
select 가격 from 메뉴판 where 메뉴ID='R2-1';
-- 해당 메뉴의 가격을 뷰로 생성함 입력받은 ID를 활용함.

create view v_sum as
select (v_option_price.가격 + v_menu_price.가격)*1 as '총합가격' from v_option_price, v_menu_price;
-- 옵션을 포함한 가격을 뷰로 생성함, 개수는 UI를 통해서 입력받을 것.

insert into 장바구니 (고객ID,메뉴ID,음식점ID,옵션번호,개수,총합가격) values('U1','R2-1','R2','7','2',(select 총합가격 from v_sum));
-- 생성된 정보를 통해서 장바구니에 입력함.
-- 장바구니 생성, 주문ID는 없음.

drop view v_menu_price;
drop view v_option_price;
drop view v_sum;

-- ---------------아래 코드는 주문을 행하는 과정에 해당하는 쿼리---------------------------------

INSERT INTO `fbd`.`주문` (`고객ID`, `음식점ID`, `결제수단`, `생성일`, `수정일`, `총합가격`) VALUES ('U1', 'R2', '카드', current_timestamp(), current_timestamp(), '1');
update 장바구니 set 주문ID = (select 주문ID from 주문 where 고객ID='U1' and 음식점ID='R2' and 생성일=current_timestamp() and 수정일=current_timestamp())where 주문ID is null;

create view v_price as
select 주문ID,sum(총합가격) as '총합가격' from 장바구니 group by 주문ID having 주문ID=2; 
-- 해당 주문번호에 대한 총합가격을 생성한다.

update 주문 set 총합가격 = (select 총합가격 from v_price),수정일=current_timestamp() where 주문ID=(select 주문ID from v_price);

drop view v_price;


-- --------------------------------------------------------------------------------------
/*사장님*/

update 메뉴판 set 가격 = 5000 where 메뉴이름 = '국수' and 음식점ID='R1'; -- 메뉴 가격 조정 , 음식점ID를 지정해주지 않으면 같은 이름을 가진 메뉴가 전부 가격잉 변경됨.

delete from 메뉴판 where 메뉴ID= 'R4-3'; -- 메뉴삭제 잘 됨, R4-3 과 관련된 메뉴옵션 테이블들도 삭제되는 것이 확인됨.

update 리뷰 set 사장님말씀 = '감사합니다. 맛있게 드세요!!' where 음식점ID='R1' ; -- 사장님 답글달기, 특정 사장님이 사용하는 것이므로 음식점ID를 지정해야함 
 
update 리뷰 set 사장님말씀 = '죄송합니다. 더 노력하겠습니다.' where 별점 <= 2 and 음식점ID='R1'; -- 사장님 답글달기, 위와 동일

create view v_today_order as
select * from 주문 where 음식점ID = 'R1' and 수정일 = curdate();-- R1식당에 오늘 주문한 고객
 
create view v_review as
select 고객ID,내용,음식점ID from 리뷰 where 고객ID = v_today_order.고객ID and 음식점ID = 'R1'; 
  
select *from v_review; -- k_1식당에 오늘 주문한 고객중 리뷰를 쓴 사람을 알기위함 

delete from 리뷰 where 별점 = 1 and 음식점ID='R1'; -- 악의적인 리뷰 삭제, 사장 본인의 가계와 관련된 리뷰만 삭제가능.

drop view v_today_order;
drop view v_review;

-- 음식점 당일 정산 -> 형식 변경시 당일/월/년 정산 가능
create view v_total as
select 주문.음식점ID,date_format(생성일,'%y-%m-%d')  as '당월', sum(총합가격) as '총가격' from 주문 
where 음식점ID='R1' and date_format(생성일,'%y-%m-%d')=curdate();

-- ------------------사장이 주문을 관리하는 경우------------------
select * from 주문 where 음식점ID = 'R1' order by 생성일;
-- 사장님은 음식점에 주문을 확인할 수 있음.

update 주문 set 주문상태 = '조리중' where 주문ID = '1';
-- 확인한 주문들 중에서 원하는 주문을 접수할 수 있음, 클릭하면 조리중이됨 -> 원하는 주문을 받는다. 

select * from 주문;

-- 음식점별 일별주문 관리
select * from 주문 where 음식점ID = 'k_1' and date_format(생성일,'%y-%m-%d')=date_format('20221112','%y-%m-%d') order by 주문ID;


-- --------------------------------------------------------------------------------------
/*배달원*/

create view v_address as 
select 도로명, ID from 주소 where ID = (select 고객ID from 고객 where 고객ID = 'U1')and 대표주소여부 = '우리집'; -- 우리집에 맞는 도로명 주소view
  
create view v_delivery_complete as
select 주문상태, 주문ID, 음식점ID, v_address.도로명 from 주문, v_address where 주문상태 = '배달완료'; 

-- -----------------배달원이 배달을 하는 경우----------------------
select * from 주문 where 배달업체ID = 'I1';
-- 배달원은 본인이 속한 배달업체에 할당된 배달 중 대기중인 배달을 확인할 수 있음.

update 주문 set 배달 = '배달중' where 주문ID='1'; 
update 주문 set 주문상태 = '픽업완료' where 주문ID='1'; 

create view v_delivery_complete as
select 배달, 주문ID, 음식점ID, v_address.도로명 from 주문, v_address where 배달 = '배달완료'; 
select * from v_delivery_complete; 
-- 배달완료된 주문의 주문ID와 음식점ID, 주소를 보여줌 

select concat(count(*),'건') as '배달건수' from 주문 WHERE 주문상태 = '배달중';
select concat(count(*),'건') as '배달건수' from 주문 WHERE 배달 = '배달완료';
-- 배달중, 배달완료된 건수를 확인할 수 있음 