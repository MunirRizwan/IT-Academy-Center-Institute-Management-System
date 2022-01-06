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

        $this->Cell(30, 5, "(" . $sessionTitle2 . ")");
        $this->Ln(20);
    }

    function headerTable() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(10, 10, "Admission Fee Record:");
        $this->Ln();
        $this->SetFont('Times', 'B', 10);
        $this->Cell(10, 10, "SNO", 1, 0, 'C');
        $this->Cell(25, 10, "Name", 1, 0, 'C');
        $this->Cell(25, 10, "Father Name", 1, 0, 'C');
        $this->Cell(25, 10, "Address", 1, 0, 'C');
        $this->Cell(25, 10, "Contact", 1, 0, 'C');
        $this->Cell(25, 10, "A-Fee", 1, 0, 'C');
        $this->Cell(25, 10, "Submit Date", 1, 0, 'C');
        $this->Cell(25, 10, "Status", 1, 0, 'C');
        $this->Ln();
    }

    function viewTable($s, $f, $sno) {
        $this->SetFont('Times', '', 10);

        $this->Cell(10, 10, $sno, 1, 0, 'C');
        $this->Cell(25, 10, $s->student_name, 1, 0, 'C');
        $this->Cell(25, 10, $s->student_fname, 1, 0, 'C');
        $this->Cell(25, 10, $s->student_address, 1, 0, 'C');
        $this->Cell(25, 10, $s->student_mobile, 1, 0, 'C');
        if (empty($f)) {
            $this->Cell(25, 10, "NULL", 1, 0, 'C');
            $this->Cell(25, 10, "NOT ISSUED", 1, 0, 'C');
            $this->Cell(25, 10, "NULL", 1, 0, 'C');
        } else {
            $this->Cell(25, 10, $f->admission_fee, 1, 0, 'C');
            if ($f->status == 1) {
                $this->SetFont('Times', '', 12);
                $this->Cell(25, 10, $f->submit_date, 1, 0, 'C');
                $this->SetFont('Times', 'B', 12);
                $this->Cell(25, 10, "Submitted", 1, 0, 'C');
            } else {
                $this->Cell(25, 10, "NULL", 1, 0, 'C');
                $this->Cell(25, 10, "Pending", 1, 0, 'C');
            }
        }

        $this->Ln();
    }

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->setD($db, $sessionId);
$pdf->AddPage();


$rs = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
$pdf->Ln(10);
$pdf->headerTable();
$sno = 1;
foreach ($rs as $key) {

    $admissionFee = $db->fetch_multi_row('admission_tbl', array('admission_id', 'status', 'admission_fee', 'submit_date'), array('student_id' => $key->student_id, 'session_id' => $sessionId));
    $check = TRUE;
    foreach ($admissionFee as $akey) {
        $check = FALSE;
        $pdf->viewTable($key, $akey, $sno++);
    }
    if ($check) {
        $pdf->viewTable($key, "", $sno++);
    }
}
$pdf->Output();
?>

