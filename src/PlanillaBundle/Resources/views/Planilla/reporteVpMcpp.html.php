<?php
header("Cache-Control: maxage=1");
header("Pragma: public");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" width="100%">
    <tr>
        <th>DNI</th>
        <th>Apellidos y Nombres</th>
        <th>Cod AIRHCP</th>
        <th>Nombre Concepto</th>
        <th>Tipo Concepto</th>
        <th>Monto</th>
    </tr>
    <?php
    foreach ($planillas as $p) {
        $subtotal = 0;
        $razon = $p->getPlazaHistorial()->getCodPersonal()->getApellidoPaterno() . " " .
                $p->getPlazaHistorial()->getCodPersonal()->getApellidoMaterno() . " " .
                $p->getPlazaHistorial()->getCodPersonal()->getNombre();
        $conceptos = $p->getPlanillaHasConcepto();
        foreach ($conceptos as $c) {
            if ($c->getConcepto()->getTipoConcepto()->getId() == 1) {
                ?>
                <tr>
                    <td><?php echo "'".$p->getPlazaHistorial()->getCodPersonal()->getNumeroDocumento(); ?></td>
                    <td><?php echo $razon; ?></td>
                    <td><?php echo "'".$c->getConcepto()->getMcppConcepto(); ?></td>
                    <td><?php echo $c->getConcepto()->getConcepto(); ?></td>
                    <td><?php echo $c->getConcepto()->getTipoConcepto()->getId(); ?></td>
                    <td style="text-align: right;"><?php echo number_format($c->getMonto(), 2); ?></td>
                </tr>

                <?php
                $subtotal = $subtotal + $c->getMonto();
            }
        }

        foreach ($conceptos as $c) {
            if ($c->getConcepto()->getTipoConcepto()->getId() == 2) {
                ?>
                <tr>
                    <td><?php echo "'".$p->getPlazaHistorial()->getCodPersonal()->getNumeroDocumento(); ?></td>
                    <td><?php echo $razon; ?></td>
                    <td><?php echo "'".$c->getConcepto()->getMcppConcepto(); ?></td>
                    <td><?php echo $c->getConcepto()->getConcepto(); ?></td>
                    <td><?php echo $c->getConcepto()->getTipoConcepto()->getId(); ?></td>
                    <td style="text-align: right;"><?php echo number_format($c->getMonto(), 2); ?></td>
                </tr>

                <?php
                $subtotal = $subtotal - $c->getMonto();
            }
        }
        ?>    
        <tr>
            <td><b><?php echo $p->getPlazaHistorial()->getCodPersonal()->getNumeroDocumento(); ?></b></td>
            <td><b><?php echo $razon; ?></b></td>
            <td><b>9999</b></td>
            <td><b>NETO</b></td>
            <td><b>9</b></td>
            <td style="text-align: right;"><b><?php echo number_format($subtotal, 2); ?></b></td>
        </tr>
    <?php } ?>
</table>

