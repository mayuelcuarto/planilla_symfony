<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
$fechadoc = date("dmYHis");
?>
<table border="1" style="font-size: 10pt;" width="100%">
    <tr>
        <td colspan='3'>
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
    <tr><td colspan="3" style="text-align: center;"><b>RESUMEN DE PLANILLA POR CONCEPTO <?php echo $tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
                <?php echo $fuente->getNombre(); ?> - <?php echo $concepto->getConcepto(); ?></b></td></tr>
    <tr>
        <th style="text-align: center;">Plaza</th>
        <th style="text-align: center;">Apellidos y Nombres</th>
        <th style="text-align: center;">Monto</th>
    </tr>
    <?php
    $suma = 0;
    foreach ($planillas as $p) {
        $conceptos = $p->getPlanillaHasConcepto();
        foreach ($conceptos as $c) {
            if ($c->getConcepto()->getId() == $concepto->getId()) {
                $suma += $c->getMonto();
                ?>
                <tr>
                    <td><?php echo $p->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId() . "-" . $p->getPlazaHistorial()->getPlaza()->getNumPlaza(); ?></td>
                    <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " . $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . ", " . $p->getPlazaHistorial()->getCodPersonal()->getNombre(); ?></td>
                    <td style="text-align: right;"><?php echo number_format($c->getMonto(), 2); ?></td>
                </tr>
                <?php
            }
        }
    }
    ?>
    <tr>
        <td colspan="2" style="text-align: center;"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo number_format($suma, 2); ?></b></td>
    </tr>
</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream("reporteConcepto".$fechadoc.".pdf", array("Attachment" => 0));
?>

