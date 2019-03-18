select * from person1 where id=5;
select * from person1 where id=5 or id=7;
select * from person1 where name like '吳%';
select * from person1 where address like'%岡山鎮';
select * from person1 where mid(birthday,6,2) in ('02','05','07');

select * from person1 where month(birthday) in ('02','05','07');
select * from person1 where month(birthday) >=3 and month(birthday) <=8

use trydb;
select * from person1 where id=5;
select * from person1 where name like '吳%'  or name like '徐%';
SELECT * FROM person1 where name like '吳%' and address like '%岡山鎮';
SELECT * FROM person1 where address like '%市%';
SELECT * FROM person1 where year(birthday)>=1976 and year(birthday)<=1978;
select * from person1 where month(birthday) in ('2','5','7','11','12');
select * from person1 limit  5,5;
select * from person1 order by birthday limit 5;
select * from person1 WHERE address not like '高雄%';
select * from person1 order by rand() limit 1;