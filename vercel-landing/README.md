# Overconda Landing (Static)

หน้า Landing Portfolio แบบ Static สำหรับ deploy บน **Vercel** โดยตรง

- **Tech:** HTML + Tailwind CSS (CDN)
- **Domain:** overconda.space

## วิธี Deploy บน Vercel

1. **ถ้าใช้ Repo นี้ทั้งโปรเจกต์:**  
   ใน Vercel Project Settings ตั้ง **Root Directory** เป็น `vercel-landing` แล้ว Deploy

2. **ถ้าเอาเฉพาะไฟล์นี้ไปใช้:**  
   สร้าง Repo ใหม่ แล้ว copy เนื้อหาในโฟลเดอร์ `vercel-landing` (รวม `index.html`, `vercel.json`) ไปไว้ที่ root ของ Repo นั้น แล้วเชื่อม Repo นั้นกับ Vercel

3. ตั้ง Custom Domain เป็น `overconda.space` (หรือ subdomain ตามที่ใช้) ใน Vercel Dashboard

## โครงส่วน Plugins

- Section **Our WordPress Plugins** เป็น UI  placeholder: มีการ์ดตัวอย่าง (Overconda Conflict Detective · Coming Soon) และ 2 ช่อง “More plugins / New product” ไว้รอ
- เมื่อมีข้อมูลปลั๊กอินจริง สามารถเปลี่ยนไปใช้ข้อมูลจาก API หรือแก้ใน HTML โดยตรง

## ลิงก์ License

ลิงก์ “License Validation” ชี้ไปที่ `https://overconda.space/license-validation` (หรือ path จริงที่คุณใช้บน backend) แก้ใน `index.html` ได้ตาม environment ที่ deploy

---

## การเปลี่ยนชื่อโฟลเดอร์โปรเจกต์ (overconda.online → overconda.space)

ถ้าต้องการเปลี่ยนชื่อโฟลเดอร์โปรเจกต์จาก `Overconda.Online` เป็น `Overconda.Space` หรือ `overconda.space` ให้ทำที่เครื่องคุณเอง เพราะเป็นการเปลี่ยน path บนไฟล์ระบบ ไม่สามารถทำจากภายในโปรเจกต์ได้

**ขั้นตอนแนะนำ:**

1. **ปิดโปรเจกต์ใน Cursor (หรือ IDE อื่น)**  
   ปิดแท็บ/โฟลเดอร์โปรเจกต์นี้ให้หมด เพื่อไม่ให้มีไฟล์ถูกล็อกหรือเปิดอยู่

2. **เปลี่ยนชื่อโฟลเดอร์บนเครื่อง**  
   - เปิด Finder ไปที่โฟลเดอร์ที่เก็บโปรเจกต์ (เช่น `~/WEB/`)  
   - คลิกขวาที่โฟลเดอร์ `Overconda.Online` → **Rename** (หรือกด Enter หลังเลือก)  
   - เปลี่ยนชื่อเป็น `overconda.space` หรือ `Overconda.Space` ตามที่ต้องการ  

   **หรือใช้ Terminal:**
   ```bash
   cd ~/WEB   # หรือ path จริงที่เก็บโปรเจกต์
   mv Overconda.Online overconda.space
   ```

3. **เปิดโปรเจกต์จากโฟลเดอร์ใหม่**  
   ใน Cursor: **File → Open Folder** แล้วเลือกโฟลเดอร์ `overconda.space` ที่เปลี่ยนชื่อแล้ว

4. **ตรวจสอบหลังเปลี่ยนชื่อ**  
   - Git remote, Composer, หรือ path อื่นที่อ้างถึงชื่อโฟลเดอร์เก่าอาจต้องตรวจหรือแก้ถ้ามี (โดยทั่วไปชื่อโฟลเดอร์ท้องถิ่นไม่ถูก hardcode ในโค้ด)
