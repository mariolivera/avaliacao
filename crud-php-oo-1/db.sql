CREATE DATABASE db_escola;

USE db_escola;

CREATE TABLE tb_alunos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status TINYINT NOT NULL,
    genero VARCHAR(20) NOT NULL,
    dataNascimento DATETIME NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL
);

CREATE TABLE tb_professores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    endereco VARCHAR(45) NOT NULL,
    formacao VARCHAR(45) NOT NULL,
    status VARCHAR(45) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    cpf CHAR(11) UNIQUE NOT NULL
);


CREATE TABLE tb_user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile VARCHAR(20) NOT NULL
);
CREATE TABLE tb_curso (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    periodo VARCHAR(50) NOT NULL,
    professor VARCHAR(50) NOT NULL,
    laboratorio VARCHAR(50) NOT NULL
);



INSERT INTO tb_alunos 
(nome, matricula, email, status, genero, dataNascimento, cpf)
VALUES
('Maria', '1234123', 'maria@email.com', true, 'Feminino', '2001-09-12', '12312312312'),
('Chiquim', '4434123', 'chiquim@email.com', true, 'Masculino', '2000-12-31', '44455588812'),
('Joaquim', '5534123', 'joaquim@email.com', true, 'Não informado', '1997-06-27', '09812312390');

SELECT * FROM tb_alunos;

INSERT INTO tb_professores
(endereco, formacao, status, nome, cpf)
VALUES
('Rua barca semi nova 123', 'HTML, CSS, JS, React', true, 'Alessandro', '12345612345'),
('Rua idelfonso albano 222, ap 1403', 'SABE TUDO, BRABISSIMO', true,'Allan', '99999999999'),
('Rua oscar frança 88', 'Formado nas ruas', true,'Gleidson', '22222222222');

SELECT * FROM tb_professores;

INSERT INTO tb_cursos
(nome, periodo, professor, laboratorio)
VALUES
('php', 'manham', 'Alessandro', 'bill gates'),
('css', 'tarde','Allan', 'steav jobs'),
('javascript', 'noite','Gleidson', 'bill gates');

SELECT * FROM tb_cursos;