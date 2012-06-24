-- the database schema
create table if not exists users (
  id integer primary key auto_increment,
  name varchar(500),
  surname varchar(500),
  email varchar(500),
  password varchar(500),
  address varchar(500),
  address2 varchar(500),
  city varchar(250),
  state varchar(250),
  postal varchar(250),
  country varchar(250),
  phone varchar(250),
  is_admin boolean default false,
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists submissions (
  id integer primary key auto_increment,
  paper_id integer,
  presenter_name varchar(500),
  category_id integer,
  collection_id integer,
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists papers (
  id integer primary key auto_increment,
  title varchar(500),
  abstract longtext,
  paper longblob, 
  user_id integer,   
  collection_id integer,
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists keywords (
  id integer primary key auto_increment,
  value varchar(500),
  paper_id integer,
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists coauthors (
  id integer primary key auto_increment,
  name varchar(500),
  email varchar(500),
  institution varchar(500),
  paper_id integer,
  modified timestamp default current_timestamp on update current_timestamp  
);

create table if not exists collections (
  id integer primary key auto_increment,
  title varchar(500),
  description longtext, 
  accepting_submissions boolean,
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists categories (
  id integer primary key auto_increment,
  name varchar(500),
  description longtext,
  collection_id integer,  
  modified timestamp default current_timestamp on update current_timestamp
);

create table if not exists roles (
  id integer primary key auto_increment,
  role_type_id integer,
  user_id integer,
  collection_id integer,
  modified timestamp default current_timestamp on update current_timestamp  
);

create table if not exists role_types (
  id integer primary key auto_increment,
  name varchar(200),
  description longtext, 
  modified timestamp default current_timestamp on update current_timestamp
);
