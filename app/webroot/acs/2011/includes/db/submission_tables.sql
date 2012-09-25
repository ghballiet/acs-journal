-- this file creates the tables used for paper submissions
CREATE TABLE IF NOT EXISTS paper (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT,
  abstract TEXT,
  url TEXT
);

CREATE TABLE IF NOT EXISTS submission (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT,
  surname TEXT,
  email TEXT,
  address1 TEXT,
  address2 TEXT,
  city TEXT,
  state TEXT,
  postal TEXT,
  country INTEGER,
  phone1 TEXT,
  phone2 TEXT,
  paper INTEGER,
  timestamp TEXT
);

CREATE TABLE IF NOT EXISTS keyword (
  paper INTEGER,
  word TEXT
);

CREATE TABLE IF NOT EXISTS coauthor (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT,
  email TEXT,
  institution TEXT,
  paper INTEGER
);

CREATE TRIGGER submit_timestamp AFTER INSERT ON submission
  BEGIN
    UPDATE submission SET timestamp = datetime('now','localtime') WHERE 
      ROWID = new.ROWID;
  END;