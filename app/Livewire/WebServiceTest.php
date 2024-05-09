<?php

namespace App\Livewire;

use Livewire\Component;
use SimpleXMLElement;

class WebServiceTest extends Component
{
    public $motivo,
        $mensaje,
        $devolucionId,
        $causa,
        $search = false;
    public function render()
    {
        return view('livewire.web-service-test');
    }
    public function submitForm()
    {
        // Construye el cuerpo del mensaje SOAP
        $xml =
            '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                <soapenv:Header/>
                <soapenv:Body>
                   <tem:_EstatusOrden>
                      <tem:id>12345</tem:id>
                      <tem:empresa>RED_ICH</tem:empresa>
                      <tem:folioOrigen>20240430133430</tem:folioOrigen>
                      <tem:estado>Liquidada</tem:estado>
                      <tem:causaDevolucion>' .
            $this->motivo .
            '</tem:causaDevolucion>
                   </tem:_EstatusOrden>
                </soapenv:Body>
                </soapenv:Envelope>';

        // Define los encabezados de la solicitud
        $headers = ['Content-Type: text/xml;charset=UTF-8', 'Content-Length: ' . strlen($xml), 'Accept-Encoding: gzip,deflate,br', 'SOAPAction: "http://tempuri.org/IEstatusOrdenService/_EstatusOrden"'];

        // Realiza la solicitud POST al servicio SOAP
        $ch = curl_init('http://187.188.173.92:49330/EstatusOrdenService.svc?singleWsdl');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        // Verifica si hay errores
        if (curl_errno($ch)) {
            echo 'Error en la solicitud SOAP: ' . curl_error($ch);
        } else {
            try {
                //code...
                // Procesa la respuesta
                // $response_xml = simplexml_load_string($response);
                $archivo_respuesta = 'eficiente/respuesta.xml';

                // Intenta abrir el archivo para escritura
                if ($archivo = fopen($archivo_respuesta, 'w')) {
                    // Escribe la respuesta en el archivo
                    fwrite($archivo, $response);

                    // Cierra el archivo
                    fclose($archivo);

                    echo "La respuesta se ha guardado correctamente en el archivo '$archivo_respuesta'.";
                } else {
                    echo 'Error al abrir el archivo para escribir la respuesta.';
                }
                $xmlContent = file_get_contents($archivo_respuesta);

                // Crear un objeto SimpleXMLElement con el contenido del XML
                $xml = new SimpleXMLElement($xmlContent);

                // Definir el namespace utilizado en el XML
                $xml->registerXPathNamespace('s', 'http://schemas.xmlsoap.org/soap/envelope/');
                $xml->registerXPathNamespace('a', 'http://schemas.datacontract.org/2004/07/STP');

                // Utilizar XPath para extraer los valores deseados
                $mensaje = $xml->xpath('//a:Mensaje');
                $causaDevolucionID = $xml->xpath('//a:CausaDevolucionID');
                $causaDevolucion = $xml->xpath('//a:CausaDevolucion');

                // Mostrar los valores obtenidos
                // dd(strval($mensaje[0]));
                // $this->mensaje = $mensaje[0];
                // $this->causa = $causaDevolucion[0];
                // $this->devolucionId = $causaDevolucionID[0];
                $this->mensaje = strval($mensaje[0]);
                $this->causa = strval($causaDevolucion[0]);
                $this->devolucionId = strval($causaDevolucionID[0]);
                $this->search = true;
            } catch (\Throwable $th) {
                $this->mensaje = $th->getMessage();
            }
        }

        // Cierra la conexión cURL
        curl_close($ch);
        unlink($archivo_respuesta);
    }

    public function delete()
    {
        $this->reset(['mensaje', 'causa', 'devolucionId', 'search']);
    }
}
