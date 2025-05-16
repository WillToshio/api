
DROP TABLE IF EXISTS users_logs;
DROP TABLE IF EXISTS users_project;
DROP TABLE IF EXISTS users;


CREATE TABLE users (
    id CHAR(36) NOT NULL,
    name VARCHAR(128),
    age INT,
    score INT,
    active BOOLEAN,
    country VARCHAR(64),
    team_name VARCHAR(128),
    team_leader BOOLEAN,

    PRIMARY KEY (id)
)

CREATE TABLE users_logs(
    id INT AUTO_INCREMENT NOT NULL,
    log_date DATE,
    action VARCHAR(32),
    user_id CHAR(36),
    
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)

CREATE TABLE users_project(
    id INT AUTO_INCREMENT NOT NULL,
    project_name VARCHAR(128),
    completed BOOLEAN,
    user_id CHAR(36),
    
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)