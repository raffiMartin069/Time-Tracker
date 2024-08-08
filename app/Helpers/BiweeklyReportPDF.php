<?php
require_once __DIR__ . "/../../public/vendor/autoload.php";
class BiweeklyReportPDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Biweekly Timesheet', 0, 1, 'R');
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
        $shift = $data['shift'];
        $dates = $data['date'];
        $clockin = $data['clockin'];
        $lunchduration = $data['lunchduration'];
        $breakduration = $data['breakduration'];
        $clockout = $data['clockout'];
        $hoursworked = $data['hoursworked'];
        $totalbiweeklyhrs = $data['totalbiweeklyhrs'];

        $this->AddPage();

        // Header logo and title
        $this->Image(__DIR__ . '/../../public/assets/img/Sidebar/logo.png', 10, 20, 15);
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(30, 22);
        $this->Cell(0, 10, 'WhereToNextMed', 0, 1);

        $this->Ln(5);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 30, 'Employee Name:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 30, $name, 0, 1);

        $this->Ln(-10);
        $this->SetX(153);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(28, -10, 'Week Starting:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(19, -10, $dates[0], 0, 0);
        $this->Cell(30, 10, '', 0, 1);

        $this->Ln(-23);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(11, 30, 'Shift:', 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 30, $shift, 0, 1);

        $this->Ln(-5);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(35, 10, 'Date', 1, 0, 'C');
        $this->Cell(31, 10, 'Clock In', 1, 0, 'C');
        $this->Cell(31, 10, 'Lunch Duration', 1, 0, 'C');
        $this->Cell(31, 10, 'Break Duration', 1, 0, 'C');
        $this->Cell(31, 10, 'Clock Out', 1, 0, 'C');
        $this->Cell(31, 10, 'Total Hours', 1, 1, 'C');

        $this->SetFont('Arial', '', 10);

        for ($i = 0; $i < count($dates); $i++) {
            if ($dates[$i] == '') {
                continue;
            }

            $this->Cell(35, 10, $dates[$i], 1, 0, 'C');

            if ($clockin[$i] != 'null' && $clockin[$i] != '') {
                $this->Cell(31, 10, $clockin[$i], 1, 0, 'C');
            } else {
                $this->Cell(31, 10, 'N/A', 1, 0, 'C');
            }

            if ($lunchduration[$i] != 'null' && $lunchduration[$i] != '') {
                $this->Cell(31, 10, $lunchduration[$i], 1, 0, 'C');
            } else {
                $this->Cell(31, 10, 'N/A', 1, 0, 'C');
            }

            if ($breakduration[$i] != 'null' && $breakduration[$i] != '') {
                $this->Cell(31, 10, $breakduration[$i], 1, 0, 'C');
            } else {
                $this->Cell(31, 10, 'N/A', 1, 0, 'C');
            }

            if ($clockout[$i] != 'null' && $clockout[$i] != '') {
                $this->Cell(31, 10, $clockout[$i], 1, 0, 'C');
            } else {
                $this->Cell(31, 10, 'N/A', 1, 0, 'C');
            }

            if ($clockin[$i] !== 'N/A') {
                if ($hoursworked[$i] !== 'null' && $hoursworked[$i] != 'N/A') {
                    $this->Cell(31, 10, $hoursworked[$i], 1, 1, 'C');
                } else {
                    $this->Cell(31, 10, '', 1, 1, 'C');
                }
            } else {
                $this->Cell(31, 10, 'N/A', 1, 1, 'C');
            }
        }

        $this->Cell(191, 10, '', 0, 1, 'R');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(191, 10, $totalbiweeklyhrs, 0, 0, 'R');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(191, 10, 'TOTAL BIWEEKLY HOURS', 0, 1, 'R');

        $this->Output();
    }
}
