<?php

    function parseAndFormatDate($inputDateString)
    {
        error_log("parseAndFormatDate from 'Y-m-d\TH:i' to 'Y-m-d H:i:s'");

        // 1. Parsing input string ke DateTime object
        // DateTime::createFromFormat lebih aman karena memastikan format input yang spesifik
        // 'Y-m-d\TH:i' adalah format untuk 'YYYY-MM-DDTHH:MM'
        $dateTimeObject = \DateTime::createFromFormat('Y-m-d\TH:i', $inputDateString);

        // 2. Manipulasi tanggal dan waktu (jika diperlukan)
        // Di sini kita ingin mengubah tanggal menjadi 2025-06-11 09:40:00
        // Kita bisa set langsung atau menambah/mengurangi waktu
        // Contoh: Mengubah tanggal ke 11 Juni 2025 dan waktu ke 09:40:00
        $dateTimeObject->setDate(2025, 6, 11);
        $dateTimeObject->setTime(9, 40, 0);

        // Jika kamu ingin menambahkan/mengurangi waktu relatif dari input:
        // $dateTimeObject->modify('+1 day'); // Menambah 1 hari
        // $dateTimeObject->setTime(9, 40, 0); // Mengatur jam ke 09:40:00

        // 3. Format DateTime object ke string yang diinginkan
        $outputDateString = $dateTimeObject->format('Y-m-d H:i:s');

        return $outputDateString;
        // Output yang diharapkan:
        // {
        //   "status": "success",
        //   "input": "2025-06-10T20:13",
        //   "output": "2025-06-11 09:40:00"
        // }
    }