-- migrate:up
ALTER TABLE ms_smt
ADD PRIMARY KEY (`smt`);

-- migrate:down
ALTER TABLE ms_smt
DROP PRIMARY KEY (smt);
