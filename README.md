# Task Manager

## مقدمه
Task Manager یک برنامه مدیریت وظایف است که با استفاده از Laravel و Vue.js ساخته شده است. این برنامه به کاربران امکان می‌دهد تا وظایف خود را مدیریت کنند، زیروظایف ایجاد کنند و وضعیت آنها را پیگیری کنند.

## نصب و راه‌اندازی

### پیش‌نیازها
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 5.7
- Docker و Docker Compose (اختیاری)

### نصب با دستورهای معمولی

1. کلون کردن پروژه:
```bash
git clone https://github.com/your-username/task-manager.git
cd task-manager
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
```

8. اجرای سرور:
```bash
php artisan serve
```

### نصب با Docker

1. کپی فایل تنظیمات:
```bash
cp .env.example .env
```

2. اجرای پروژه با Docker:
```bash
docker-compose up -d
```

3. نصب وابستگی‌ها:
```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

4. تنظیمات پایگاه داده:
```bash
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

5. کامپایل فایل‌های استاتیک:
```bash
docker-compose exec app npm run build
```

## دستورالعمل‌های Docker

### ساختار docker-compose.yml
```yaml
version: '3'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: task-manager-app
    restart: unless-stopped
    working_dir: /var/www/
    volumes:
      - ./:/var/www
    networks:
      - task-manager

  db:
    image: mysql:8.0
    container_name: task-manager-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
      MYSQL_PASSWORD: ${DB_PASSWORD}
      MYSQL_USER: ${DB_USERNAME}
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - task-manager

  nginx:
    image: nginx:alpine
    container_name: task-manager-nginx
    restart: unless-stopped
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d/
    networks:
      - task-manager

networks:
  task-manager:
    driver: bridge

volumes:
  dbdata:
    driver: local
```

### دستورات Docker
- اجرای پروژه: `docker-compose up -d`
- توقف پروژه: `docker-compose down`
- مشاهده لاگ‌ها: `docker-compose logs -f`
- اجرای دستورات در کانتینر: `docker-compose exec app [command]`

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

### اعلان‌ها
- نمایش پیام‌های موفقیت
- نمایش پیام‌های خطا
- اعلان‌های وضعیت وظایف

## مجوز
این پروژه تحت مجوز MIT منتشر شده است.
