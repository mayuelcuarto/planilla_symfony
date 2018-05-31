<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
?>
<table border="1" style="font-size: 10pt;" width="100%">
    <tr>
        <td colspan="2">
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
    <tr>
        <td style="text-align: center;" colspan="2">
            <b>RESUMEN DE PLANILLA <?php echo $tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
                <?php echo $fuente->getNombre(); ?></b>
        </td>
    </tr>
    <tr>
        <td width="40%" style="vertical-align: top;">
            <table width="100%">
                <tr>
                    <td>
                        <table border="1" width="100%">
                            <thead>
                                <tr><th colspan="2" style="text-align: center;">TOTALES</th></tr>
                            </thead>
                            <tbody>
                                <tr><td width="70%"><b>Remuneracion Asegurable</b></td><td width="30%" style="text-align: right;"><?php echo number_format($sumaRemAseg, 2); ?></td></tr>
                                <tr><td><b>Remuneracion No Asegurable</b></td><td style="text-align: right;"><?php echo number_format($sumaRemNoAseg, 2); ?></td></tr>
                                <tr><td><b>Total Ingresos</b></td><td style="text-align: right;"><?php echo number_format(($sumaRemAseg + $sumaRemNoAseg), 2); ?></td></tr>
                                <tr><td><b>Total Egresos</b></td><td style="text-align: right;"><?php echo number_format($sumaTotalEgreso, 2); ?></td></tr>
                                <tr><td><b>Total Neto</b></td><td style="text-align: right;"><?php echo number_format((($sumaRemAseg + $sumaRemNoAseg) - $sumaTotalEgreso), 2); ?></td></tr>
                                <tr><td><b>Cuota Patronal</b></td><td style="text-align: right;"><?php echo number_format($sumaPatronal, 2); ?></td></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="60%" style="vertical-align: top;">
            <table width="100%">
                <tr>
                    <td style="vertical-align: top;">
                        <table border="1" width="100%">
                            <thead>
                                <tr><th colspan="2" style="text-align: center;">INGRESOS</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($conceptos as $concepto) {
                                    if ($concepto['monto'] > 0) {
                                        if ($concepto['tipo'] == 1) {
                                            ?>
                                            <tr>
                                                <td><?php echo $concepto['abreviatura']; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($concepto['monto'], 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                    <td style="vertical-align: top;">
                        <table border="1" width="100%">
                            <thead>
                                <tr><th colspan="2" style="text-align: center;">EGRESOS</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($conceptos as $concepto) {
                                    if ($concepto['monto'] > 0) {
                                        if ($concepto['tipo'] == 2) {
                                            ?>
                                            <tr>
                                                <td><?php echo $concepto['abreviatura']; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($concepto['monto'], 2); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>


</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream("resumen.pdf", array("Attachment" => 0));
?>

