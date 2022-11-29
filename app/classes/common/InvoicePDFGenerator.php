<?php
namespace App\classes\common;


class InvoicePDFGenerator extends PDFGenerator
{
    public function generate()
    {
        $html=$this->data_object->getHtml();
        $html_header = file_get_contents(realpath(public_path() . "/../../trademarkfactory.com/pdf_header.html"));
        $html_footer = "</body></html>";
        $html = str_replace("font-family: cambria;", "", $html);
        $html = str_replace("src='https://trademarkfactory.ca/img/TMF_Logo.png'", "src='https://trademarkfactory.ca/img/TMF_Logo.png' style='width:250px;'", $html);
        $html = str_replace("style='background:#eee; padding:5px;  border:2px dotted #ccc;'", "", $html);
        $html=str_replace('src="https://trademarkfactory.ca/img/','src="'.realpath(public_path() . "/../../trademarkfactory.com/").'/img/',$html);
        $html=str_replace("src='https://trademarkfactory.ca/img/","src='".realpath(public_path() . "/../../trademarkfactory.com/")."/img/",$html);
        //$html = str_replace("Mincov Law Corporation</p>", "Mincov Law Corporation</p></div>", $html);
//        echo $html;exit;
        require_once public_path().'/../../trademarkfactory.com/phpwkhtmltopdf/WkHtmlToPdf.php';

        $pdf = new \WkHtmlToPdf(array(
            'bin' => realpath(public_path().'/../../trademarkfactory.com/phpwkhtmltopdf/wkhtmltopdf'),
            'tmp' => '/tmp',
            'page-size' => 'Letter'
        ));

        $pdf->addPage($html_header . $html . $html_footer);
        $pdf_filename =  public_path()."/../../trademarkfactory.com/clientfiles/invoices/".$this->data_object->getFilename();
        if (!$pdf->saveAs($pdf_filename)) {
            echo 'Could not create PDF: ' . $pdf->getError();
            exit;
        }
//        DropboxUploader::uploadFile2TMF($pdf_filename,"/invoices/".basename($pdf_filename));
        return realpath($pdf_filename);
    }

}