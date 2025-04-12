<?php
$host = "localhost";
$dbname = "your_db_name";
$user = "your_db_user";
$password = "your_db_password";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if main table exists (e.g., STUDENT)
    $stmt = $pdo->query("SELECT to_regclass('public.student')"); // returns null if not exists
    $studentTable = $stmt->fetchColumn();

    if ($studentTable === null) {
        echo "Tables do not exist. Creating tables...<br>";

        $tables = [

            // STUDENT
            "CREATE TABLE IF NOT EXISTS STUDENT(
                STUD_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 12300) PRIMARY KEY,
                STUD_FNAME VARCHAR(50) NOT NULL,
                STUD_LNAME VARCHAR(50) NOT NULL,
                STUD_MNAME VARCHAR(50),
                STUD_SUFFIX VARCHAR(5),
                STUD_ADD VARCHAR(100),
                STUD_LRN BIGINT,
                STUD_EMAIL VARCHAR(64) NOT NULL UNIQUE,
                STUD_DOB DATE,
                STUD_ENROLL BOOLEAN DEFAULT true
            )",

            // ADMISSION
            "CREATE TABLE IF NOT EXISTS ADMISSION(
                ADMS_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 1000) PRIMARY KEY,
                ADMS_DATE DATE NOT NULL DEFAULT CURRENT_DATE,
                ADMS_STATUS VARCHAR(20) NOT NULL,
                ADMS_LVL INT NOT NULL,
                STUD_ID INT NOT NULL,
                FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON UPDATE CASCADE ON DELETE CASCADE
            )",

            // ADMISSION_HISTORY
            "CREATE TABLE IF NOT EXISTS ADMISSION_HISTORY(
                ADMHS_ID SERIAL PRIMARY KEY,
                ADMHS_DATE DATE NOT NULL,
                ADMHS_LVL INT NOT NULL,
                ADMHS_STATUS VARCHAR(20) NOT NULL,
                STUD_ID INT NOT NULL,
                ADMHS_PROC_DATE DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON UPDATE CASCADE ON DELETE CASCADE
            )",

            // DOCUMENT
            "CREATE TABLE IF NOT EXISTS DOCUMENT(
                DOCU_ID SERIAL PRIMARY KEY,
                DOCU_TYPE VARCHAR(50) NOT NULL
            )",

            // REQUEST
            "CREATE TABLE IF NOT EXISTS REQUEST(
                REQ_TRACK_ID BIGINT GENERATED ALWAYS AS IDENTITY (START WITH 12345600) PRIMARY KEY,
                REQ_DATE DATE NOT NULL DEFAULT CURRENT_DATE,
                REQ_PURPOSE TEXT NOT NULL,
                REQ_STATUS VARCHAR(20) DEFAULT 'PENDING' NOT NULL,
                DOCU_ID INT NOT NULL,
                STUD_ID INT NOT NULL,
                FOREIGN KEY (DOCU_ID) REFERENCES DOCUMENT(DOCU_ID) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON DELETE CASCADE ON UPDATE CASCADE
            )",

            // REQUEST_HISTORY
            "CREATE TABLE IF NOT EXISTS REQUEST_HISTORY(
                REQHS_ID SERIAL PRIMARY KEY,
                REQHS_DATE DATE NOT NULL,
                REQHS_PURPOSE TEXT NOT NULL,
                REQHS_STATUS VARCHAR(20) DEFAULT 'PENDING' NOT NULL,
                DOCU_ID INT NOT NULL,
                STUD_ID INT NOT NULL,
                REQHS_PROC_DATE DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (DOCU_ID) REFERENCES DOCUMENT(DOCU_ID) ON DELETE CASCADE ON UPDATE CASCADE,
                FOREIGN KEY (STUD_ID) REFERENCES STUDENT(STUD_ID) ON DELETE CASCADE ON UPDATE CASCADE
            )",

            // ADMIN
            "CREATE TABLE IF NOT EXISTS ADMIN(
                ADMIN_ID INT GENERATED ALWAYS AS IDENTITY (START WITH 12000) PRIMARY KEY,
                ADMIN_USERNAME VARCHAR(50) NOT NULL UNIQUE,
                ADMIN_PASSWORD VARCHAR(255) NOT NULL
            )",

            // CHANGE_HISTORY
            "CREATE TABLE IF NOT EXISTS CHANGE_HISTORY(
                CHG_ID SERIAL PRIMARY KEY,
                CHG_COLUMN VARCHAR(20) NOT NULL,
                CHG_OLD_VAL VARCHAR(50) NOT NULL,
                CHG_NEW_VAL VARCHAR(50) NOT NULL,
                CHG_DATETIME TIMESTAMP NOT NULL,
                ADMIN_ID INT NOT NULL,
                FOREIGN KEY (ADMIN_ID) REFERENCES ADMIN(ADMIN_ID) ON UPDATE CASCADE ON DELETE CASCADE
            )",

            // ADMIN_CONTROLS
            "CREATE TABLE IF NOT EXISTS ADMIN_CONTROLS(
                CTRL_KEY VARCHAR(30) PRIMARY KEY,
                CTRL_VALUE VARCHAR(30)
            )"
        ];

        foreach ($tables as $sql) {
            $pdo->exec($sql);
        }

        echo "Tables created successfully.";
    } else {
        echo "Tables already exist. No need to create.";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
