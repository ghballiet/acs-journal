-- the database schema
create table if not exists users (
  id integer primary key auto_increment,
  name varchar(500),
  surname varchar(500),
  email varchar(500),
  password varchar(500),
  institution varchar(500),
  address varchar(500),
  address2 varchar(500),
  city varchar(250),
  state varchar(250),
  postal varchar(250),
  country varchar(250),
  phone varchar(250),
  is_admin boolean default false,
  notify_of_new_user boolean default false,
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
  next_submission integer,
  locked boolean default false,
  slug varchar(500),
  pages integer,
  retracted boolean default false,
  order integer,
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
  subtitle varchar(500),
  volume varchar(250),
  description longtext, 
  accepting_submissions boolean,
  max_submissions_per_reviewer integer default 3, 
  min_reviews_per_paper integer default 3,
  slug varchar(500),
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
  max_reviews integer default 3,
  modified timestamp,
  created timestamp  
);

create table if not exists role_types (
  id integer primary key auto_increment,
  name varchar(200),
  description longtext, 
  can_review boolean default false,
  can_edit boolean default false,
  can_assign boolean default false,
  can_manage boolean default false,
  modified timestamp,
  created timestamp
);

create table if not exists review_forms (
  id integer primary key auto_increment,
  collection_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists questions (
  id integer primary key auto_increment,
  text longtext,
  review_form_id integer,
  position integer,
  modified timestamp,
  created timestamp
);

create table if not exists choices (
  id integer primary key auto_increment,
  text longtext,
  question_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists reviews (
  id integer primary key auto_increment,
  user_id integer,
  submission_id integer,
  review_form_id integer,
  modified timestamp,
  created timestamp
);

create table if not exists answers (
  id integer primary key auto_increment,
  question_id integer,
  choice_id integer,
  user_id integer,
  review_id integer,
  review_form_id integer,
  comments longtext,
  modified timestamp,
  created timestamp
);

create table if not exists metareviews (
  id integer primary key auto_increment,
  content longtext,
  question_id integer,
  choice_id integer,  
  submission_id integer,
  user_id integer,
  collection_id integer,
  modified timestamp,
  created timestamp
);
