USE edenpress;

Drop view if exists VContent;
Drop view if exists VCategories;
DROP TABLE IF EXISTS User2Content;
Drop table if exists Cat2Content;
--
-- Create table for Content
--
DROP TABLE IF EXISTS Content;
CREATE TABLE Content
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  slug CHAR(80) UNIQUE,
  url CHAR(80) UNIQUE,
 
  TYPE CHAR(80),
  title VARCHAR(80),
  DATA TEXT,
  FILTER CHAR(80),
 
  published DATETIME,
  created DATETIME,
  updated DATETIME,
  deleted DATETIME
 
) ENGINE INNODB CHARACTER SET utf8;

SHOW CHARACTER SET;
SHOW COLLATION LIKE 'utf8%';

INSERT INTO Content (slug, url, TYPE, title, DATA, FILTER, published, created) VALUES
  ('hem', 'hem', 'page', 'Hem', "Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.", 'bbcode,nl2br', NOW(), NOW()),
  ('om', 'om', 'page', 'Om', "Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.", 'markdown', NOW(), NOW()),
  ('blogpost-1', NULL, 'post', 'Välkommen till min blogg!', "Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.", 'link,nl2br', NOW(), NOW()),
  ('blogpost-2', NULL, 'post', 'Nu har sommaren kommit', "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.", 'nl2br', NOW(), NOW()),
  ('blogpost-3', NULL, 'post', 'Nu har hösten kommit', "Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost", 'nl2br', NOW(), NOW())
;

DROP TABLE IF EXISTS USER;
CREATE TABLE `USER` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` char(12) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `salt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO USER (acronym, name, salt) VALUES 
  ('amanda', 'Amanda Åberg', unix_timestamp()),
  ('doe', 'John/Jane Doe', unix_timestamp())
;
 
UPDATE USER SET password = md5(concat('amanda', salt)) WHERE acronym = 'amanda';
UPDATE USER SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';

CREATE TABLE `User2Content` (
  `idUser` int(11) NOT NULL,
  `idContent` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idContent`),
  KEY `idContent` (`idContent`),
  CONSTRAINT `user2content_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `USER` (`id`),
  CONSTRAINT `user2content_ibfk_2` FOREIGN KEY (`idContent`) REFERENCES `Content` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `User2Content`
(`idUser`,
`idContent`)
VALUES
(5, 1),
(5, 2),
(6, 3),
(5, 4),
(6, 5)
;


Create view VContent AS
Select C.*, U.name AS user, U.id as Uid FROM Content C 
left join User2Content U2C on U2C.idContent = C.id
left join USER U on U2C.idUser = U.id
group by C.id;

Drop table if exists Categories;
Create table Categories
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name CHAR(20) NOT NULL 
) ENGINE INNODB CHARACTER SET utf8;

Insert into Categories (name) values
('personligt'), ('webbutveckling'), ('nyheter'), ('css'), ('php')
;

Create table Cat2Content
(
  idCat INT(11) NOT NULL,
  idContent INT(11) NOT NULL,
  Primary Key (idCat, idContent),

  FOREIGN KEY (idCat) REFERENCES Categories (id),
  FOREIGN KEY (idContent) REFERENCES Content (id)

) ENGINE INNODB CHARACTER SET utf8;

Insert into Cat2Content (idCat, idContent) values
(1, 1),
(1, 2),
(2, 3),
(5, 3),
(4, 4),
(2, 1),
(2, 4),
(2, 5),
(3, 5),
(1, 5),
(1, 4)
;

CREATE VIEW VCategories
AS
SELECT 
  C.*,
  GROUP_CONCAT(Cat.name) AS categories
FROM Content AS C
  LEFT OUTER JOIN Cat2Content AS C2C
    ON C.id = C2C.idContent
  LEFT OUTER JOIN Categories AS Cat
    ON C2C.idCat = Cat.id
GROUP BY C.id
;
