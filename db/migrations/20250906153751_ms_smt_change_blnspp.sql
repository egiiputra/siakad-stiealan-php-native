-- migrate:up
ALTER TABLE ms_smt
MODIFY COLUMN blnspp MEDIUMINT UNSIGNED

-- migrate:down
ALTER TABLE ms_smt
MODIFY COLUMN blnspp TINYINT
