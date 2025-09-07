-- migrate:up
CREATE TABLE ms_fakultas (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(40) NOT NULL,
    status BOOLEAN NOT NULL DEFAULT FALSE
);

-- migrate:down
DROP TABLE ms_fakultas;

