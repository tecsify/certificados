<?php
// Archivo: certificado.php

// URL del endpoint de la API
$apiUrl = 'http://backend:5000/backend/certificado_por_id';
$diplomaUrl = 'http://backend:5000/backend/diploma/';

// Obtén el UUID desde la URL
$uuid = $_GET['uuid'];

if (!isset($uuid) || $uuid == '') {
    header('Location: /');
}

// Agrega el UUID a la URL de la API
$apiUrl .= '/' . $uuid;

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="Tecsify Latinoamerica, ¡Tecnologia que empodera!" />
    <meta name="description" content="Bienvenido al portal de certificados de Tecsify, aquí encontrarás todos tus certificados" />
    <meta name="author" content="www.Tecsify.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Certificados Tecsify ¡Tecnología que empodera!">
    <meta property="og:url" content="certificados.tecsify.com">
    <meta property="og:image" content="https://tecsify.com/blog/wp-content/uploads/2020/11/perfil-1-150x150.jpg">
    <meta property="og:site_name" content="Tecsify" />

    <meta property="og:title" content="Certificados Tecsify - Tecnología que empodera" />
    <meta property="og:description" content="¡Estoy muy contento de compartir mi certificado de Tecsify" />

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@tecsify">
    <meta name="twitter:title" content="Certificados Tecsify - Tecnología que empodera">
    <meta name="twitter:description" content="Bienvenido al portal de certificados de Tecsify, aquí encontrarás todos tus certificados">

    <!-- Title -->
    <title>Certificados Tecsify - Tecnología que empodera</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="../assets/images/favic.png" sizes="32x32" />
    <!-- inject css start -->

    <link href="../assets/css/theme-plugin.css" rel="stylesheet" />
    <link href="../assets/css/theme.min.css" rel="stylesheet" />

    <!-- inject css end -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body>

    <!-- page wrapper start -->

    <div class="page-wrapper">


        <!-- preloader start -->

        <div id="ht-preloader">
            <div class="loader clear-loader">
                <span></span>
                <p>Tecsify</p>
            </div>
        </div>

        <!-- preloader end -->
        <header class="site-header">
            <div id="header-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col d-flex align-items-center justify-content-between">
                            <a class="navbar-brand logo text-dark h2 mb-0" href="https://tecsify.com">
                                <span class="text-primary font-weight-bold">Tecsify</span>
                            </a>
                            <nav class="navbar navbar-expand-lg navbar-light ml-auto">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <ul class="navbar-nav ml-auto">

                                        <li class="nav-item active"> <a class="nav-link  active" href="/">Certificados</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="https://tecsify.com/">Inicio</a></li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Sobre Nosotros
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="https://tecsify.com/info">Acerca de Tecsify</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="https://tecsify.com/blog/conducta-y-privacidad/">Código de conducta</a></li>
                                                <li><a class="dropdown-item" href="https://tecsify.com/blog/contacto/">Contacto</a></li>

                                            </ul>
                                        </li>

                                        <li class="nav-item "> <a class="nav-link" href="https://tecsify.com/blog">Blog</a></li>
                                        <li class="nav-item "> <a class="nav-link" href="https://tecsify.com/blog/portal">Portal Tecsify</a>
                                        </li>

                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>



        <!--hero section start-->

        <style>
            .efecto_certi {
                transition: 0.30s all ease-in-out;

            }

            .efecto_certi:hover {
                transform: scale(0.935);
                box-shadow: 0 0 11px rgba(3, 3, 153, 0.45);
                border: rgba(3, 3, 153, 0.8)
            }

            .sombra {
                transition: 0.10s all ease-in-out;
            }

            .zoom-image {
                transition: 0.20s all ease-in-out;
            }

            .zoom-menos {
                transition: 0.30s all ease-in-out;
            }

            .zoom-menos:hover {
                transform: scale(0.705);
                box-shadow: 0 0 11px rgba(33, 33, 33, 0.1);
            }

            .sombra:hover {
                transform: scale(1.005);
                box-shadow: 0 0 11px rgba(3, 3, 153, 0.3);
                border: rgba(3, 3, 153, 0.8)
            }

            .sombra:hover .zoom-image {
                transform: rotate(-0.5deg) scale(1.05);
            }

            .brsalto {
                margin-bottom: 0.1rem;
            }

            .main {
                width: 22.3rem;
                height: 22.3rem;
                position: absolute;
                top: 2.1rem;
                bottom: 0;
                left: -0.3rem;
                right: 0;
                margin: auto;
                border-radius: 100%;
            }


            .main:before {
                position: absolute;
                content: '';
                height: calc(100%);
                width: calc(100%);
                border: 0.40rem dashed #030399;
                border-radius: inherit;
                animation: spin 60s linear infinite;
            }

            @keyframes spin {
                100% {
                    transform: rotateZ(-360deg);
                }
            }


            @media only screen and (max-width: 900px) {
                .brsalto {
                    margin-bottom: 2rem;
                }

                #blog-card-3,
                #blog-card-4,
                #blog-card-5,
                #mainmundo {
                    display: none;
                }

                .centerMobile {
                    text-align: center !important;
                }

                .display-4 {
                    font-size: calc(1.4rem + 3.9vw) !important;
                    line-height: 3.4rem !important;
                }

                .textoup {
                    font-size: 1.15rem !important;
                    padding-top: 0.5rem;
                    padding-bottom: 1rem;
                }

                #worldmobile {
                    display: initial !important;
                }

                #datos-cert {
                    text-align: center !important;
                }

                #datos-cert h2 {
                    margin-bottom: 2rem;
                }

                #datos-cert span {
                    display: block;
                    margin-top: 0.3rem;
                    margin-bottom: 1.2rem;
                }

                #redescompartir {
                    text-align: center !important;
                }

                #shareWhatsappButton {
                    display: inline-block !important;
                }

            }

            .titulo {
                font-weight: 500;
                color: black;
            }

            .descargar-certificado {
                background-color: rgb(3, 3, 153);
                color: white;
                border: none;
                border-radius: 0.5rem;
            }
        </style>


        <section id="seccionresultado">
            <div class="container">

                <?php
                error_reporting(0);
                // Realiza la solicitud GET a la API
                try {
                    $response = file_get_contents($apiUrl);
                } catch (Exception $e) {
                    // Error al conectarse a la API (maneja la excepción)
                    echo "<h1>Error al intentar comunicarse con el servidor, intentalo más tarde</h1>";
                    exit; // O puedes mostrar un mensaje adicional si lo deseas
                }


                if ($response === false) {
                    // Error al conectarse a la API
                    echo "
                   
                   <div style='text-align:center;'>
                
                   <br>
                   <small style='font-weight:600;'><a href='/'>← Regresar a la página de certificados</a></small>
                   <br>

                   <h2 style='text-align:center;'>Este certificado no existe</h2>
                   
                   <p>Pero... ¡No te preocupes!..
                   <br><br>
                   <img class='img-fluid' src='../assets/images/404.png' style='width:25rem;'/>
                   <p>Hay otras certificaciones que puedes obtener en Tecsify.com<br>¡Que no pare la innovación!</p>
                   </div>";
                } else {
                    $data = json_decode($response, true);

                    if (isset($data['message'])) {
                        // Certificado no encontrado
                        echo "Certificado no encontrado.";
                    } else {

                        echo "<div class='row'>";
                        echo "<div class='col-md-5' style='text-align: center;'> ";
                        // Solicita la imagen del diploma
                        $imageData = file_get_contents($diplomaUrl . $uuid);
                        $currentURL = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                        // Convierte los datos de la imagen a base64
                        $base64Image = base64_encode($imageData);

                        // Construye una URL de datos
                        $dataUrl = "data:image/jpeg;base64," . $base64Image;

                        // Muestra la imagen dentro de una etiqueta <img>
                        echo "<br>";
                        echo "<img src='$dataUrl' name='" . $data['certificados'][0]['id'] . "' class='img-fluid efecto_certi' id='certificadotecsify' alt='Diploma Tecsify' style='border-radius:0.5rem;box-shadow: 0 0 2rem rgba(3, 3, 153, 0.3);' /><br>";
                        echo "<small>¡Puedes hacer click en el certificado para verlo en grande!</small><br><br>";
                        echo "<select id ='descargar-certificado' class='descargar-certificado custom-select-lg mb-3'>
                        <option value=''>Descargar certificado</option>
                        <option value='pdf'>Descargar como PDF</option>
                        <option value='img'>Descargar como Imágen</option>
                      
                      </select>";

                        echo "</div>";
                        echo "<div id='datos-cert' class='col-md-7' style='padding-top: 1rem;padding-left: 2rem;'> ";
                        echo "<h2>Datos del Certificado:</h2>";

                        echo "<p>Nombre: <span class='titulo'>" . $data['datos_usuario']['nombre'] . "</span></p>";
                        echo "<p>Código único de Certificado:<span class='titulo'> " . $data['certificados'][0]['id'] . "</span></p>";
                        echo "<p>Nombre del Certificado: <span id='nombre_certificado' name='nombre_certificado' class='titulo'>" . $data['certificados'][0]['nombre_certificado'] . "</span></p>";

                        // Formatea la fecha
                        $fecha = new DateTime($data['certificados'][0]['fecha_certificado']);
                        $fechaFormateada = $fecha->format('d/m/Y');

                        echo "<p>Fecha de Certificado: <span class='titulo'>" . $fechaFormateada . "</span></p>";
                        echo "<p>Impartido por: <span class='titulo'>" . $data['certificados'][0]['certificado_impartido'] . "</span></p>";
                        echo "<p>Evento: <span class='titulo'>" . $data['certificados'][0]['evento'] . "</span></p>";
                        echo "<p class='titulo'>✅ Validado por Tecsify</p><br>";
                        echo "<div class='align-items-center' id='redescompartir' style='text-align: left;'>

                        <h6>¡Comparte tus logros en redes sociales!</h6> 
                            <style>
                              .sharer{
                                color:#030399 !important
                              }
              
                            </style>
                            <a href='#' id='shareLinkedInButton' class='sharer button'><i class='fa-brands fa-2x fa-linkedin'></i></a>
                            <a href='#' id='shareTwitterButton' class='sharer button'><i class='fab fa-2x fa-twitter-square'></i></a>
                            <a href='#' id='shareFacebookButton' class='sharer button'><i class='fab fa-2x fa-facebook-square'></i></a>
                            <a  style='display:none;' href='whatsapp://send?text=¡Mira este increíble certificado sobre " . $data['certificados'][0]['nombre_certificado'] . " En Tecsify! " . $currentURL . "' id='shareWhatsappButton' class='sharer button'><i class='fab fa-2x fa-whatsapp-square'></i></a>
     

                      </div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>


            </div>
    </div>

    <div>
        <div class="align-items-center" style="text-align: center;">

            <h5>¡Siguenos en nuestras redes sociales!</h5>
            <style>
                .sharer {
                    color: #030399 !important
                }
            </style>
            <a href="https://facebook.com/tecsify" target="_blank" id="share-fb" class="sharer button"><i class="fab fa-3x fa-facebook-square"></i></a>
            <a href="https://instagram.com/tecsify" target="_blank" id="share-ig" class="sharer button"><i class="fab fa-3x fa-instagram-square"></i></a>
            <a href="https://www.linkedin.com/company/tecsify/" id="share-ln" class="sharer button"><i class="fa-brands fa-3x fa-linkedin"></i></a>
            <a href="https://twitter.com/tecsify" id="share-ig" class="sharer button"><i class="fab fa-3x fa-twitter-square"></i></a>
            <a href="https://www.youtube.com/channel/UCalG-fWPHHWG-XTzhcCn0_A" id="share-ln" class="sharer button"><i class="fab fa-3x fa-youtube-square"></i></a>

            <br>
            <br>
            <br>
        </div>
    </div>
    </section>

    <script src="../assets/js/theme-plugin.js"></script>
    <script src="../assets/js/theme-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Modal para mostrar la imagen -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <button type="button" style='color:white' class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>

            <img id="modalImage" src="" class="img-fluid" alt="Imagen" style="max-width:100%;">

        </div>
    </div>


    <script>
        // Función para abrir el modal y mostrar la imagen
        document.getElementById('certificadotecsify').addEventListener('click', function() {
            // Obtén la URL de la imagen
            const imageUrl = $("#certificadotecsify").attr("src");

            // Establece la URL de la imagen en el modal
            document.getElementById('modalImage').src = imageUrl;

            // Abre el modal
            $('#imageModal').modal('show');
        });

        document.getElementById('shareLinkedInButton').addEventListener('click', function() {
            // Obtiene el título de la charla o el contenido que deseas compartir
            var charlaTitle = $("#nombre_certificado").text();

            // Crea el mensaje personalizado
            var shareMessage = "¡Estoy muy contento de compartir mi certificado de @Tecsify sobre " + charlaTitle + "!";

            // Obtiene la URL actual del navegador
            var currentURL = window.location.href;

            // Crea la URL de compartir en LinkedIn con el mensaje personalizado
            var linkedInShareURL = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(currentURL);

            // Abre una nueva ventana o pestaña con la URL de compartir en LinkedIn
            window.open(linkedInShareURL, '_blank');
        });


        document.getElementById('shareTwitterButton').addEventListener('click', function() {
            // Obtiene el título de la charla o el contenido que deseas compartir
            var charlaTitle = $("#nombre_certificado").text();

            // Crea el texto de la publicación con un salto de línea
            var shareText = "¡Estoy muy contento de compartir mi certificado de @Tecsify sobre " + charlaTitle;

            // Obtiene la URL actual del navegador
            var currentURL = window.location.href;

            // Crea la URL de compartir en Twitter con el texto de la publicación
            var twitterShareURL = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(currentURL) + '&text=' + encodeURIComponent(shareText);

            // Abre una nueva ventana o pestaña con la URL de compartir en Twitter
            window.open(twitterShareURL, '_blank');
        });


        document.getElementById('shareFacebookButton').addEventListener('click', function() {
            // Obtiene el título de la charla o el contenido que deseas compartir
            var charlaTitle = $("#nombre_certificado").text();

            // Crea el texto de la publicación
            var shareText = "¡Estoy muy contento de compartir mi certificado de @Tecsify sobre " + charlaTitle + "!";

            // Obtiene la URL actual del navegador
            var currentURL = window.location.href;

            // Crea la URL de compartir en Facebook con el texto de la publicación
            var facebookShareURL = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(currentURL) + '&quote=' + encodeURIComponent(shareText) + '&hashtag=Tecsify';

            // Abre una nueva ventana o pestaña con la URL de compartir en Facebook
            window.open(facebookShareURL, '_blank');
        });



        document.getElementById('descargar-certificado').addEventListener('change', function() {
            var select = document.querySelector('.descargar-certificado');
            var selectedOption = select.options[select.selectedIndex].value;

            if (selectedOption === 'pdf') {
                window.jsPDF = window.jspdf.jsPDF;
                const pdf = new jsPDF('landscape');
                // URL de la imagen que deseas convertir a PDF

                const imageUrl = $("#certificadotecsify").attr("src");
                const name_id = $("#certificadotecsify").attr("name");

                // Dimensiones de la imagen en el PDF
                const imageWidth = 0;
                const imageHeight = 200;

                // Agrega la imagen al PDF
                pdf.addImage(imageUrl, 'JPEG', 10, 5, imageWidth, imageHeight);

                // Nombre del archivo PDF generado
                const pdfFileName = name_id + '.pdf';
                Swal.fire('¡Certificado descargado!', "Se ha guardado tu certificado como PDF:<br> <small>Nombre: <strong>" + pdfFileName + "</strong><small>", "success");



                // Descarga el PDF
                pdf.save(pdfFileName);
            } else if (selectedOption === 'img') {
                // Obtiene la imagen por su ID
                var image = document.getElementById('certificadotecsify');
                const name_id = $("#certificadotecsify").attr("name");

                // Crea un enlace temporal
                var a = document.createElement('a');
                a.href = image.src;
                a.download = name_id + '.jpg';

                // Simula un clic en el enlace para iniciar la descarga
                a.click();
                Swal.fire('¡Certificado descargado!', "Se ha guardado tu certificado como Imágen:<br> <small>Nombre: <small><strong>" + name_id + '.jpg' + "</strong><small>", "success");

            }
        });
    </script>

    <!-- Botón para compartir en LinkedIn -->


</body>

</html>