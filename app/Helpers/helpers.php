<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;

if (! function_exists('generateProductBarcode')) {
    function generateProductBarcode($path= '/dashboard/produit')
    {
        $code = rand(555000, 699699);
       $barcode = QrCode::size(60)->generate($code);

        return [$code, $barcode];
    }
}