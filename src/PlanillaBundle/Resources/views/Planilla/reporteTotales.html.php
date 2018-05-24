<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
?>
<table border="1" style="font-size: 10pt;" width="100%">
    <tr>
        <td colspan='7'>
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
    <tr><td colspan="7" style="text-align: center;"><b>RESUMEN TOTAL <?php echo $tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
                <?php echo $fuente->getNombre(); ?></b></td></tr>
    <tr>
        <th style="text-align: center;">Plaza</th>
        <th style="text-align: center;">Apellidos y Nombres</th>
        <th style="text-align: center;">Rem. Aseg</th>
        <th style="text-align: center;">Rem. NoAseg</th>
        <th style="text-align: center;">Ingresos</th>
        <th style="text-align: center;">Egresos</th>
        <th style="text-align: center;">Neto</th>
    </tr>
    <?php foreach ($planillas as $p) { ?>

        <tr>
            <td><?php echo $p->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId() . "-" . $p->getPlazaHistorial()->getPlaza()->getNumPlaza(); ?></td>
            <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " . $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . ", " . $p->getPlazaHistorial()->getCodPersonal()->getNombre(); ?></td>
            <td style="text-align: right;"><?php echo $p->getRemAseg(); ?></td>
            <td style="text-align: right;"><?php echo $p->getRemNoaseg(); ?></td>
            <td style="text-align: right;"><?php echo ($p->getRemAseg() + $p->getRemNoaseg()); ?></td>
            <td style="text-align: right;"><?php echo $p->getTotalEgreso(); ?></td>
            <td style="text-align: right;"><?php echo (($p->getRemAseg() + $p->getRemNoaseg()) - $p->getTotalEgreso()); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="2" style="text-align: center;"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo $sumaRemAseg; ?></b></td>
        <td style="text-align: right;"><b><?php echo $sumaRemNoAseg; ?></b></td>
        <td style="text-align: right;"><b><?php echo ($sumaRemAseg + $sumaRemNoAseg); ?></b></td>
        <td style="text-align: right;"><b><?php echo $sumaTotalEgreso; ?></b></td>
        <td style="text-align: right;"><b><?php echo (($sumaRemAseg + $sumaRemNoAseg) - $sumaTotalEgreso); ?></b></td>
    </tr>
</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->render();
$dompdf->stream("totales.pdf", array("Attachment" => 0));
?>

