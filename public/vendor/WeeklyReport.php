<?php
include_once 'setasign/fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Weekly Timesheet', 0, 1, 'R');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }
}

$datas = ['name', 'shifty', 'date', 'clockin', 'lunchduration', 'breakduration', 'clockout', 'hoursworked', 'totalweeklyhrs'];

foreach ($datas as $data) {
    if (!isset($_POST[$data])) {
        echo 'Error: Missing required data.';
        exit;
    }
}

$shift = $_POST['shifty'];
$name = $_POST['name'];
$dates = $_POST['date'];
$clockin = $_POST['clockin'];
$lunchduration = $_POST['lunchduration'];
$breakduration = $_POST['breakduration'];
$clockout = $_POST['clockout'];
$hoursworked = $_POST['hoursworked'];
$totalweeklyhrs = $_POST['totalweeklyhrs'];

$pdf = new PDF();
$pdf->AddPage();

$pdf->Image(__DIR__ . '/../assets/img/Sidebar/logo.png', 10, 20, 15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(30, 22);
$pdf->Cell(0, 10, 'WhereToNextMed', 0, 1);

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 30, 'Employee Name:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 30, $name, 0, 1);

$pdf->Ln(-10);
$pdf->SetX(153);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, -10, 'Week Starting:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(19, -10, $dates[0], 0, 0);
$pdf->Cell(30, 10, '', 0, 1);

$pdf->Ln(-23);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, 30, 'Shift:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 30, $shift, 0, 1);

$pdf->Ln(-5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 10, 'Date', 1, 0, 'C');
$pdf->Cell(31, 10, 'Clock In', 1, 0, 'C');
$pdf->Cell(31, 10, 'Lunch Duration', 1, 0, 'C');
$pdf->Cell(31, 10, 'Break Duration', 1, 0, 'C');
$pdf->Cell(31, 10, 'Clock Out', 1, 0, 'C');
$pdf->Cell(31, 10, 'Total Hours', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

for ($i = 0; $i < count($dates); $i++) {
    if ($dates[$i] == '') {
        continue;
    }

    $pdf->Cell(35, 10, $dates[$i], 1, 0, 'C');

    if ($clockin[$i] != 'null' && $clockin[$i] != '') {
        $pdf->Cell(31, 10, $clockin[$i], 1, 0, 'C');
    } else {
        $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
    }

    if ($lunchduration[$i] != 'null' && $lunchduration[$i] != '') {
        $pdf->Cell(31, 10, $lunchduration[$i], 1, 0, 'C');
    } else {
        $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
    }

    if ($breakduration[$i] != 'null' && $breakduration[$i] != '') {
        $pdf->Cell(31, 10, $breakduration[$i], 1, 0, 'C');
    } else {
        $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
    }

    if ($clockout[$i] != 'null' && $clockout[$i] != '') {
        $pdf->Cell(31, 10, $clockout[$i], 1, 0, 'C');
    } else {
        $pdf->Cell(31, 10, 'N/A', 1, 0, 'C');
    }

    if ($clockin[$i] !== 'N/A') {
        if ($hoursworked[$i] !== 'null' && $hoursworked[$i] != 'N/A') {
            $pdf->Cell(31, 10, $hoursworked[$i], 1, 1, 'C');
        } else {
            $pdf->Cell(31, 10, '', 1, 1, 'C');
        }
    } else {
        $pdf->Cell(31, 10, 'N/A', 1, 1, 'C');
    }
}

$pdf->Cell(191, 10, '', 0, 1, 'R');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(191, 10, $totalweeklyhrs, 0, 0, 'R');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(191, 10, 'TOTAL WEEKLY HOURS', 0, 1, 'R');

$pdf->Output();
