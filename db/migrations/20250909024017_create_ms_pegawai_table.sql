-- migrate:up
CREATE TABLE ms_pegawai (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nipy varchar(30) NOT NULL,
    nidn varchar(30) NOT NULL,
    nuptk varchar(50),
    nama varchar(75) NOT NULL,
    alamat varchar(100),
    id_prodi MEDIUMINT UNSIGNED,
    username varchar(30) NOT NULL,
    password char(60) NOT NULL,
    dosen_wali	tinyint NOT NULL DEFAULT 0,
    kaprodi	MEDIUMINT UNSIGNED,
    ketua tinyint NOT NULL DEFAULT 0,
    foto  tinytext,
    foto_ttd tinytext,
    tu tinyint NOT NULL DEFAULT 0,
    status tinyint NOT NULL DEFAULT	1,
    validator tinyint not null,
    CONSTRAINT FK_DosenProdi FOREIGN KEY (id_prodi) REFERENCES ms_prodi(id),
    CONSTRAINT FK_Kaprodi FOREIGN KEY (kaprodi) REFERENCES ms_prodi(id)
);

-- migrate:down
ALTER TABLE ms_pegawai DROP FOREIGN KEY FK_DosenProdi;
ALTER TABLE ms_pegawai DROP FOREIGN KEY FK_Kaprodi;

DROP TABLE ms_pegawai;

