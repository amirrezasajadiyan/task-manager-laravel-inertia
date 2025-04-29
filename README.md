# Task Manager

## مقدمه
پروژه مدیریت وظایف با لاراول و ویو جی اس 

## نصب و راه‌اندازی

### پیش‌نیازها
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7
- Docker و Docker Compose (برای روش داکر)

### روش اول: نصب معمولی

1. کلون کردن پروژه:
```bash
git clone https://github.com/amirrezasajadiyan/task-manager-laravel-inertia.git
```

2. نصب وابستگی‌های PHP:
```bash
composer install
```

3. نصب وابستگی‌های JavaScript:
```bash
npm install
```

4. کپی فایل تنظیمات:
```bash
cp .env.example .env
```

5. ایجاد کلید برنامه:
```bash
php artisan key:generate
```

6. تنظیم پایگاه داده:
- فایل `.env` را ویرایش کنید و اطلاعات پایگاه داده را تنظیم کنید
- سپس دستورات زیر را اجرا کنید:
```bash
php artisan migrate
php artisan db:seed
```

7. کامپایل فایل‌های استاتیک:
```bash
npm run build
npm run dev
```

8. اجرای سرور:
```bash
php artisan serve
```

### روش دوم: استفاده از Docker

1. کلون کردن پروژه:
```bash
git clone https://github.com/amirrezasajadiyan/task-manager-laravel-inertia.git
cd task-manager-laravel-inertia
```

2. کپی فایل تنظیمات:
```bash
cp .env.example .env
```

3. ویرایش فایل `.env` برای تنظیمات داکر:
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=secret
```

4. ساخت و اجرای کانتینرها:
```bash
docker-compose up -d --build
```

5. نصب وابستگی‌ها:
```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

6. تولید کلید برنامه:
```bash
docker-compose exec app php artisan key:generate
```

7. اجرای مایگریشن‌ها و سیدر:
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

8. کامپایل فایل‌های استاتیک:
```bash
docker-compose exec app npm run build
```

9. دسترسی به برنامه:
```
http://localhost:8000
```


- توقف کانتینرها:
```bash
docker-compose down
```

- توقف و حذف تمام داده‌ها:
```bash
docker-compose down -v
```

## اجرای تست‌ها

### نصب Pest
```bash
composer require pestphp/pest --dev
```

### اجرای تست‌ها
```bash
./vendor/bin/pest
```

### اجرای تست‌ها در Docker
```bash
docker-compose exec app php artisan test
```

### اجرای تست‌های خاص
```bash
./vendor/bin/pest tests/Feature/Auth/LoginTest.php
```

## اطلاعات اضافی
برای ورود به سیستم می‌توانید از یوزر فیک که از طریق سیدر ساخته می‌شود استفاده کنید 
یا در سیستم ثبت‌نام کنید و سپس وارد شوید

### مدیریت وظایف
- ایجاد وظیفه جدید
- ویرایش وظیفه موجود
- حذف وظیفه
- تغییر وضعیت وظیفه
- اضافه کردن زیروظیفه

### مدیریت زیروظایف
- ایجاد زیروظیفه جدید
- ویرایش زیروظیفه
- حذف زیروظیفه
- تغییر وضعیت تکمیل زیروظیفه

### فیلترها و جستجو
- فیلتر بر اساس وضعیت
- جستجو در عنوان و توضیحات

