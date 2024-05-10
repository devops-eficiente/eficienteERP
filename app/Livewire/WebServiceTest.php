<?php

namespace App\Livewire;

use Livewire\Component;
use SimpleXMLElement;
use SoapClient;
use SoapFault;

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
        // Define la URL del WSDL
        $wsdlUrl = 'http://187.188.173.92:49330/EstatusOrdenService.svc?wsdl';

        // Crea una instancia de SoapClient con el WSDL
        $client = new SoapClient($wsdlUrl);

        // Define los parámetros del método _EstatusOrden
        $params = [
            'id' => 12345,
            'empresa' => 'RED_ICH',
            'folioOrigen' => '20240430133430',
            'estado' => 'Liquidada',
            'causaDevolucion' => $this->motivo,
        ];
        try {
            $response = $client->_EstatusOrden($params);
            $this->motivo = $response->_EstatusOrdenResult->CausaDevolucion;
            $this->devolucionId = $response->_EstatusOrdenResult->CausaDevolucionID;
            $this->mensaje = $response->_EstatusOrdenResult->Mensaje;
            $this->causa = $response->_EstatusOrdenResult->CausaDevolucion;
            $this->search = true;
        } catch (SoapFault $fault) {
            echo 'Error en la solicitud SOAP: ' . $fault->getMessage();
        }
    }

    public function delete()
    {
        $this->reset(['mensaje', 'causa', 'devolucionId', 'search','motivo']);
    }
}
