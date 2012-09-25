create table if not exists user (
  id integer primary key autoincrement,
  first_name text,
  last_name text,
  email text,
  password text
);

create table if not exists topic (
  id integer primary key autoincrement,
  name text,
  description text
);

create table if not exists author (
  id integer primary key autoincrement,
  first_name text,
  last_name text,
  email text
);

create table if not exists application (
  id integer primary key autoincrement,
  first_name text,
  last_name text,
  email text,
  organization text,
  address text,
  city text,
  state text,
  postal text,
  country_id integer,
  summary text,
  paper text,
  timestamp text
);  

-- create triggers here

create trigger apply_timestamp after insert on application
begin
  update application set timestamp = datetime('now','localtime') where rowid = new.rowid;
end;