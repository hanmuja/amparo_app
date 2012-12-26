<?php 
App::import('Vendor','xtcpdf');  
$tcpdf = new XTCPDF(); 
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 

$tcpdf->SetAuthor("my author"); 
$tcpdf->SetAutoPageBreak( true ); 

// remove default header/footer
$tcpdf->setPrintHeader(false);
$tcpdf->setPrintFooter(false); 

// add a page (required with recent versions of tcpdf) 
$tcpdf->AddPage(); 

// Now you position and print your page content 
// example:  
$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,'',8); 

$tcpdf->writeHTML($html, true, false, true, false, '');

$datetime = date("d-m-Y_H-m");

echo $tcpdf->Output('voucher_'.$datetime.'.pdf', 'D'); 

?>