<?php

require_once './userSession.php';
$sessionId = "";
if (isset($_GET['session'])) {
    $sessionId = $_GET['session'];
} else {
    header('Location: dashBoard.php');
}

require('./pdf/fpdf.php');

class PDF extends FPDF {

    var $d, $sessionId;

    function setD($db, $s) {
        $this->d = $db;
        $this->sessionId = $s;
    }

// Page header
    function Header() {
        $sessionTitle = $this->d->fetch_multi_row('session_tbl', array('session_title'), array('session_id' => $this->sessionId));
        foreach ($sessionTitle as $skey) {
            $sessionTitle2 = $skey->session_title;
        }

        // Logo
        $this->Image('logo.png', 10, 6, 20);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(50);
        // Title
        $this->Cell(30, 5, 'MAX TECH COMPUTER INSTITUTE');
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(5);
        // Move to the right
        $this->Cell(65);

        $this->Cell(30, 5, "(".$sessionTitle2.")");
        $this->Ln(20);
    }

// Page footer
    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function studentInfo($s) {
        $this->SetFont('Times', 'B', 12);
        $this->Cell(10, 10, "Name: $s->student_name");
        $this->Cell(100);
        $this->Cell(10, 10, "Father Name: $s->student_fname");
        $this->Ln(6);
        $this->Cell(10, 10, "Address: $s->student_address");
        $this->Cell(100);
        $this->Cell(10, 10, "Contact: $s->student_mobile");
        $this->Ln(6);

        $this->Ln(10);
    }

    function headerTable() {
        $this->SetFont('Times', 'B', 12);
        $this->Cell(10, 10, "SNO", 1, 0, 'C');
        $this->Cell(40, 10, "Month", 1, 0, 'C');
        $this->Cell(40, 10, "Fee Amount", 1, 0, 'C');
        $this->Cell(40, 10, "Issue Date", 1, 0, 'C');
        $this->Cell(20, 10, "status", 1, 0, 'C');
        $this->Cell(40, 10, "Submit Date", 1, 0, 'C');
        $this->Ln();
    }

    function viewTable($f) {
        $this->SetFont('Times', '', 12);
        $sno = 1;
        foreach ($f as $k) {
            $this->Cell(10, 10, $sno++, 1, 0, 'C');
            $this->Cell(40, 10, $k->month, 1, 0, 'C');
            $this->Cell(40, 10, $k->fee_amount, 1, 0, 'C');
            $this->Cell(40, 10, $k->fee_date, 1, 0, 'C');
            if ($k->status == 1) {
                $this->SetFont('Times', 'B', 12);
                $this->Cell(20, 10, "PAID", 1, 0, 'C');
                $this->SetFont('Times', '', 12);
                $this->Cell(40, 10, $k->fee_sumit_date, 1, 0, 'C');
            } else {
                $this->Cell(20, 10, "Pending", 1, 0, 'C');
                $this->Cell(40, 10, "NULL", 1, 0, 'C');
            }
            $this->Ln();
        }
    }

    function dmcDiplomaHeaderTable() {
        $this->SetFont('Times', 'B', 12);
        $this->Cell(10, 10, "SNO", 1, 0, 'C');
        $this->Cell(30, 10, "Certipicate", 1, 0, 'C');
        $this->Cell(50, 10, "Recived Refrence Name", 1, 0, 'C');
        $this->Cell(50, 10, "Recived Refrence CNIC", 1, 0, 'C');
        $this->Cell(30, 10, "Issue Date", 1, 0, 'C');
        $this->Cell(20, 10, "Status", 1, 0, 'C');

        $this->Ln();
    }

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->setD($db, $sessionId);


$rs = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
foreach ($rs as $key) {
    $pdf->AddPage();
    $pdf->studentInfo($key);
    $dmc = $db->fetch_multi_row('dmc_tbl', array('status', 'recived_ref_name', 'nic', 'issue_date'), array('student_id' => $key->student_id));

    $countStudent = $db->countRow("SELECT COUNT(*) FROM dmc_tbl where student_id = '$key->student_id'");
    if ($countStudent > 0) {
        $pdf->Cell(50, 10, "Accadamic Record:");
        $pdf->Ln(10);
        $pdf->dmcDiplomaHeaderTable();
    }
    $pdf->SetFont('Times', '', 12);
    $sno = 1;
    foreach ($dmc as $k) {
        $pdf->Cell(10, 10, $sno++, 1, 0, 'C');
        $pdf->Cell(30, 10, "DMC", 1, 0, 'C');
        if ($k->status == 1) {
            $pdf->Cell(50, 10, $k->recived_ref_name, 1, 0, 'C');
            $pdf->Cell(50, 10, $k->nic, 1, 0, 'C');
            $pdf->Cell(30, 10, $k->issue_date, 1, 0, 'C');
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(20, 10, "ISSUED", 1, 0, 'C');
        } else {
            $pdf->Cell(50, 10, "NULL", 1, 0, 'C');
            $pdf->Cell(50, 10, "NULL", 1, 0, 'C');
            $pdf->Cell(30, 10, "NULL", 1, 0, 'C');
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(20, 10, "Not Issued", 1, 0, 'C');
        }
        $pdf->Ln();
    }

    $diploma = $db->fetch_multi_row('diploma_tbl', array('status', 'recived_ref_name', 'nic', 'issue_date'), array('student_id' => $key->student_id));

    $pdf->SetFont('Times', '', 12);
    foreach ($diploma as $k) {
        $pdf->Cell(10, 10, $sno++, 1, 0, 'C');
        $pdf->Cell(30, 10, "Diploma", 1, 0, 'C');
        if ($k->status == 1) {
            $pdf->Cell(50, 10, $k->recived_ref_name, 1, 0, 'C');
            $pdf->Cell(50, 10, $k->nic, 1, 0, 'C');
            $pdf->Cell(30, 10, $k->issue_date, 1, 0, 'C');
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(20, 10, "ISSUED", 1, 0, 'C');
        } else {
            $pdf->Cell(50, 10, "NULL", 1, 0, 'C');
            $pdf->Cell(50, 10, "NULL", 1, 0, 'C');
            $pdf->Cell(30, 10, "NULL", 1, 0, 'C');
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(20, 10, "Not Issued", 1, 0, 'C');
        }
        $pdf->Ln();
    }
    $pdf->Ln(10);


    $pdf->Cell(50, 10, "Fee Record:");
    $pdf->Ln(10);
    $pdf->headerTable();
    $fee = $db->fetch_multi_row('fee_tbl', array('status', 'fee_amount', 'month', 'fee_date', 'fee_sumit_date'), array('student_id' => $key->student_id));
    $pdf->viewTable($fee);
}
$pdf->Output();




?>

