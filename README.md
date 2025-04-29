# Task Manager

## مقدمه
پروژه مدیریت وظایف  با لاراول و ویو جی اس 

## نصب و راه‌اندازی

### پیش‌نیازها
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7



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
npm run dev
```

8. اجرای سرور:
```bash
php artisan serve
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

### اجرای تست‌های خاص
```bash
./vendor/bin/pest tests/Feature/Auth/LoginTest.php
```

## اطلاعات اضافی

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

