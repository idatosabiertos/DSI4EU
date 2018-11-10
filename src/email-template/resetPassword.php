<?php
/** @var \DSI\Entity\PasswordRecovery $passwordRecovery */
?>
Welcome to <a href="https://<?php echo SITE_DOMAIN ?>/">exploralat.am</a>,
<br/><br/>
Por favor <a href="https://<?php echo SITE_DOMAIN ?>/reset-password">haga click aquí</a>
para restablecer su contraseña.<br/>
Su código de seguridad es: <b><?php echo $passwordRecovery->getCode() ?></b>
<br/><br/>
Por razones de seguridad, este código expirará en 24 horas. Puede volver a generarlo luego de 24 horas
<br /><br />

Después de completar su registro podrá agregar un proyecto u organización,
únase a proyectos y organizaciones existentes.