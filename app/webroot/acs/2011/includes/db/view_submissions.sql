-- view to show submissions

CREATE VIEW view_submission AS
  SELECT
    s.id AS id,
    s.name AS name,
    s.surname AS surname,
    s.email AS email,
    p.title AS title,
    p.id AS paperID,
    p.abstract AS abstract,
    p.url AS url
  FROM
    submission s,
    paper p
  WHERE
    s.paper = p.id
  ORDER BY
    s.timestamp
;