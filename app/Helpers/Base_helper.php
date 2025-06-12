<?php

use App\Models\PembayaranModel;

if (!function_exists('generateTransactionId')) {
    function generateTransactionId(): string
    {
        $model = new PembayaranModel();

        try {
            // Ambil kode terakhir
            $last = $model
                ->select('transaction_id')
                ->orderBy('transaction_id', 'DESC')
                ->first();

            if ($last && preg_match('/TRX(\d+)/', $last['transaction_id'], $match)) {
                $lastNumber = (int) $match[1];
            } else {
                $lastNumber = 0;
            }

            $newNumber = $lastNumber + 1;
            $kode = 'TRX' . str_pad($newNumber, 9, '0', STR_PAD_LEFT);

            return $kode;
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error generate transaction_id : ".$th->getMessage());
            throw $th;
        }
        
    }
}