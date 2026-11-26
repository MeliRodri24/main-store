select 
    id as user_id,
    ident_number as cedula,
    lastname,
    firstname,
    mobile_phone,
    status,
    url_photo

from
    users
WHERE
    mobile_phone is not NULL and
    status = true
order by
    lastname ASC;

--UPDATE users SET url_photo = 'photos/photo_default.png' WHERE id = 8;
--DELETE FROM users;
--ALTER SEQUENCE users_id_seq RESTART WITH 1;
SELECT COUNT (ident_number) as total_users from users;
--UPDATE user set status = false WHERE id = 1;
--UPDATE users SET status = false WHERE id=2;