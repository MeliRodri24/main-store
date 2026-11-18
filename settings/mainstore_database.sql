--Create users table
CREATE TABLE users (
    id            BIGSERIAL     PRIMARY KEY,
    firstname     VARCHAR(100)  NOT NULL,
    lastname      VARCHAR(100)  NOT NULL,
    ident_number  VARCHAR(20)   NOT NULL UNIQUE,
    mobile_phone  VARCHAR(20),
    email         VARCHAR(150)  NOT NULL UNIQUE,
    password      VARCHAR(255)  NOT NULL,
    url_photo     TEXT,
    birth_date    DATE,
    status        BOOLEAN       NOT NULL DEFAULT TRUE,
    created_at    TIMESTAMPTZ   NOT NULL DEFAULT NOW(),
    updated_at    TIMESTAMPTZ   NOT NULL DEFAULT NOW(),
    deleted_at    TIMESTAMPTZ
);

--Select all users from users table
SELECT * FROM users;
--Insert a new user into users table
INSERT INTO users (firstname, lastname, ident_number, email, password) VALUES ('Joan', 'Ayala', '56890988', 'joan@gmail.com', '123456');
--Update field url_photo
UPDATE users SET url_photo = 'photos/photo_default.png' WHERE id = 12;
-UPDATE users SET url_photo = 'photos/photo_default.png' WHERE id = 8;

--UPDATE users SET url_photo = 'photos/photo_default.png' WHERE id = 8;
--DELETE FROM users;
--ALTER SEQUENCE users_id_seq RESTART WITH 1;
--SELECT COUNT (ident_number) as total_users from users;
--UPDATE user set status = false WHERE id = 1;
--UPDATE users SET status = false WHERE id=2;