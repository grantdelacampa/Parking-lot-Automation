--should contain [id, floor, area, spot, is_taken, user_phone_number]
create table parking_spot
{
  id SMALLINT not null UNIQUE ,
  floor SMALLINT not null,
  area  smallint not null,
  spot smallint not null,
  is_taken bit not null check (is_taken=1 OR is_taken=0),
  user_phone_number smallint NOT NULL CHECK (LENGTH(user_phone_number)>=1000000000),
}