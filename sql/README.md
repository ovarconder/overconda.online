# SQL Schema for License Validation

Run `licenses.sql` against your MySQL/MariaDB database to create the required tables.

```bash
mysql -u your_user -p your_database < sql/licenses.sql
```

Or execute the SQL manually in your DB client.

## Tables

- **licenses** – Stores license validation results (upserted on each successful validation)
- **license_validation_logs** – Optional audit log of every validation attempt

## Environment

Set these in `.env`:

```
DATABASE_DSN=mysql:host=localhost;dbname=overconda;charset=utf8mb4
DATABASE_USER=your_user
DATABASE_PASSWORD=your_password
```

If `DATABASE_DSN` is not set, the API will still validate via Envato but will not persist to the database.
