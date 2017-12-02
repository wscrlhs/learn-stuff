### mysql查询时间戳数据格式转换：
`SELECT *, FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') FROM tables`

### mysql获取两个时间戳天数差
```mysql
select
TimeStampDiff(day,from_unixtime(date1,'%Y-%m-%d'),from_unixtime(date2,'%Y-%m-%d'))
from table
```

### mysql 保留两位小数
` select round(number,2) from table`

