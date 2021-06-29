## Hệ thống quản lý Khóa đào tạo VietJack

* Download DB: [Tải ngay](https://1drv.ms/u/s!Ao8DSzz_Giank1WyaOfs-m3mb0in?e=1aYeyu)

### Thao tác cài đặt Local

* Bước 1: tạo file `.env` với nội dung ở `.env.example`

* Bước 2: thay đổi 1 số thông tin config
    * APP_URL
    * DB_DATABASE
    * DB_USERNAME
    * DB_PASSWORD
    * MIX_APP_URL
    * MIX_VIDEO_URL
    
* Bước 2
```
git checkout develop
```

* Bước 3:
```php
composer install
```

* Bước 4:
```php
php artisan migrate 
```

* Bước 5: generate css file: chú ý dấu / hoặc \\
    * nếu bạn đã cài sass
    ```php
    sass public/frontend/css/style.scss public/frontend/css/style.css
    ```
    * nếu chưa cài sass
    ```php
    npm install -g sass
    sass public/frontend/css/style.scss public/frontend/css/style.css
    ```    
  