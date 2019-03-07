<?php
include 'cartaMovilizacion2_1.php';
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES;
        $path = explode('librerias', $img_file);
//        $img_file7 = $path[0] . "recursos\imagenes\image_demo.jpg";
//        $this->Image($img_file7, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);  

        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
        $path = K_PATH_IMAGES;
        $path = explode('librerias', $path);
        $image_file = $path[0] . 'recursos/imagenes/escudo.jpg';

        $this->Image($image_file, 90, 10, 25, 25); //, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer

    public function Footer() {

        // Position at 15 mm from bottom

        $this->SetY(-40);

        // Set font
//5.329.553
        $this->SetFont('times', null, 8);
        $path = K_PATH_IMAGES;
        $path = explode('librerias', $path);
        $image_file = $path[0] . 'recursos/imagenes/certificados.png';
        $image_file2 = $path[0] . 'recursos/imagenes/bta_positiva.jpg';

        $this->Image($image_file, 60, 252, 80, 25); //, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->Image($image_file2, 150, 252, 40, 25);
        $txt = 'Calle 52 No. 13-64, Conmutador: 358 1600,          www.habitatbogota.gov.co,   @habitatComunica,        Código Postal: 11231';


        $this->MultiCell(35, 5, '' . $txt, 0, 'L', 0, 0, '', '', true);
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Secretaria de Habitat');

$pdf->SetTitle('Carta de Movilización');

$pdf->SetSubject('Carta de Movilización');

$pdf->SetProtection(array('print', 'copy','modify'), "ourcodeworld", $numDoc, 0, null);



// set default header data

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



//set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



//set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



//set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



//set some language-dependent strings

$pdf->setLanguageArray($l);

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

// ---------------------------------------------------------
// set font

$pdf->SetFont('times', '', 10);
$pdf->AddPage();


$x = utf8_encode($contenido);


$html = <<<EOF
<style>
    p{

         font-family: 'Arial';
         font-size: 10pt;

         text-align: justify;
         z-index:100;

     }    
     div{
        font-size: 10pt;
        text-align: rigth;
     }

 </style>
$x
$numDoc
EOF;


$pdf->writeHTML($html, true, false, true, false, '');

$path = K_PATH_IMAGES;
$path = explode('librerias', $path);
$image_file = $path[0] . 'recursos/imagenes/firma.jpg';
///$pdf->writeHTML("<b>Cordialmente,</b><p>&nbsp;</p>", true, false, true, false, '');
$pdf->Image($image_file, 15, 180, 55, 20, 'jpg', '', '', false, 150, '', false, false, 0, false, false, false);
$pdf->writeHTML("<p>&nbsp;</p><b>OSIRIS VIÑAS MANRIQUE</b>", true, false, true, false, '');
$pdf->writeHTML("Subdirectora Recursos Públicos ", true, false, true, false, '');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$prueba = $pdf->Output('CartaMovilizaci&oacute;nSecHab.pdf', 'E');
