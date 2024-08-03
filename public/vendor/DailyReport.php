<?php
include_once 'setasign/fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    { 
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Daily Timesheet', 0, 1, 'R');
        $this->Ln(5);
    }

    function Footer()
    { 
        $this->SetY(-15); 
        $this->SetFont('Arial', 'I', 8); 
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

$datas = ['name', 'date', 'clockin', 'lunchduration', 'breakduration', 'clockout', 'hoursworked'];
 
foreach ($datas as $data) {
    if (isset($_POST[$data])) {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $clockin = $_POST['clockin'];
        $lunchduration = $_POST['lunchduration'];
        $breakduration = $_POST['breakduration'];
        $clockout = $_POST['clockout'];
        $hoursworked = $_POST['hoursworked'];
 
        $dateTime = new DateTime($date);
        $formattedDate = $dateTime->format('D, d M'); 
 
        $pdf = new PDF();
        $pdf->AddPage();
 
        $pdf->Image(__DIR__ . '/../assets/img/Sidebar/logo.png', 10, 20, 15);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(30, 22); 
        $pdf->Cell(0, 10, 'WhereToNextMed', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Ln(20);
         
        $pdf->Cell(14, 30, 'Name:', 0, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 30, $name, 0, 1);

        $pdf->Ln(-5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(35, 10, 'Date', 1, 0, 'C');
        $pdf->Cell(31, 10, 'Clocked In', 1, 0, 'C');
        $pdf->Cell(31, 10, 'Lunch Duration', 1, 0, 'C');
        $pdf->Cell(31, 10, 'Break Duration', 1, 0, 'C');
        $pdf->Cell(31, 10, 'Clock Out', 1, 0, 'C');
        $pdf->Cell(31, 10, 'Total Hours', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 10, $date, 1, 0, 'C');
         
        if ($clockin != 'null' && $clockin != '') {
            $pdf->Cell(31, 10, $clockin, 1, 0, 'C');
        } else {
            $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
        } 

        if ($lunchduration != 'null' && $lunchduration != '') {
            $pdf->Cell(31, 10, $lunchduration, 1, 0, 'C');
        } else {
            $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
        }

        if ($breakduration != 'null' && $breakduration != '') {
            $pdf->Cell(31, 10, $breakduration, 1, 0, 'C');
        } else {
            $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
        } 

        if ($clockout != 'null' && $clockout != '') {
            $pdf->Cell(31, 10, $clockout, 1, 0, 'C');
        } else {
            $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
        }  

        if ($hoursworked != 'null' && $hoursworked != 'N/A') {
            $pdf->Cell(31, 10, $hoursworked, 1, 1, 'C');
        } else {
            $pdf->Cell(31, 10, '', 1, 1, 'C');
        }  
 
        $pdf->Output();
    }
}
?>
