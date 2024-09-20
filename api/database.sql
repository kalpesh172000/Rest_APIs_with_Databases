create table tasks(
    id serial,
    name varchar(128) not null,
    priority int default null,
    is_complete boolean not null default FALSE,
    index(name)
);

--serial means BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY