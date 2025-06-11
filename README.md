#yang harus di siapkan

1. composer
2. php 8.4.1 ini versi yang gua pake sekarang
3. mysql driver untuk database nya

#cara menjalankan service ci4

1. jalankan script "composer install"
1. bisa import db (dump.sql) yang udah gua taro jadi tanpa migrate atau jalankan script "php spark migrate"
1. jika menggunakan php spark migrate lu harus jalanin query yang ada di dalam folder script terlebih dahulu untuk init data role
1. untuk menjalankan aplikasi "php spark serve"
1. akses di localhost:8080 atau port yang lu pilih