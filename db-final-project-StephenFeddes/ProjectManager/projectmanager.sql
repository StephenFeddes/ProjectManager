DROP DATABASE IF EXISTS project;
CREATE DATABASE project;

USE project;

CREATE TABLE Department(
    DepartmentID TINYINT UNSIGNED AUTO_INCREMENT,
    DepartmentName VARCHAR(35) NOT NULL UNIQUE,
    SuiteNumber SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY(DepartmentID)
);

INSERT INTO Department (DepartmentName, SuiteNumber) VALUES ('Information Technology', 102);
INSERT INTO Department (DepartmentName, SuiteNumber) VALUES ('Application Development', 102);
INSERT INTO Department (DepartmentName, SuiteNumber) VALUES ('Human Resources', 103);
INSERT INTO Department (DepartmentName, SuiteNumber) VALUES ('Customer Relations', 104);

CREATE TABLE Employee(
    EmployeeID INT UNSIGNED AUTO_INCREMENT,
    FirstName VARCHAR(35) NOT NULL,
	  LastName VARCHAR(35) NOT NULL,
    EmailAddress VARCHAR(35) NOT NULL UNIQUE CHECK(EmailAddress LIKE '%@%.___'),
    DepartmentID TINYINT UNSIGNED,
    PRIMARY KEY(EmployeeID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);


INSERT INTO Employee (FirstName, LastName, EmailAddress, DepartmentID) VALUES ('John', 'Doe', 'johndoe@gmail.com', 1);
INSERT INTO Employee (FirstName, LastName, EmailAddress, DepartmentID) VALUES ('Jane', 'Doe', 'janedoe@gmail.com', 2);
INSERT INTO Employee (FirstName, LastName, EmailAddress, DepartmentID) VALUES ('Paul', 'Garfunkle', 'pgarfunkle@hotmail.com', 3);
INSERT INTO Employee (FirstName, LastName, EmailAddress, DepartmentID) VALUES ('Art', 'Simon', 'simona@outlook.com', 4);

CREATE TABLE Project(
  ProjectID SMALLINT UNSIGNED AUTO_INCREMENT,
  ProjectName VARCHAR(35) NOT NULL UNIQUE,
  PatronCompanyName VARCHAR(35) DEFAULT 'SoftCo',
  Budget DECIMAL(10,2) NOT NULL,
  DueDate DATE NOT NULL,
  PRIMARY KEY (ProjectID)
);


INSERT INTO Project (ProjectName, PatronCompanyName, Budget, DueDate) VALUES ('HR_Network', "SoftCo", 2000.00, '2023-05-14');
INSERT INTO Project (ProjectName, PatronCompanyName, Budget, DueDate) VALUES ('Bank_App', "BankCo", 90000.00, '2024-01-01');
INSERT INTO Project (ProjectName, PatronCompanyName, Budget, DueDate) VALUES ('2023_Summer_Hires', "SoftCo", 5000, '2023-09-22');


CREATE TABLE EmployeeProject(
  ProjectID SMALLINT UNSIGNED,
  EmployeeID INT UNSIGNED,
  PRIMARY KEY(ProjectID, EmployeeID),
  FOREIGN KEY (ProjectID) REFERENCES Project(ProjectID)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  FOREIGN KEY (EmployeeID) REFERENCES Employee(EmployeeID)
  ON UPDATE CASCADE
  ON DELETE CASCADE
);

INSERT INTO EmployeeProject (ProjectID, EmployeeID) VALUES (1,1);
INSERT INTO EmployeeProject (ProjectID, EmployeeID) VALUES (2,2);
INSERT INTO EmployeeProject (ProjectID, EmployeeID) VALUES (2,4);
INSERT INTO EmployeeProject (ProjectID, EmployeeID) VALUES (3,3);


CREATE INDEX project_name_ix ON Project (ProjectName); --Used a lot in the queries
CREATE INDEX department_name_ix ON Department (DepartmentName); --Frequently used in queries
CREATE INDEX employee_email_ix ON Employee (EmailAddress); --Frequently queried, always unique, rarely changed
CREATE INDEX employee_firstname_ix ON Employee (FirstName); --Frequently used in queries
CREATE INDEX employee_lastname_ix ON Employee (LastName); --Frequently used in queries

CREATE USER planner@localhost IDENTIFIED BY 'coolproject';

GRANT SELECT, INSERT, UPDATE, DELETE
ON project.* TO planner@localhost;