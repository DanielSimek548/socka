<?php
session_start();
require_once('../scripts/database.php');
require('../scripts/fpdf.php');
$sql = $_GET['sql'];
$pdf = new FPDF(); 
$pdf->AddPage();

$width_cell=array(20,50,40,40,40);
$pdf->SetFont('Arial','B',16);

//Background color of header//
$pdf->SetFillColor(193,229,252);

// Header starts /// 
//First header column //
$pdf->Cell($width_cell[0],10,'Meno',1,0,'C',true);
//Second header column//
$pdf->Cell($width_cell[1],10,'Priezvisko',1,0,'C',true);
//Third header column//
$pdf->Cell($width_cell[2],10,'Trieda',1,0,'C',true); 
//Fourth header column//
$pdf->Cell($width_cell[3],10,'Skrinka',1,1,'C',true); 
//// header ends ///////

$pdf->SetFont('Arial','',14);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;

/// each record is one row  ///
foreach ($conn->query($sql) as $row) {
$pdf->Cell($width_cell[0],10,$row['meno'],1,0,'C',$fill);
$pdf->Cell($width_cell[1],10,$row['priezvisko'],1,0,'C',$fill);
$pdf->Cell($width_cell[2],10,$row['trieda'],1,0,'C',$fill);
$pdf->Cell($width_cell[3],10,$row['skrinka'],1,1,'C',$fill);
$fill = !$fill;
}
/// end of records /// 

$pdf->Output();
?>
