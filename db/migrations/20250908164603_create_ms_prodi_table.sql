-- migrate:up
CREATE TABLE ms_prodi (
    id MEDIUMINT UNSIGNED PRIMARY KEY NOT NULL,
    nim_prefix VARCHAR(2) NOT NULL,
    id_fakultas	BIGINT UNSIGNED NOT NULL,
    nama	varchar(40) NOT NULL,
    program	varchar(40)	NOT NULL,
    id_kaprodi	varchar(30) NOT NULL,
    akreditasi	char(1),
    no_akreditasi varchar(50),
    tgl_akreditasi	date NOT NULL,
    status	tinyint(1),
    CONSTRAINT FK_ProdiFakultas FOREIGN KEY (id_fakultas)
    REFERENCES ms_fakultas(id)
)
-- migrate:down
DROP TABLE ms_prodi
