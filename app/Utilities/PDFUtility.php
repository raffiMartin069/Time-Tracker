<?php
require_once __DIR__ . "/../../public/vendor/autoload.php";
class PDFUtility
{
    public function createPDF($data = [], $title = 'Employee Credentials')
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'B', 16);

        // Logo
        $logoWidth = 20; // Adjust the logo width to fit the header
        $logoHeight = $logoWidth * (190 / 198); // Maintain aspect ratio
        $pdf->Image(__DIR__ . '/../../public/assets/img/login/logo_wtn.png', 10, 10, $logoWidth, $logoHeight);

        // Company Name next to the logo
        $pdf->SetY(10 + ($logoHeight / 2) - 5); // Vertically center the company name with the logo
        $pdf->SetX(10 + $logoWidth + 5); // 5 units right from the logo
        $pdf->Cell(0, 10, 'WhereToNextMed', 0, 2);

        // Employee Credentials title below the logo and company name
        $pdf->SetY(10 + $logoHeight + 5); // Move below the logo
        $pdf->SetX(10); // Align to the left
        
        $pdf->Ln(15);
        $pdf->Cell(0, 10, $title, 0, 2);

        // Current Date below the title
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetX(10); // Align to the left
        $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1);

        // Introduction Paragraph
        $pdf->Ln(10); // Add a small space before the introduction
        
        $introTextFile = ROOT."resources/DPA.txt"; // Specify the correct path to your txt file
        $introText = file_get_contents($introTextFile);

        $pdf->MultiCell(0, 6, $introText, 0, 'J');
        $pdf->Ln(5); // Add a small space before the table

        // Table Header
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Employee ID', 1, 0, 'C'); // Center aligned
        $pdf->Cell(60, 10, 'Login ID', 1, 0, 'C');    // Center aligned
        $pdf->Cell(90, 10, 'Password', 1, 1, 'C');    // Center aligned and move to the next line

        // Reset font for data rows
        $pdf->SetFont('Helvetica', '', 12);

        try {
            foreach ($data as $row) {
                // Check if $row is an object or an array
                if (is_object($row) || is_array($row)) {
                    // Extract data from the object or array
                    $emp_id = isset($row->emp_id) ? $row->emp_id : '';
                    $login_id = isset($row->login_id) ? $row->login_id : '';
                    $password = isset($row->password) ? $row->password : '';
    
                    // Output data to PDF with center alignment
                    $pdf->Cell(40, 10, $emp_id, 1, 0, 'C');
                    $pdf->Cell(60, 10, $login_id, 1, 0, 'C');
                    $pdf->Cell(90, 10, $password, 1, 1, 'C');
                }
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
            exit;
        }


        // Output the PDF as a string
        $pdfContent = $pdf->Output('S');
        // Encode the PDF content in base64
        $base64Pdf = base64_encode($pdfContent);
        return $base64Pdf; // Return the base64 encoded PDF
    }
}