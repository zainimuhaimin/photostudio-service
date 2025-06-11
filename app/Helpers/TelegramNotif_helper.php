<?php

if (!function_exists('sendTelegramText')) {
    function sendTelegramText($message) {
        error_log("sendTelegramText: $message");
        try {
            $token = getenv('TELEGRAM_BOT_TOKEN');
            $chatId = getenv('TELEGRAM_CHAT_ID');
            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            $data = [
                'chat_id' => $chatId,
                'text' => $message,
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error kirim pesan notif telegram".$th->getMessage());
        }
        
    }
}

if (!function_exists('sendTelegramPhotoFile')) {
    function sendTelegramPhotoFile($filePath, $caption = '') {
        try {
            
            error_log("sendTelegramPhotoFile: $filePath");
        $token = getenv('TELEGRAM_BOT_TOKEN');
        $chatId = getenv('TELEGRAM_CHAT_ID');
        $url = "https://api.telegram.org/bot{$token}/sendPhoto";

        if (!file_exists($filePath)) {
            log_message('error', 'File not found: ' . $filePath);
            return false;
        }

        $postFields = [
            'chat_id' => $chatId,
            'photo' => new CURLFile(realpath($filePath)),
            'caption' => $caption
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
        } catch (\Throwable $th) {
            //throw $th;
            error_log("error kirim notif photo telegram :". $th->getMessage());
        }
    }
}

