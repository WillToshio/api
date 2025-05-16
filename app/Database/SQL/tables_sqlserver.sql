
DROP TABLE IF EXISTS users_logs;
DROP TABLE IF EXISTS users_project;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id UNIQUEIDENTIFIER PRIMARY KEY,
    name NVARCHAR(128),
    age INT,
    score INT,
    active BIT,
    country NVARCHAR(64),
    team_name NVARCHAR(128),
    team_leader BIT
)

CREATE TABLE users_logs(
    id INT IDENTITY(1,1) PRIMARY KEY,
    log_date DATE,
    action NVARCHAR(32),
    user_id UNIQUEIDENTIFIER FOREIGN KEY REFERENCES  users(id)
)

CREATE TABLE users_project (
    id INT IDENTITY(1,1) PRIMARY KEY,
    project_name VARCHAR(128),
    completed BIT,
    user_id UNIQUEIDENTIFIER FOREIGN KEY REFERENCES  users(id)
)