<?php
require_once('../lib/fpdf.php');

if (isset($_POST['events']) && is_array($_POST['events'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Mes Événements Sélectionnés', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);

    foreach ($_POST['events'] as $eventData) {
        list($titre, $lieu, $date) = explode('|', $eventData);
        $pdf->Cell(0, 10, "📌 Titre: $titre", 0, 1);
        $pdf->Cell(0, 10, "📍 Lieu: $lieu", 0, 1);
        $pdf->Cell(0, 10, "📅 Date: $date", 0, 1);
        $pdf->Ln(5);
    }

    $pdf->Output('D', 'mes_evenements.pdf');
    exit;
} else {
    echo "Aucun événement sélectionné.";
}
?>
