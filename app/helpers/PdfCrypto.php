<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PdfCrypto
{
    public static function storeEncrypted($disk, $path, $fileContents)
    {
        $encryptedContents = Crypt::encrypt($fileContents);
        $success = Storage::disk($disk)->put($path, $encryptedContents);

        return $success ? $path : false;
    }

    public static function getDecrypted($disk, $path)
    {
        try {
            $encryptedContents = Storage::disk($disk)->get($path);

            if ($encryptedContents === null) {
                return null;
            }

            return Crypt::decrypt($encryptedContents);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return null;
        }
    }

    /**
     * ✅ Cifra contenido crudo
     */
    public static function encryptRaw($data)
    {
        return Crypt::encrypt($data);
    }

    /**
     * ✅ Descifra contenido crudo
     */
    public static function decryptRaw($data)
    {
        return Crypt::decrypt($data);
    }
}
