-- sql file to get those applicants that we should bug
.mode list

SELECT DISTINCT
  a.first_name || ' ' || a.last_name || ' <' || a.email || '>,'
FROM
  application a,
  (SELECT id, first_name || last_name AS name
   FROM application) b
WHERE
      a.id = b.id
  AND b.name NOT IN(SELECT first_name || last_name FROM attendance)
ORDER BY
  last_name, first_name, email
;