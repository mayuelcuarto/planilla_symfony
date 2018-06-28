<?php

use Dompdf\Dompdf;

ob_start();
$fecha = date("d/m/Y");
$hora = date("H:i:s");
$contador = count($planillas);
$contador_d = 0;
?>

<?php
foreach ($planillas as $p) {
    $contador_d++;
    $conceptos = $p->getPlanillaHasConcepto();
    if($tipoPlanilla->getId() == 1 or $tipoPlanilla->getId() == 4){
        $titulo = "PLANILLA DE PAGOS";
    }else{
        $titulo = "PLANILLA DE OBLIGACIONES PREVISIONALES";
    }
    ?>
    <table border="1" style="font-size: 10pt;" width="100%">
        <tr>
            <td colspan='2'>
                <table width="100%">
                    <tr>
                        <td align='left'><b>ARCHIVO GENERAL DE LA NACION</b></td>
                        <td align='right'>Fecha: <?php echo $fecha; ?></td>
                    </tr>
                    <tr>
                        <td align='left'><b>RUC</b>: 20131370726</td>
                        <td align='right'>Hora: <?php echo $hora; ?></td>
                    </tr>
                    <tr>
                        <td align='left'>Fecha de Generacion: <?php echo $p->getFechaGeneracion()->format("d/m/Y"); ?></td>
                        <td align='right'>Fecha de Pago: <?php echo $p->getFechaPago()->format("d/m/Y"); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <b><?php echo $titulo." ".$tipoPlanilla->getNombre(); ?> <?php echo $anoEje; ?> - <?php echo $mesEje->getNombre(); ?><br>
    <?php echo $fuente->getNombre(); ?></b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <table width="100%">
                    <tr>
                        <td><b>Sector</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getEjecutora()->getPliego()->getSector()->getNombre(); ?></td>
                        <td><b>Actividad</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getActProy()->getNombre(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Pliego</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getEjecutora()->getPliego()->getNombre(); ?></td>
                        <td><b>Funcion</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getFuncion()->getNombre(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Unidad Ejecutora</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getEjecutora()->getNombre(); ?></td>
                        <td><b>Div. Funcional</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getDivfunc()->getNombre(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Fuente</b></td>
                        <td><?php echo $p->getFuente()->getNombre(); ?></td>
                        <td><b>GRPF</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getGrpf()->getNombre(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Programa</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getPrograma()->getNombre(); ?></td>
                        <td><b>Meta</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getFinalidad(); ?> <?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getNombre(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Producto</b></td>
                        <td><?php echo $p->getPlazaHistorial()->getPlaza()->getSecFunc()->getProducto()->getNombre(); ?></td>
                        <td><b>Esp. de Gasto</b></td>
                        <td><?php echo $p->getEspecifica()->getEspecifica(); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Apellidos y Nombres</b> 
    <?php echo $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " . $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . ", " . $p->getPlazaHistorial()->getCodPersonal()->getNombre(); ?>
            </td>
        </tr>
        <tr>
            <td width="40%" style="vertical-align: top;">
                <table width="100%">
                    <thead>
                        <tr><th colspan="2" style="text-align: center;"><b>DATOS LABORALES</b></th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Plaza</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId() . "-" . $p->getPlazaHistorial()->getPlaza()->getNumPlaza(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Cargo</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getCargo(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Unidad Organica</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getUnidad()->getAbrev(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Grupo Ocupacional</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getPlaza()->getCategoria()->getGrupoOcupacional()->getNombre(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Categoria</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getPlaza()->getCategoria()->getAbreviatura(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Condicion Laboral</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getCondicionLaboral()->getNombre(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Regimen Laboral</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getRegimenLaboral()->getNombre(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Regimen Pensionario</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getRegimenPensionario()->getNombre(); ?></td>
                        </tr>
                        <tr>
                            <td><b>AFP/ONP</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getAfp()->getNombre(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Fecha Ingreso</b></td>
                            <td><?php echo $p->getFechaIng()->format("d/m/Y"); ?></td>
                        </tr>
                        <tr>
                            <td><b>DNI/LE</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getNumeroDocumento(); ?></td>
                        </tr>
                        <tr>
                            <td><b>Num Autogenerado</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getNumAutogenerado(); ?></td>
                        </tr>
                        <tr>
                            <td><b>CUSPP</b></td>
                            <td><?php echo $p->getPlazaHistorial()->getCodPersonal()->getCuspp(); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <table border="1" width="100%">
                                    <thead>
                                        <tr><th colspan="2" style="text-align: center;">TOTALES</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr><td width="70%"><b>Remuneracion Asegurable</b></td><td width="30%" style="text-align: right;"><?php echo number_format($p->getRemAseg(), 2); ?></td></tr>
                                        <tr><td><b>Remuneracion No Asegurable</b></td><td style="text-align: right;"><?php echo number_format($p->getRemNoaseg(), 2); ?></td></tr>
                                        <tr><td><b>Total Ingresos</b></td><td style="text-align: right;"><?php echo number_format(($p->getRemAseg() + $p->getRemNoaseg()), 2); ?></td></tr>
                                        <tr><td><b>Total Egresos</b></td><td style="text-align: right;"><?php echo number_format($p->getTotalEgreso(), 2); ?></td></tr>
                                        <tr><td><b>Total Neto</b></td><td style="text-align: right;"><?php echo number_format((($p->getRemAseg() + $p->getRemNoaseg()) - $p->getTotalEgreso()), 2); ?></td></tr>
                                        <tr><td><b>Cuota Patronal</b></td><td style="text-align: right;"><?php echo number_format($p->getPatronal(), 2); ?></td></tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>NOTA</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: justify;"><?php echo $p->getNota(); ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td width="60%" style="vertical-align:top;">
                <table width="100%">
                    <tr>
                        <td width="50%" style="vertical-align:top;">
                            <table border="1" style="font-size: 10pt;" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;">INGRESOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($conceptos as $c) {
                                        if ($c->getConcepto()->getTipoConcepto()->getId() == 1) {
                                            ?>
                                            <tr>
                                                <td><?php echo $c->getConcepto()->getAbreviatura(); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($c->getMonto(), 2); ?></td>    
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%" style="vertical-align:top;">
                            <table border="1" style="font-size: 10pt;" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center;">EGRESOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($conceptos as $c) {
                                        if ($c->getConcepto()->getTipoConcepto()->getId() == 2) {
                                            ?>
                                            <tr>
                                                <td><?php echo $c->getConcepto()->getAbreviatura(); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($c->getMonto(), 2); ?></td>    
                                            </tr>
                                            <?php
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
    <?php if ($contador_d < $contador) { ?>
        <div style="page-break-after:always;"></div>
    <?php } ?>
<?php } ?>

<?php
//generate some PDFs!

$dompdf = new DOMPDF(); //if you use namespaces you may use new \DOMPDF()
$dompdf->loadHtml(ob_get_clean());
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream("reporte.pdf", array("Attachment" => 0));
?>

