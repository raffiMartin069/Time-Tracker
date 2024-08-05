<?php
require_once __DIR__ . "/../../public/vendor/autoload.php";
class DailyReportPDF extends FPDF
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

    public function createPDFReport($data)
    {
        $name = $data['name'];
        $date = $data['date'];
        $clockin = $data['clockin'];
        $lunchduration = $data['lunchduration'];
        $breakduration = $data['breakduration'];
        $clockout = $data['clockout'];
        $hoursworked = $data['hoursworked'];

        $this->AddPage();

        // Header logo and title
        $this->Image(__DIR__ . '/../../public/assets/img/Sidebar/logo.png', 10, 20, 15);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(30, 22);
        $this->Cell(0, 10, 'WhereToNextMed', 0, 1);

        // Table Headers
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(20);
        $this->Cell(30, 30, 'Employee Name:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 30, $name, 0, 1);

        $this->Ln(-5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(35, 10, 'Date', 1, 0, 'C');
        $this->Cell(31, 10, 'Clocked In', 1, 0, 'C');
        $this->Cell(31, 10, 'Lunch Duration', 1, 0, 'C');
        $this->Cell(31, 10, 'Break Duration', 1, 0, 'C');
        $this->Cell(31, 10, 'Clock Out', 1, 0, 'C');
        $this->Cell(31, 10, 'Total Hours', 1, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(35, 10, $date, 1, 0, 'C');

        // Custom result to avoid null and undefined values
        if ($clockin != 'null' && $clockin != '') {
            $this->Cell(31, 10, $clockin, 1, 0, 'C');
        } else {
            $this->Cell(31, 10, 'N/A', 1, 0, 'C');
        }

        if ($lunchduration != 'null' && $lunchduration != '') {
            $this->Cell(31, 10, $lunchduration, 1, 0, 'C');
        } else {
            $this->Cell(31, 10, 'N/A', 1, 0, 'C');
        }

        if ($breakduration != 'null' && $breakduration != '') {
            $this->Cell(31, 10, $breakduration, 1, 0, 'C');
        } else {
            $this->Cell(31, 10, 'N/A', 1, 0, 'C');
        }
        if ($clockout != 'null' && $clockout != '') {
            $this->Cell(31, 10, $clockout, 1, 0, 'C');
        } else {
            $this->Cell(31, 10, 'N/A', 1, 0, 'C');
        } 

        if ($clockin !== 'N/A') {
            if ($hoursworked !== 'null' && $hoursworked != 'N/A') {
                $this->Cell(31, 10, $hoursworked, 1, 1, 'C');
            } else {
                $this->Cell(31, 10, '', 1, 1, 'C');
            }
        } else {
            $this->Cell(31, 10, 'N/A', 1, 1, 'C');
        }

        $this->Output();
    }
}
