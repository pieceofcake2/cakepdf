<?php

use Mpdf\Mpdf;

App::uses('AbstractPdfEngine', 'CakePdf.Pdf/Engine');
App::uses('Multibyte', 'I18n');

class MpdfEngine extends AbstractPdfEngine
{
    /**
     * Constructor
     *
     * @param CakePdf $pdf
     */
    public function __construct(CakePdf $pdf)
    {
        parent::__construct($pdf);
        App::import('Vendor', 'CakePdf.Mpdf', ['file' => 'mpdf' . DS . 'mpdf.php']);
    }

    /**
     * Generates Pdf from html
     *
     * @return string raw pdf data
     */
    public function output()
    {
        // mPDF often produces a whole bunch of errors, although there is a pdf created when debug = 0
        // Configure::write('debug', 0);
        $MPDF = new Mpdf();
        $MPDF->writeHTML($this->_Pdf->html());

        return $MPDF->Output('', 'S');
    }
}
