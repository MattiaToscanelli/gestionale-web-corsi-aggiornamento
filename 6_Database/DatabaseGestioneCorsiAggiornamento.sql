#creazione database
DROP DATABASE IF EXISTS courses_management;
CREATE DATABASE courses_management;
USE courses_management;

#tabella per gestire gli utenti della pagina
DROP TABLE IF EXISTS user;
CREATE TABLE user(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthday DATE NOT NULL,
    zip INTEGER NOT NULL,
    city VARCHAR(50) NOT NULL,
    street VARCHAR(50) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    landline_number VARCHAR(15) DEFAULT NULL,
    flag_newsletter TINYINT(1) DEFAULT NULL,
    password VARCHAR(255) DEFAULT NULL,
    token VARCHAR(255) DEFAULT NULL,
    type INTEGER NOT NULL,
    nip VARCHAR(9) DEFAULT NULL,
    license_number VARCHAR(12) DEFAULT NULL
);

#tabella per gestire le tipologie di un corso
DROP TABLE IF EXISTS typology;
CREATE TABLE typology(
    name VARCHAR(50) PRIMARY KEY
);

#tabella per gestire le foto della pagina principale
DROP TABLE IF EXISTS photo;
CREATE TABLE photo(
    path VARCHAR(255) PRIMARY KEY
);

#tabella per gestire le impostazioni del sito
DROP TABLE IF EXISTS settings;
CREATE TABLE settings(
    iban_number VARCHAR(50) PRIMARY KEY,
    bank VARCHAR(50) NOT NULL,
    beneficiary VARCHAR(50) NOT NULL,
    day_deadline INTEGER NOT NULL,
    min_age INTEGER NOT NULL
);

#tabella per gestire le informazioni di un corso
DROP TABLE IF EXISTS course;
CREATE TABLE course(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    zip INTEGER NOT NULL,
    city VARCHAR(50) NOT NULL,
    street VARCHAR(50) NOT NULL,
    max_partecipants INTEGER NOT NULL,
    materials TEXT DEFAULT NULL,
    meal_price FLOAT(5,2) NOT NULL,
    course_price FLOAT(6,2) NOT NULL,
    name_typology VARCHAR(50) NOT NULL,
    FOREIGN KEY (name_typology) 
        REFERENCES typology(name)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

#tabella per gestire uno svolgimento di un corso
DROP TABLE IF EXISTS execution;
CREATE TABLE execution(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_user INTEGER NOT NULL,
    id_course INTEGER NOT NULL,
    start DATE NOT NULL,
    end DATE NOT NULL,
    FOREIGN KEY (id_user) 
        REFERENCES user(id)
        ON UPDATE CASCADE,
    FOREIGN KEY (id_course) 
        REFERENCES course(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

#tabella per gestire una lezione di un corso
DROP TABLE IF EXISTS lesson;
CREATE TABLE lesson(
    start DATETIME NOT NULL,
    end DATETIME NOT NULL,
    id_execution INTEGER NOT NULL,
    FOREIGN KEY (id_execution) 
        REFERENCES execution(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY(start, id_execution)
);

#tabella per gestire le iscrizioni
DROP TABLE IF EXISTS enrolls;
CREATE TABLE enrolls(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_user INTEGER NOT NULL,
    id_execution INTEGER NOT NULL,
    intolerances TEXT DEFAULT NULL,
    food_type VARCHAR(50) DEFAULT NULL,
    flag_meal TINYINT(1) NOT NULL,
    flag_paid TINYINT(1) NOT NULL,
    FOREIGN KEY (id_user) 
        REFERENCES user(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_execution) 
        REFERENCES execution(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

#creo utenti e assegno i permessi
CREATE USER 'courses_management_admin'@'localhost' IDENTIFIED WITH mysql_native_password BY 'CoursesManagement&1';
GRANT ALL ON courses_management.* TO 'courses_management_admin'@'localhost';

#Utenti (Tutte le password: Password&1, generata con http://www.passwordtool.hu/php5-password-hash-generator)
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("gestionecorsi@yopmail.com", "Mattia", "Toscanelli", "2001-03-25", 6850, "Mendrisio", "Rime 10", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 3);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("leonardo.rossi@yopmail.com", "Leonardo", "Rossi", "2000-04-25", 6780, "Airolo", "Strada", "0987654321", 1, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("francesco.ferrari@yopmail.com", "Francesco", "Ferrari", "1992-01-15", 6850, "Mendrisio", "Monte Generoso", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("lorenzo.bianchi@yopmail.com", "Lorenzo", "Bianchi", "1989-12-24", 6951, "Bogno", "Francesco Borromini", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 2);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("andrea.gallo@yopmail.com", "Andrea", "Gallo", "1964-06-12", 6900, "Lugano", "Nassa 10", "0987654321", 1, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("gabriele.esposito@yopmail.com", "Gabriele", "Esposito", "2004-11-11", 6501, "Bellinzona", "Cattedrale 2", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 0);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("riccardo.bruno@yopmail.com", "Riccardo", "Bruno", "2003-09-09", 6900, "Lugano", "Pessina 13", "0987654321", 1, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("sofia.barbieri@yopmail.com", "Sofia", "Barbieri", "1998-04-05", 6501, "Bellinzona", "Girolo 10", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 0);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("giulia.gatti@yopmail.com", "Giulia", "Gatti", "1993-03-25", 6600, "Locarno", "San Giovanni", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 2);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("alice.santoro@yopmail.com", "Alice", "Santoro", "1945-02-14", 6900, "Lugano", "Butarei 2", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("ginevra.rossetti@yopmail.com", "Ginevra", "Rossetti", "1978-07-14", 6501, "Bellinzona", "Molino Nuovo", "0987654321", 1, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq",1);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("emma.Testa@yopmail.com", "Emma", "Testa", "1976-04-16", 6900, "Lugano", "Lombrico", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 3);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("giorgia.marini@yopmail.com", "Giorgia", "Marini", "2000-05-27", 6600, "Locarno", "al gas 2", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 0);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("greta.leone@yopmail.com", "Greta", "Leone", "2007-04-12", 6710, "Biasca", "San Martino", "0987654321", 1, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 2);
INSERT INTO user (email,firstname,lastname,birthday,zip,city,street,mobile_number,flag_newsletter,password,type) 
VALUES ("beatrice.rinaldi@yopmail.com", "Beatrice", "Rinaldi", "1999-10-20", 6600, "Locarno", "Lunga", "0987654321", 0, "$2y$10$zB3yQ2u/eHsoL8lNcoBE3e02IMSkMrzsHFCu5WT5j3EN5zMIE7UVq", 1);

#aggiongo impostazioni default
INSERT INTO settings (iban_number, bank, beneficiary, day_deadline, min_age) 
VALUES ("CH8989144987444344457", "Banca", "Mattia Toscanelli", 3, 4);

#aggiungo foto
INSERT INTO photo (path) VALUES ("img/50602d31e0062071852b07097b826029903f4d5ec4db68abecefc4f658374e48.jpg");
INSERT INTO photo (path) VALUES ("img/d4a2855f2e6677eb136cee6c0957d156ab6938da57adbd8db3c70a8128b12498.jpg");

#aggiungo tipologia
INSERT INTO typology (name) VALUES ("Auto");
INSERT INTO typology (name) VALUES ("Moto");
INSERT INTO typology (name) VALUES ("Camion");
INSERT INTO typology (name) VALUES ("Revoca Patente");

#aggiungo corsi
INSERT INTO course (title, description, zip, city, street, max_partecipants, meal_price, course_price, name_typology) 
VALUES ("Corso anti sbandamento", "Corso obbligatorio patente B", 6850, "Mendrisio", "Rime 10", 4, 10, 200, "Auto");
INSERT INTO course (title, description, zip, city, street, max_partecipants, meal_price, course_price, name_typology) 
VALUES ("Corso moto Modulo 3", "Corso obbligatorio patente A", 6900, "Lugano", "Zutigo 20", 8, 0, 200, "Moto");
INSERT INTO course (title, description, zip, city, street, max_partecipants, meal_price, course_price, name_typology) 
VALUES ("Corso camionisti", "Corso obbligatorio patente C", 6501, "Bellinzona", "Verde 1", 2, 10, 200, "Camion");
INSERT INTO course (title, description, zip, city, street, max_partecipants, meal_price, course_price, name_typology) 
VALUES ("Corso Revoca Patente", "Corso per revoca della patente", 6600, "Locarno", "Francesco Borromini 2", 4, 10, 200, "Revoca Patente");

#aggiungo svolgimenti
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (4, 1, "2020-06-15","2020-06-16");
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (9, 2, "2020-06-25","2020-06-26");
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (9, 2, "2020-06-12","2020-06-14");
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (14, 3, "2020-06-12","2020-06-14");
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (4, 1, "2020-06-06","2020-06-07");
INSERT INTO execution (id_user, id_course, start, end) 
VALUES (9, 4, "2020-06-12","2020-06-12");


#aggiugo lezioni
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-15 12:00:00", "2020-06-15 14:00:00", 1);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-16 12:00:00", "2020-06-16 14:00:00", 1);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-25 12:00:00", "2020-06-25 14:00:00", 2);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-26 12:00:00", "2020-06-26 15:00:00", 2);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-12 11:00:00", "2020-06-12 14:00:00", 3);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-13 09:00:00", "2020-06-13 12:00:00", 3);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-14 12:00:00", "2020-06-14 13:00:00", 3);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-12 11:00:00", "2020-06-12 14:00:00", 4);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-13 09:00:00", "2020-06-13 12:00:00", 4);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-14 12:00:00", "2020-06-14 13:00:00", 4);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-06 12:00:00", "2020-06-06 14:00:00", 5);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-07 12:00:00", "2020-06-07 14:00:00", 5);
INSERT INTO lesson (start, end, id_execution)
VALUES ("2020-06-12 12:00:00", "2020-06-12 14:00:00", 6);

#aggiungo iscrizioni
INSERT INTO enrolls (id_user, id_execution, intolerances, food_type, flag_meal, flag_paid)
VALUES (3,1,"","",0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (5,1,0,0);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (13,2,0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (11,2,0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (10,3,0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (9,3,0,0);
INSERT INTO enrolls (id_user, id_execution, intolerances, food_type, flag_meal, flag_paid)
VALUES (8,4,"","Vegetariano",0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (7,4,0,0);
INSERT INTO enrolls (id_user, id_execution, intolerances, food_type, flag_meal, flag_paid)
VALUES (11,5,"","",0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (5,5,0,0);
INSERT INTO enrolls (id_user, id_execution, intolerances, food_type, flag_meal, flag_paid)
VALUES (11,6,"","",0,1);
INSERT INTO enrolls (id_user, id_execution, flag_meal, flag_paid)
VALUES (5,6,0,1);