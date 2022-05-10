<?php

namespace App\services;



use Dompdf\Dompdf;
use Dompdf\Options;

class pdfService
{
    private $dompdf;

    public function __construct(){
        $this->dompdf = new Dompdf();


        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->dompdf->setOptions($pdfOptions);

    }
    public function showpdfFile($html){

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->stream("details.pdf", [

            'Attachement' =>false
        ]);


    }
    public function generatebinaryFile($html){

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();
        $this->dompdf->output();

    }

}