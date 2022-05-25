<?php

    session_start();
    $ticket = $_SESSION['ticket'];

    //Cargamos la librería dompdf
    require_once "librerias/dompdf/autoload.inc.php";

    //Usamos el espacion de nombres de Dompdf
    use Dompdf\Dompdf;

    $pdf = new Dompdf(); //crear el objeto de la clase Dompdf

    $opciones = $pdf->getOptions();

    // Para procesar bien las imágenes debe estar esta línea activa
    // Las imágenes deben tener ruta absoluta
    // Hay que descomentar la línea de php.ini extension=gd, para que sirva la extensión .png
    $opciones->set(array('isRemoteEnabled' => true));
    // Ayuda a parsear bien el html5, ya que puede haber algún error
    $opciones->set('isHtml5ParserEnabled', true);

    $pdf->setOptions($opciones);

    //Establecer el tamaño de hoja en DOMPDF
    $pdf->setPaper('A4', 'portrait');

    // Añadir el HTML a dompdf
    $pdf->loadHtml(
        "<html lang='es'>

              <head>
                  <title>Remesa de Producción Molino del Sur</title>
                  <style>
                  
                    html {margin: 0;}
                    body {font-family: 'Times New Roman', serif;
                        margin: 0 8mm 2mm 8mm;}
                    hr{margin: 0;}
                    img{float: right;
                      margin-top: -20px;}
                    h6{color: green;
                      font-size: 18px;}
                  
                  </style>
              
              </head>
              <body>
              
                  $ticket
              
              </body>
            </html>");

    // Renderizar el PDF
    $pdf->render();

    // Al poner false en attachment obligamos a que el pdf se vea en el navegador, si ponemos true lo estamos obligando
    //a descargarlo
    $pdf->stream("remesa_produccion.pdf", [ "Attachment" => true]);

    unset($ticket);