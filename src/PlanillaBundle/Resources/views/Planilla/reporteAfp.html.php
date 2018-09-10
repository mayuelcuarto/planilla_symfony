<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
$fechadoc = date("dmYHis");
?>


<table border="1" style="font-size: 10pt;" width="100%">
    <tr>
        <td colspan='8'>
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
    <tr><td colspan="8" style="text-align: center;"><b>REPORTE DE AFP <?php echo $tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
                <?php echo $fuente->getNombre(); ?></b></td></tr>

    <tr>
        <th style="text-align: center;">Plaza</th>
        <th style="text-align: center;">Apellidos y Nombres</th>
        <th style="text-align: center;">AFP</th>
        <th style="text-align: center;">Rem. Aseg</th>
        <th style="text-align: center;">Ap. Jub.</th>
        <th style="text-align: center;">Seguros</th>
        <th style="text-align: center;">Com. RA</th>
        <th style="text-align: center;">TOTAL</th>
    </tr>
    <?php
    $sumaRemAseg = 0;
    $sumaJub = 0;
    $sumaSeguros = 0;
    $sumaRA = 0;
    $sumaTotal = 0;
    foreach ($planillas as $p) {
        $suma = 0;
        $conceptos = $p->getPlanillaHasConcepto();
        if ($p->getPlazaHistorial()->getAfp()->getId() != 12 and $p->getPlazaHistorial()->getAfp()->getId() != 15 and $p->getPlazaHistorial()->getAfp()->getId() != 99) {
            ?>
            <tr>
                <td><?php echo $p->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId() . "-" . $p->getPlazaHistorial()->getPlaza()->getNumPlaza(); ?></td>
                <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " . $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . ", " . $p->getPlazaHistorial()->getCodPersonal()->getNombre(); ?></td>
                <td><?php echo $p->getPlazaHistorial()->getAfp()->getNombre(); ?></td>
                <td style="text-align: right;">
                    <?php
                    echo number_format($p->getRemaseg(), 2);
                    $sumaRemAseg += $p->getRemaseg();
                    ?>
                </td>
                <td style="text-align: right;">
                    <?php
                    foreach ($conceptos as $c) {
                        if ($c->getConcepto()->getId() == 78) {
                            echo number_format($c->getMonto(), 2);
                            $suma += $c->getMonto();
                            $sumaJub += $c->getMonto();
                        }
                    }
                    ?>
                </td>
                <td style="text-align: right;">
                    <?php
                    foreach ($conceptos as $c) {
                        if ($c->getConcepto()->getId() == 79) {
                            echo number_format($c->getMonto(), 2);
                            $suma += $c->getMonto();
                            $sumaSeguros += $c->getMonto();
                        }
                    }
                    ?>
                </td>
                <td style="text-align: right;">
                    <?php
                    foreach ($conceptos as $c) {
                        if ($c->getConcepto()->getId() == 80) {
                            echo number_format($c->getMonto(), 2);
                            $suma += $c->getMonto();
                            $sumaRA += $c->getMonto();
                        }
                    }
                    ?>
                </td>
                <td style="text-align: right;">
                    <?php echo number_format($suma, 2); ?>
                </td>
            </tr>
            <?php
            $sumaTotal += $suma;
        }
    }
    ?>
    <tr>
        <td colspan="3" style="text-align: center;"><b>TOTAL</b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaRemAseg, 2); ?></b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaJub, 2); ?></b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaSeguros, 2); ?></b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaRA, 2); ?></b></td>
        <td style="text-align: right;"><b><?php echo number_format($sumaTotal, 2); ?></b></td>
    </tr>
</table>

<table width="100%" border="1">
    <tr>
        <th style="text-align: center;">AFP</th>
        <th colspan="2" style="text-align: center;">Aporte Jubilacion</th>
        <th colspan="2" style="text-align: center;">Seguros</th>
        <th colspan="2" style="text-align: center;">Comision RA</th>
        <th colspan="2" style="text-align: center;">Comision RA Mx</th>
    </tr>
    <?php
    $sumaJub2 = 0;
    $sumaSeg2 = 0;
    $sumaRA2 = 0;
    $sumaRAMix2 = 0;
    
    foreach ($arrayAfp as $afp) {
        if ($afp['id'] != 12 and $afp['id'] != 15 and $afp['id'] != 99) {
            $sumaJub2 += $afp['jubMonto'];
            $sumaSeg2 += $afp['segMonto'];
            $sumaRA2 += $afp['raMonto'];
            $sumaRAMix2 += $afp['raMixMonto'];
            ?>
            <tr>
                <td><?php echo $afp['nombre']; ?></td>
                <td style="text-align: right;"><?php echo ($afp['jubilacion'] * 100)."%"; ?></td>
                <td style="text-align: right;"><?php echo number_format($afp['jubMonto'],2); ?></td>
                <td style="text-align: right;"><?php echo ($afp['seguros'] * 100)."%"; ?></td>
                <td style="text-align: right;"><?php echo number_format($afp['segMonto'],2); ?></td>
                <td style="text-align: right;"><?php echo ($afp['ra'] * 100)."%"; ?></td>
                <td style="text-align: right;"><?php echo number_format($afp['raMonto'],2); ?></td>
                <td style="text-align: right;"><?php echo ($afp['raMixta'] * 100)."%"; ?></td>
                <td style="text-align: right;"><?php echo number_format($afp['raMixMonto'],2); ?></td>
            </tr>
            <?php
        }
    }
    ?>
            <tr>
                <td rowspan="2" style="text-align: center;"><b>TOTAL</b></td>
                <td rowspan="2" colspan="2" style="text-align: right;"><b><?php echo number_format($sumaJub2,2); ?></b></td>
                <td rowspan="2" colspan="2" style="text-align: right;"><b><?php echo number_format($sumaSeg2,2); ?></b></td>
                <td colspan="2" style="text-align: right;"><b><?php echo number_format($sumaRA2,2); ?></b></td>
                <td colspan="2" style="text-align: right;"><b><?php echo number_format($sumaRAMix2,2); ?></b></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;"><b><?php echo number_format(($sumaRA2 + $sumaRAMix2),2); ?></b></td>
            </tr>
</table>
<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream("reporteAfp".$fechadoc.".pdf", array("Attachment" => 0));
?>

