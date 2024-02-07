# Aplikasi pemakaian barang milik sekolah

![php](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) ![javascript](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E) ![codeigniter](https://img.shields.io/badge/Codeigniter-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)

Aplikasi ini dibuat untuk mempermudah dalam manajemen dan penggunaan barang milik sekolah.

Status aplikasi dalam proses pengembangan

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
composer install
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

Buka Browser dan masukkan url

```base
http://localhost:8080
```

Default login

`Administrator` => Email: `admin@admin.com ` Pass: ` admin`

`Guru` => Email: `guru1@admin.com ` Pass:` admin`

Dokumentasi pembuatan pada video berikut
[Video Dokumentasi](https://www.youtube.com/playlist?list=PLCQQ4mSKjCBs2poBOMMUZdCn1mcavcw2i)

Video Installasi pada link berikut
[Video Installasi](https://youtu.be/EcPCR6kVQXg)
