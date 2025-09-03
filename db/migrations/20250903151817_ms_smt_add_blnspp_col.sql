-- migrate:up
ALTER TABLE ms_smt
ADD COLUMN blnspp TINYINT;

-- migrate:down
ALTER TABLE ms_smt
DROP COLUMN blnspp;

