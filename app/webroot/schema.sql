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
  modified timestamp,
  created timestamp
);

create table if not exists submissions (
  id integer primary key auto_increment, 
  title varchar(500), 
  abstract longtext,
  current_version integer,
  final_version integer,
  previous_submission integer,
  locked boolean default false,
  category_id integer,
  collection_id integer, 
  user_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists uploads (
  id integer primary key auto_increment,
  name varchar(500),
  type varchar(500),
  size bigint,
  content longblob,
  extension varchar(10),
  user_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists keywords (
  id integer primary key auto_increment,
  value varchar(500),
  submission_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists coauthors (
  id integer primary key auto_increment,
  name varchar(500),
  email varchar(500),
  institution varchar(500),
  submission_id integer,
  modified timestamp,
  created timestamp  
);

create table if not exists collections (
  id integer primary key auto_increment,
  title varchar(500),
  description longtext, 
  accepting_submissions boolean,
  modified timestamp,
  created timestamp
);

create table if not exists categories (
  id integer primary key auto_increment,
  name varchar(500),
  description longtext,
  collection_id integer,  
  modified timestamp,
  created timestamp
);

create table if not exists roles (
  id integer primary key auto_increment,
  role_type_id integer,
  user_id integer,
  collection_id integer,
  modified timestamp,
  created timestamp  
);

create table if not exists role_types (
  id integer primary key auto_increment,
  name varchar(200),
  description longtext, 
  modified timestamp,
  created timestamp
);
