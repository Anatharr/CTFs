CREATE DATABASE stdoctolib;

\c stdoctolib

CREATE EXTENSION pgcrypto;

CREATE TABLE accounts (
    username    TEXT,
    password   TEXT
);

INSERT INTO accounts (username, password) VALUES
('tata', crypt('tata_password', gen_salt('bf'))),
('toto', crypt('toto_password', gen_salt('bf'))),
('admin', crypt('admin_password', gen_salt('bf')))
