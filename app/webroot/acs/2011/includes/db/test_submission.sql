SELECT * FROM paper;
SELECT * FROM coauthor;
SELECT * FROM submission;
SELECT * FROM keyword;

DELETE FROM paper WHERE id>0;
DELETE FROM coauthor WHERE id>0;
DELETE FROM submission WHERE id>0;
DELETE FROM keyword WHERE paper>0;