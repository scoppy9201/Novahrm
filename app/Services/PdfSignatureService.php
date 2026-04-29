<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PdfSignatureService
{
    public function embedSignature(
        string $filePath,
        string $signatureBase64,
        int $pageNumber,
        float $posX,
        float $posY,
        float $width = 80,
        float $height = 30
    ): string {
        while (ob_get_level()) {
            ob_end_clean();
        }

        $sourcePath = Storage::disk('local')->path($filePath);

        $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $signatureBase64));
        $tempImage = tempnam(sys_get_temp_dir(), 'sig_') . '.png';
        file_put_contents($tempImage, $imageData);

        $pdf = new Fpdi();
        $pdf->SetAutoPageBreak(false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pageCount = $pdf->setSourceFile($sourcePath);

        for ($i = 1; $i <= $pageCount; $i++) {
            $tplId = $pdf->importPage($i);
            $size  = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            if ($i === $pageNumber) {
                $pdf->Image($tempImage, $posX, $posY, $width, $height, 'PNG');
            }
        }

        @unlink($tempImage);

        $pdfContent = $pdf->Output('', 'S');

        $signedPath = 'documents/signed/' . uniqid('signed_') . '.pdf';
        Storage::disk('local')->put($signedPath, $pdfContent);

        return $signedPath;
    }
}