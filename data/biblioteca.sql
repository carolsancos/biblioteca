CREATE DATABASE IF NOT EXISTS biblioteca;
 
USE biblioteca;

CREATE TABLE autor(
   id_autor int not null auto_increment primary key,
   nombre varchar(255) not null
) ENGINE=InnoDB;

CREATE TABLE libro(
   id_libro int not null auto_increment primary key,
   titulo varchar(255) not null,
   fecha_edicion date not null
) ENGINE=InnoDB;


CREATE TABLE autor_libro(
   id_autor integer,
   id_libro integer,
   Primary Key (id_autor,id_libro), 
   Foreign Key (id_autor) REFERENCES autor(id_autor),
   Foreign Key (id_libro) REFERENCES libro(id_libro)
) ENGINE=InnoDB;

INSERT INTO LIBRO (titulo, fecha_edicion) VALUES ('El Principito', '1943-9-20');
INSERT INTO LIBRO (titulo, fecha_edicion) VALUES ('Anna Karenina', '1877-1-01');
INSERT INTO LIBRO (titulo, fecha_edicion) VALUES ('Good Omens', '1655-1-01');
INSERT INTO LIBRO (titulo, fecha_edicion) VALUES ('Regreso a Twin Peaks', '2017-1-01');


INSERT INTO AUTOR (nombre) VALUES ('Antoine de Saint Exupéry');
INSERT INTO AUTOR (nombre) VALUES ('León Tolstói');
INSERT INTO AUTOR (nombre) VALUES ('Neil Gaiman');
INSERT INTO AUTOR (nombre) VALUES ('Terry Pratchett');
INSERT INTO AUTOR (nombre) VALUES ('David Lynch');
INSERT INTO AUTOR (nombre) VALUES ('Nacho Vigalongo');
INSERT INTO AUTOR (nombre) VALUES ('Michel Chion');
INSERT INTO AUTOR (nombre) VALUES ('Enric Ros');
INSERT INTO AUTOR (nombre) VALUES ('Raquel Crisóstomo');


INSERT INTO autor_libro (id_autor, id_libro)
SELECT a.id_autor, l.id_libro
FROM autor AS a
CROSS JOIN libro AS l
WHERE a.nombre = 'Antoine de Saint Exupéry'
AND l.titulo = 'El Principito';

INSERT INTO autor_libro (id_autor, id_libro)
SELECT a.id_autor, l.id_libro
FROM autor AS a
CROSS JOIN libro AS l
WHERE a.nombre = 'León Tolstói'
AND l.titulo = 'Anna Karenina';

INSERT INTO autor_libro (id_autor, id_libro)
SELECT a.id_autor, l.id_libro
FROM autor AS a
CROSS JOIN libro AS l
WHERE a.nombre = 'Neil Gaiman'
AND l.titulo = 'Good Omens';

INSERT INTO autor_libro (id_autor, id_libro)
SELECT a.id_autor, l.id_libro
FROM autor AS a
CROSS JOIN libro AS l
WHERE a.nombre = 'Terry Pratchett'
AND l.titulo = 'Good Omens';

INSERT INTO autor_libro (id_autor, id_libro)
SELECT a.id_autor, l.id_libro
FROM autor AS a
CROSS JOIN libro AS l
WHERE a.nombre = 'David Lynch'
AND l.titulo = 'Regreso a Twin Peaks';

