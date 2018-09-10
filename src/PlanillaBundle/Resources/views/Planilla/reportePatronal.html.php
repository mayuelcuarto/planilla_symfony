<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
$fechadoc = date("dmYHis");
?>
<table border="1" style="font-size: 10pt;" width="100%">
    <tr>
        <td colspan='4'>
            <table width="100%">
                <tr>
                    <td align='left'><b>ARCHIVO GENERAL DE LA NACION</b></td>
                    <td align='right'>Fecha: <?php echo $fecha; ?></td>
                </tr>
                <tr>
                    <td align='left'><b>RUC</b>: 20131370726</td>
                    <td align='right'>Hora: <?php echo $hora; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="4" style="text-align: center;"><b>RESUMEN CUOTA PATRONAL <?php echo $tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
<?php echo $fuente->getNombre(); ?></b></td></tr>
    <tr>
        <th style="text-align: center;">Plaza</th>
        <th style="text-align: center;">Apellidos y Nombres</th>
        <th style="text-align: center;">Rem. Aseg</th>
        <th style="text-align: center;">Cuota Patronal</th>
    </tr>
<?php foreach ($planillas as $p) { ?>

        <tr>
            <td><?php echo $p->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId() . "-" . $p->getPlazaHistorial()->getPlaza()->getNumPlaza(); ?></td>
            <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " . $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . ", " . $p->getPlazaHistorial()->getCodPersonal()->getNombre(); ?></td>
            <td style="text-align: right;"><?php echo number_format($p->getRemAseg(), 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($p->getPatronal(), 2); ?></td>
        </tr>
<?php } ?>
    <tr>
        <td colspan="2" style="text-align: center;"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaRemAseg, 2); ?></b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaPatronal, 2); ?></b></td>
    </tr>
</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream("resumenPatronal".$fechadoc.".pdf", array("Attachment" => 0));
?>

