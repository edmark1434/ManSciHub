-- CREATE TABLE STUDENT(
-- 	STUD_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 12300) PRIMARY KEY,
-- 	STUD_FNAME VARCHAR(50) NOT NULL,
-- 	STUD_LNAME VARCHAR(50) NOT NULL,
-- 	STUD_MNAME VARCHAR(50),
-- 	STUD_SUFFIX VARCHAR(5),
-- 	STUD_ADD 	VARCHAR(100),
-- 	STUD_LRN 	BIGINT NOT NULL,
-- 	STUD_EMAIL	VARCHAR(64) NOT NULL UNIQUE,
-- 	STUD_DOB 	DATE 	NOT NULL
-- );

-- CREATE TABLE ADMISSION(
-- 	ADMS_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 1000) PRIMARY KEY,
-- 	ADMS_DATE DATE NOT NULL DEFAULT CURRENT_DATE,
-- 	ADMS_STATUS 	VARCHAR(20) NOT NULL,
-- 	STUD_ID 	INT NOT NULL,
-- 	FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON UPDATE CASCADE ON DELETE CASCADE
-- );

-- CREATE TABLE ADMISSION_HISTORY(
-- 	ADMHS_ID 	INT 	SERIAL,
-- 	ADMHS_DATE DATE NOT NULL,
-- 	ADMHS_STATUS 	VARCHAR(20) NOT NULL,
-- 	STUD_ID 	INT NOT NULL,
-- 	ADMHS_PROC_DATE 	DATE 	NOT NULL DEFAULT CURRENT_DATE,
-- 	FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON UPDATE CASCADE ON DELETE CASCADE
-- );

-- CREATE TABLE DOCUMENT(
-- 	DOCU_ID INT SERIAL,
-- 	DOCU_TYPE	VARCHAR(50) NOT NULL
-- );

-- CREATE TABLE REQUEST(
-- 	REQ_TRACK_ID  BIGINT GENERATED ALWAYS AS IDENTITY (START WITH 12345600) PRIMARY KEY,
-- 	REQ_DATE 	  DATE 	 NOT NULL DEFAULT CURRENT_DATE,
-- 	REQ_PURPOSE	  TEXT 	 NOT NULL,
-- 	REQ_STATUS	  VARCHAR(20)  DEFAULT 'PENDING' NOT NULL,
-- 	DOCU_ID 	  INT 	 NOT NULL,
-- 	STUD_ID       INT	 NOT NULL,
-- 	FOREIGN KEY (DOCU_ID) REFERENCES DOCUMENT(DOCU_ID) ON DELETE CASCADE ON UPDATE CASCADE,
-- 	FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON DELETE CASCADE ON UPDATE CASCADE
-- );

-- CREATE TABLE REQUEST_HISTORY(
-- 	REQHS_ID 	INT 	SERIAL,
-- 	REQHS_DATE 	  DATE 	 NOT NULL,
-- 	REQHS_PURPOSE	  TEXT 	 NOT NULL,
-- 	REQHS_STATUS	  VARCHAR(20)  DEFAULT 'PENDING' NOT NULL,
-- 	DOCU_ID 	  INT 	 NOT NULL,
-- 	STUD_ID       INT	 NOT NULL,
-- 	REQHS_PROC_DATE  DATE 	NOT NULL DEFAULT CURRENT_DATE,
-- 	FOREIGN KEY (DOCU_ID) REFERENCES DOCUMENT(DOCU_ID) ON DELETE CASCADE ON UPDATE CASCADE,
-- 	FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON DELETE CASCADE ON UPDATE CASCADE
	
-- );



-- CREATE TABLE ADMIN(
-- 	ADMIN_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 12000) PRIMARY KEY,
-- 	ADMIN_USERNAME 	VARCHAR(50) NOT NULL UNIQUE,
-- 	ADMIN_PASSWORD 	VARCHAR(255) NOT NULL
-- );
-- CREATE TABLE CHANGE_HISTORY(
-- 	CHG_ID SERIAL PRIMARY KEY,
-- 	CHG_COLUMN 	VARCHAR(20) NOT NULL,
-- 	CHG_OLD_VAL VARCHAR(50) NOT NULL,
-- 	CHG_NEW_VAL VARCHAR(50) NOT NULL,
-- 	CHG_DATETIME TIMESTAMP	NOT NULL,
-- 	ADMIN_ID INT NOT NULL,
-- 	FOREIGN KEY (ADMIN_ID) REFERENCES ADMIN(ADMIN_ID) ON UPDATE CASCADE ON DELETE CASCADE
-- );

-- CREATE TABLE ADMIN_CONTROLS(
-- 	CTRL_KEY VARCHAR(30) NOT NULL,
-- 	CTRL_VALUE VARCHAR(30)
-- );

