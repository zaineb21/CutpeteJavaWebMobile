<?php

namespace App\services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use PhpParser\Node\Scalar\MagicConst\Dir;

class qrcode
{
    /**
     * @var BuilderInterface
     */
    protected $Builder;

    public function __construct(BuilderInterface $Builder)
    {
        $this->Builder = $Builder;

    }
    public function qrcode($query){
        $url = 'http://127.0.0.1:8000';
        $odjDateTime = new \DateTime('NOW');
        $DateString = $odjDateTime->format('d-m-Y H:i:s');


        $result = $this->Builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(200)
            ->margin(10)
            ->labelText('ton ticket ')
            ->build()
        ;
        $namepng = uniqid('',''). '.png';
        $result->saveToFile(  (\dirname( __DIR__,2).'/public/uploads/qrcode/'.$namepng));

        return $result->getDataUri();


    }

}