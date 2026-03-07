# Docker Setup for Overconda Licensing API

## Quick Start

1. **สร้างไฟล์ `.env`** ที่ root ของโปรเจกต์:
   ```bash
   cp docker/env.example .env
   # แก้ไข .env ให้ใส่ ENVATO_API_KEY และรหัส MySQL จริง
   ```

2. **รัน services:**
   ```bash
   docker compose up -d
   ```

3. **ติดตั้ง Composer dependencies** (ครั้งแรก):
   ```bash
   docker compose exec api composer install --no-dev
   ```

4. **ทดสอบ API:**
   - Health: `curl http://localhost:8080/api/health`
   - Validate: `curl -X POST http://localhost:8080/api/validate -H "Content-Type: application/json" -d '{"license_key":"xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"}'`

## Services

| Service | Port | คำอธิบาย |
|---------|------|----------|
| api | 8080 | PHP 8.2 + Apache (โฟลเดอร์โปรเจกต์ mount เข้าไป) |
| db | 3306 | MySQL 8.0 (สร้างตาราง licenses อัตโนมัติจาก sql/licenses.sql) |

## Environment Variables

- `ENVATO_API_KEY` – Envato Personal Token สำหรับตรวจสอบ license
- `MYSQL_ROOT_PASSWORD` – รหัส root ของ MySQL
- `MYSQL_DATABASE` – ชื่อ database (default: overconda)
- `MYSQL_USER` / `MYSQL_PASSWORD` – user สำหรับ API เชื่อมต่อ DB

## Production

- เปลี่ยนพอร์ตใน `ports` ตามต้องการ
- ใช้ secrets หรือ vault แทน .env สำหรับ production
- พิจารณา reverse proxy (nginx) หน้าหน้า API
