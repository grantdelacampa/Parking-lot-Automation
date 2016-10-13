--should contain [phone_number, qr_code, password]
create table user_table
{
phone_number SMALLINT,
gr_code
password int,
CHECK (LENGTH(password)>8)
}