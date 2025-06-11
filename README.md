#yang harus di siapkan

1. composer
2. php 8.4.1 ini versi yang gua pake sekarang
3. mysql driver untuk database nya

#cara menjalankan service ci4

1. jalankan script "composer install"
2. bisa import db (dump.sql) yang udah gua taro jadi tanpa migrate atau jalankan script "php spark migrate"
3. jika menggunakan php spark migrate lu harus jalanin query yang ada di dalam folder script terlebih dahulu untuk init data role
4. untuk menjalankan aplikasi "php spark serve"
5. akses di localhost:8080 atau port yang lu pilih
6. kalo lo import db ada user yang udah ada di database
7. username : kadal , password : password123 (ADMIN) || username : pelanggan1, password : password123 (USER)

$cobain push