<?php

use Dompdf\Dompdf;

App::uses('AbstractPdfEngine', 'CakePdf.Pdf/Engine');
App::uses('Multibyte', 'I18n');

class DomPdfEngine extends AbstractPdfEngine
{
    /**
     * Constructor
     *
     * @param CakePdf $pdf
     */
    public function __construct(CakePdf $pdf)
    {
        parent::__construct($pdf);
        if (!defined('DOMPDF_FONT_CACHE')) {
            define('DOMPDF_FONT_CACHE', TMP);
        }
        if (!defined('DOMPDF_TEMP_DIR')) {
            define('DOMPDF_TEMP_DIR', TMP);
        }
    }

    /**
     * Generates Pdf from html
     *
     * @return string raw pdf data
     */
    public function output()
    {
        $DomPDF = new Dompdf();
        $DomPDF->set_paper($this->_Pdf->pageSize(), $this->_Pdf->orientation());
        $DomPDF->load_html($this->_Pdf->html());
        $DomPDF->render();

        return $DomPDF->output();
    }
}
