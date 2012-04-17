-- the database schema
create table users (
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
  created timestamp,
  role_id integer,
  modified timestamp on update current_timestamp
);

create table roles (
  id integer primary key auto_increment,
  name varchar(250), 
  description longtext, 
  created timestamp,
  modified timestamp on update current_timestamp
);

create table submissions (
  id integer primary key auto_increment,
  paper_id integer,
  presenter_name varchar(500),
  created timestamp,
  modified timestamp on update current_timestamp
);

create table papers (
  id integer primary key auto_increment,
  title varchar(500),
  abstract longtext,
  paper longblob, 
  user_id integer, 
  created timestamp,
  modified timestamp on update current_timestamp
);

create table keywords (
  id integer primary key auto_increment,
  value varchar(500),
  paper_id integer,
  created timestamp,
  modified timestamp on update current_timestamp
);

create table coauthors (
  id integer primary key auto_increment,
  name varchar(500),
  email varchar(500),
  institution varchar(500),
  paper_id integer,
  created timestamp,
  modified timestamp on update current_timestamp  
);

create table collections (
  id integer primary key auto_increment,
  title varchar(500),
  description longtext, 
  accepting_submissions boolean,
  created timestamp,
  modified timestamp on update current_timestamp
);

create table collections_submissions (
  id integer primary key auto_increment,
  collection_id integer,
  submission_id integer,
  created timestamp,
  modified timestamp on update current_timestamp
);

create table categories (
  id integer primary key auto_increment,
  name varchar(500),
  description longtext,
  created timestamp,
  modified timestamp on update current_timestamp
);

create table categories_submissions (
  id integer primary key auto_increment,
  category_id integer,
  submission_id integer,
  created timestamp,
  modified timestamp on update current_timestamp
);