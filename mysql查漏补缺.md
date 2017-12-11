### mysql查询时间戳数据格式转换：
`SELECT *, FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') FROM tables`

### mysql获取两个时间戳天数差
```mysql
select
TimeStampDiff(day,from_unixtime(date1,'%Y-%m-%d'),from_unixtime(date2,'%Y-%m-%d'))
from table
```
### mysql 时间天数差
```
select datediff('2008-08-08 12:00:00', '2008-08-01 00:00:00');
```

### mysql 保留两位小数
` select round(number,2) from table`

### mysql 时间加天数
```mysql
select timestampadd(day, 1, '2008-08-08 08:00:00'); -- 2008-08-09 08:00:00
select date_add('2008-08-08 08:00:00', interval 1 day); -- 2008-08-09 08:00:00
```

### mysql保留小数，不四舍五入直接截去小数后部分
`TRUNCATE(X,D)`
[https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_truncate](https://dev.mysql.com/doc/refman/5.7/en/mathematical-functions.html#function_truncate)


