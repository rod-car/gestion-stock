<?php

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// app/Http/routes.php | app/routes/web.php

/*Route::get('/', function (Fpdf $fpdf) {
    $datas = ["First page", "Second page"];
    $fpdf->SetFont('Courier', 'B', 18);

    foreach ($datas as $data)
    {
        $fpdf->AddPage();
        $fpdf->Cell(0, 0, $data);
    }

    $fpdf->Output();
    exit;
});*/

Route::view('/{any}', 'app')->where('any', ".*");
