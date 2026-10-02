# IPT10 Lab: mysqli vs PDO

Student record system (CRUD) built twice: procedural mysqli and object-oriented PDO.

## Setup

1. Install XAMPP and start Apache and MySQL.
2. In `php.ini`, enable `extension=mysqli` and `extension=pdo_mysql`, then restart Apache.
3. In phpMyAdmin, run `database.sql` to create the `ip10_lab` database and `students` table.
4. Copy `ipt10_lab/` and `ipt10_lab_pdo/` into `xampp/htdocs/`.
5. Open `http://localhost/ipt10_lab/` (mysqli) or `http://localhost/ipt10_lab_pdo/` (PDO).

## Notes

- The primary key is a UUID string, so the id is bound as a string.
- Writes are confirmed with `affected_rows` (mysqli) and `rowCount()` (PDO).
- The PDO version uses `ATTR_AUTOCOMMIT => false`, so each write is wrapped in `beginTransaction()` and `commit()`.
- Default database settings: host `127.0.0.1`, user `root`, empty password.
