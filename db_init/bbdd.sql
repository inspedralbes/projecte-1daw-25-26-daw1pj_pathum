SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS incidencies
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON incidencies.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

USE incidencies;

CREATE TABLE TIPO(
    idTipo INT(11) AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(200)
);

CREATE TABLE DEPARTMENT(
    idDepartment INT(11) AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(200)
);

CREATE TABLE TECNIC(
    idTecnic INT(11) AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(200)
);

CREATE TABLE INCIDENCIA(
    idIncidencia INT(11) AUTO_INCREMENT PRIMARY KEY, descripcio VARCHAR(2000),
    data TIMESTAMP, departament INT(11), tecnic INT(11), tipo INT(11),
    dataFinalitzacio TIMESTAMP, prioritat ENUM('Alta', 'Mitja', 'Baixa'),
    FOREIGN KEY (tecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY (tipo) REFERENCES TIPO(idTipo),
    FOREIGN KEY (departament) REFERENCES DEPARTMENT(idDepartment)
);

CREATE TABLE ACTUACIO(
    idActuacio INT(11) AUTO_INCREMENT PRIMARY KEY, descripcio VARCHAR(2000),
    data TIMESTAMP, temps INT(11), incidencia INT(11), visible INT(1),
    FOREIGN KEY(incidencia) REFERENCES INCIDENCIA(idIncidencia)
);