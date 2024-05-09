<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EstatusOrdenService;
use DOMDocument;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;

class WebServiceController extends Controller
{
    public function index()
    {
        $id = 12345;
        $xmlContent = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
    <soapenv:Header/>
    <soapenv:Body>
        <tem:_EstatusOrden>
            <!--Optional:-->
            <tem:id>' . intval('12345') . '</tem:id>
            <!--Optional:-->
            <tem:empresa>' . strval('RED_ICH') . '</tem:empresa>
            <!--Optional:-->
            <tem:folioOrigen>' . strval('20240430133430') . '</tem:folioOrigen>
            <!--Optional:-->
            <tem:estado>' . strval('Liquidada') . '</tem:estado>
            <!--Optional:-->
            <tem:causaDevolucion>' . strval('PRueba laravel') . '</tem:causaDevolucion>
        </tem:_EstatusOrden>
    </soapenv:Body>
</soapenv:Envelope>';

        $tamano = strlen($xmlContent);
        // Crea un nuevo objeto DOMDocument
        $dom = new DOMDocument();

        // Carga el contenido XML
        $dom->loadXML($xmlContent);

        // Guarda el XML en un archivo
        $dom->save('eficiente/xml/prueba.xml');
        $xmlFilePath = public_path('eficiente/xml/prueba.xml');
        // return $path;

        // Ruta del archivo XML a enviar
        // $xmlFilePath = 'ruta/a/tu/carpeta/nombre_del_archivo.xml';

        // URL de destino para la solicitud POST
        $postUrl = 'http://187.188.173.92:49330/EstatusOrdenService.svc?singleWsdl';

        // Inicializa cURL
        $curl = curl_init();

        // Establece las opciones de cURL
        curl_setopt_array($curl, [
            CURLOPT_URL => $postUrl,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => file_get_contents($xmlFilePath),
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml;charset=UTF-8',
                'SOAPAction: http://tempuri.org/IEstatusOrdenService/_EstatusOrden"',
                'Content-Length: 804',
                'Connection: Keep-Alive',
            ],
        ]);

        // Ejecuta la solicitud cURL y obtiene la respuesta
        $response = curl_exec($curl);

        // Verifica si hay errores
        if (curl_errno($curl)) {
            return $error_message = curl_error($curl);
            // Maneja el error adecuadamente
        }

        // Cierra la sesión cURL
        curl_close($curl);

        // Muestra la respuesta
        echo $response;
    }
}
