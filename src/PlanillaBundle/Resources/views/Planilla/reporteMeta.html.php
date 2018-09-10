<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
$fechadoc = date("dmYHis");
$suma1 = 0;
$suma2 = 0;
?>

<table width="100%">
    <tr>
        <td style="font-size: 10pt;">
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
        <td style="text-align: center;" style="font-size: 10pt;">
            <b>RESUMEN DE METAS Y CONCEPTOS <?php echo $mesEje->getNombre(); ?> <?php echo $anoEje; ?> ESPECIFICA <?php echo $especifica->getEspecifica(); ?></b>
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt;">
            <table border="1" width="100%;">
                <tr>
                    <th>INGRESOS</th>
                    <?php
                    foreach ($conceptos1 as $concepto) {
                        ?>
                        <th style="text-align: center;">
                            <?php echo $concepto['abreviatura']; ?>
                        </th>
                        <?php
                    }
                    ?>
                    <th style="text-align: center;">TOTAL</th>
                </tr>
                <?php foreach ($arrayMetas1 as $meta) { ?>
                    <tr>
                        <td><?php echo $meta['meta']; ?></td>
                        <?php foreach ($meta['conceptos'] as $concepto) { ?>
                            <td style="text-align: right;"><?php echo number_format($concepto['monto'], 2); ?></td>
                        <?php } ?>
                        <td style="text-align: right;"><b><?php echo number_format($totalesMetas1[$meta['secfunc']]['total'], 2); ?></b></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><b>TOTAL</b></td>
                    <?php
                    foreach ($conceptos1 as $concepto) {
                        ?>
                        <td style="text-align: right;">
                            <b>
                                <?php
                                echo number_format($totalesConceptos1[$concepto['id']]['total'], 2);
                                $suma1 += $totalesConceptos1[$concepto['id']]['total'];
                                ?>
                            </b>
                        </td>
                        <?php
                    }
                    ?>
                    <td style="text-align: right;"><b><?php echo number_format($suma1,2); ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="font-size: 8pt;">
            <table border="1" >
                <tr>
                    <th>EGRESOS</th>
                    <?php
                    foreach ($conceptos2 as $concepto) {
                        ?>
                        <th style="text-align: center;">
                            <?php echo $concepto['abreviatura']; ?>
                        </th>
                        <?php
                    }
                    ?>
                    <th style="text-align: center;">TOTAL</th>
                </tr>
                <?php foreach ($arrayMetas2 as $meta) { ?>
                    <tr>
                        <td><?php echo $meta['meta']; ?></td>
                        <?php foreach ($meta['conceptos'] as $concepto) { ?>
                            <td style="text-align: right;"><?php echo number_format($concepto['monto'], 2); ?></td>
                        <?php } ?>
                        <td style="text-align: right;"><b><?php echo number_format($totalesMetas2[$meta['secfunc']]['total'], 2); ?></b></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><b>TOTAL</b></td>
                    <?php
                    foreach ($conceptos2 as $concepto) {
                        ?>
                        <td style="text-align: right;">
                            <b>
                                <?php
                                echo number_format($totalesConceptos2[$concepto['id']]['total'], 2);
                                $suma2 += $totalesConceptos2[$concepto['id']]['total'];
                                ?>
                            </b>
                        </td>
                        <?php
                    }
                    ?>
                    <td style="text-align: right;"><b><?php echo number_format($suma2,2); ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "landscape");
$dompdf->render();
$dompdf->stream("resumenMetas".$fechadoc.".pdf", array("Attachment" => 0));
?>

