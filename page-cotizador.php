<?php
/**
 * Template name: cotizador
 */

get_header();
$id = $_GET['prod'];

if (!$_POST) {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-6 m-auto">
                <h1 class="text-center quotation-title">
                    <strong>Solicitud </strong><br/><?php echo get_the_title($id) ?>
                </h1>
            </div>
            <div class="col-6">
                <div class="img-featured text-center">
                    <?php echo get_the_post_thumbnail($id, [200, 300]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #e5e4e9">
        <div class="container">
            <div class="row">
                <div class="col-12 my-5">
                    <form class="form" method="post" action="<?php echo home_url('/cotizaciones/') ?>">
                        <input type="hidden" name="id" value="<?php echo $id ?>"/>
                        <div class="form-group row">
                            <label class="col-2 text-right">Nombre *</label>
                            <div class="col-7">
                                <input type="text" name="firstname" class="form-control" id="nombre" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Asunto *</label>
                            <div class="col-7">
                                <input type="text" name="subject" class="form-control" id="subject" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Email *</label>
                            <div class="col-7">
                                <input type="email" name="email" class="form-control" id="email" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Empresa *</label>
                            <div class="col-7">
                                <input type="text" name="company" class="form-control" id="empresa" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Departamento</label>
                            <div class="col-7">
                                <input type="text" name="departament" class="form-control" id="departmento"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Teléfono</label>
                            <div class="col-7">
                                <input type="text" name="phone" class="form-control" id="telefono"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 text-right">Mensaje *</label>
                            <div class="col-6">
                                <textarea name="message" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6 offset-2">
                                <input type="checkbox" name="copy" class="form-check-input" />
                                <label class="form-check-label">¿Quiere enviar una copia su e-mail?</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6 offset-2">
                                <button name="submit" type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
} elseif ($_POST && isset($_POST['submit'])) {
    if ($_POST['copy'] == 'on') {
        $sendto[] = get_field('email_quotes', 'option');
        $sendto[] = $_POST['email'];
    } else {
        $sendto = get_field('email_quotes', 'option');
    }
    $name = $_POST['firstname'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $departament = $_POST['departament'];
    $phone = $_POST['phone'];
    $txt = $_POST['message'];
    $prod_title = get_the_title($_POST['id']);

    $message = "<strong>Cotización solicitada por formuario web</strong><br /><br /> \r\n";
    $message .= "De: $name <br />\r\n";
    $message .= "Email: $email <br />\r\n";
    $message .= "Empresa: $company <br />\r\n";
    $message .= "Departamento: $departament <br />\r\n";
    $message .= "Teléfono: $phone <br />\r\n";
    $message .= "<br />\r\n";
    $message .= "<br />\r\n";
    $message .= "Producto: $prod_title \r\n <br /><br /> $txt";

    $headers[] = "From: $name <$email>";
        $headers[] = "To: $sendto";
    wp_mail($sendto, $subject, $message, $headers);

    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 py-5 my-auto">
                <h2>Su formulario ha sido enviado con éxito</h2>
                <h3>Pronto lo contactaremos, al correo enviado</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <a href="<?php echo home_url('buscador-de-productos/alfabetico/') ?>">
                    &laquo; Volver al buscador
                </a>
            </div>
        </div>
    </div>
    <?php
}
get_footer();
?>
