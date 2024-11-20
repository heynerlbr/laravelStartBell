<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class QrCodeController extends Controller
{
    public function generarQr()
    {
        $texto = 'https://starbell.shop/apps/app-release.apk'; // Texto o enlace que quieres convertir en QR.
        $qr = QrCode::size(200)->generate($texto);
        return view('qr.index', compact('qr'));
    }
}
