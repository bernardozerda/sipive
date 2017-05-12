<?php

//COMO EL INPUT FILE FUE LLAMADO archivo ENTONCES ACCESAMOS A TRAVÃ‰S DE $_FILES["archivo"]
?>
<table align="center">
    <tr>
        <td>
            <b>Nombre:</b>: <?php echo $_FILES["archivo"]["name"] ?>

            <b>Tipo:</b>: <?php echo $_FILES["archivo"]["type"] ?>

            <b>Subida:</b>: <?php echo ($_FILES["archivo"]["error"]) ? "Incorrecta" : "Correcta" ?>

            <b>TamaÃ±o:</b>: <?php echo $_FILES["archivo"]["size"] ?> bytes
        </td>
    </tr>
</table>


<?php
//SI EL ARCHIVO SE ENVIÃ“ Y ADEMÃS SE SUBIO CORRECTAMENTE
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {

} else
    echo "Error de subida";
?> 
