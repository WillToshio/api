
DROP TABLE IF EXISTS users_logs;
DROP TABLE IF EXISTS users_project;
DROP TABLE IF EXISTS users;

CREATE TABLE usuarios (
    id UUID PRIMARY KEY,
    name VARCHAR(128),
    age INT,
    score INT,
    active BOOLEAN,
    country VARCHAR(64),
    team_name VARCHAR(128),
    team_leader BOOLEAN,
);

CREATE TABLE usuario_logs (
    id SERIAL,
    log_date DATE,
    action VARCHAR(32),
    user_id UUID REFERENCES users(id)
);

CREATE TABLE usuario_projetos (
    id SERIAL,
    project_name VARCHAR(128),
    completed BOOLEAN,
    user_id UUID REFERENCES users(id)
);

