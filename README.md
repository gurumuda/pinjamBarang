# Aplikasi pemakaian barang milik sekolah

![php](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)![javascript](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)

Aplikasi ini dibuat untuk mempermudah dalam manajemen dan penggunaan barang milik sekolah

## Keperluan Server

- PHP 7.4 atau yang lebih baru
- Database MYSQL
- Webserver
- composer (untuk installasi)

## Pemasangan

Download

```base
git clone https://github.com/gurumuda/pinjamBarang.git
```

Install dependensi dengan composser

```base
composer update
```
Buat database baru dengan nama yang disesuaikan pada nama database di file env

Buat table database dengan mengetikkan perintah
```base
php spark migrate
```

Isi data default dari untuk menjalankan aplikasi
```base
php spark db:seed DefaultDataSeeder
```

Jalankan server
```base
php spark serve
```

Dokumentasi pembuatan pada video berikut
[Video Dokumentasi](https://www.youtube.com/playlist?list=PLCQQ4mSKjCBs2poBOMMUZdCn1mcavcw2i)
