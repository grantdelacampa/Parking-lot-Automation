--should contain [ts_start, ts_end, user_phone_number, money]
CREATE TABLE parking_journal
{
ts_start TIME ,
ts_end TIME ,
user_phone_number INT NOT NUll CHECK (LENGTH(user_phone_number)>=1000000000),
money SMALLINT ,
}