<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Models\Address;
use App\Models\CapitalRegime;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Person;
use App\Models\RfcData;
use App\Models\TaxRegime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpCfdi\CsfScraper\Scraper;
use PhpCfdi\Rfc\Rfc;
use Smalot\PdfParser\Parser;
use ZipArchive;

class ClientController extends Controller
{
    public function index()
    {
        $persons = Person::getClients();
        return view('client.index', compact('persons'));
    }

    public function create()
    {
        $taxRegimes = TaxRegime::all();
        $capitalRegimes = CapitalRegime::all();
        return view('client.create', compact('taxRegimes', 'capitalRegimes'));
    }

    public function store(CreateClientRequest $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            $person = Person::create([
                'rfc' => $request->rfc,
                'type' => 'client',
                'regimen' => $request->regimen,
            ]);
            $ult = Client::max('id') + 1;
            Client::create([
                'n_client' => 'C-' . $ult,
                'person_id' => $person->id,
                'capital_regime_id' => $request->capital_regime_id,
                'company_name' => $request->company_name,
                'status' => 1,
            ]);
            Contact::create([
                'person_id' => $person->id,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            Address::create([
                'person_id' => $person->id,
                'zip_code' => $request->zip_code,
            ]);
            if ($request->tax_regimes) {
                $person->tax_regimes()->attach($request->tax_regimes);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
            return back()->with('denied', 'Sucedio un error.');
        }
        return redirect()->route('admin.clients')->with('success', 'Cliente creado Correctamente');
    }

    public function show($id){
        $person = Person::where('rfc',$id)->first();
        return view('client.show',compact('person'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'required|mimetypes:application/pdf|max:2000',
        ]);
        Session::forget('employee');
        Session::forget('persona');
        try {
            $rutaDocumento = $request->file('pdf');
            $persona = $this->readPdf($rutaDocumento);
            $person = Person::find($id);
            Session::put('person', $person);
            Session::put('persona', $persona);
            return view('client.verified', compact('person', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function continue()
    {
        $person = Session::get('person');
        $person->employee()->update([
            'rfc_verified' => 1,
        ]);
        $person->update([
            'comments' => null,
        ]);
        Session::forget('employee');
        Session::forget('persona');
        return redirect()->route('admin.clients')->with('success', 'Datos Verificados correctamente.');
    }

    public function edit_data()
    {
        try {
            DB::beginTransaction();
            $person = Session::get('person');
            $persona = Session::get('persona');

            $person->update([
                'rfc' => $persona->rfc,
                'type' => 'employee',
                'regimen' => 'moral',
                'start_date' => Carbon::parse($persona->fecha_inicio_operaciones->date)->format('Y-m-d'),
                'status' => $persona->situacion_contribuyente,
            ]);
            $regimenCapital = null;
            if ($persona->tipo == 'fisica') {
                $name = $persona->nombre . ' ' . $persona->apellido_paterno . ' ' . $persona->apellido_materno;
            } else {
                $name = $persona->razon_social;
                $regimenSat = str_replace(' ', '', $persona->regimen_de_capital);
                $regimenes = CapitalRegime::all();
                foreach ($regimenes as $regimen) {
                    $regimenSistema = str_replace(' ', '', $regimen->acronym);
                    if ($regimenSat == $regimenSistema) {
                        $regimenCapital = $regimen->id;
                        break;
                    }
                }
            }
            $person->client()->update([
                'person_id' => $person->id,
                'capital_regime_id' => $regimenCapital,
                'company_name' => $name,
                'updated_date' => Carbon::parse($persona->fecha_ultimo_cambio_situacion->date)->format('Y-m-d'),
                'rfc_verified' => 1,
            ]);
            $person->tax_regimes()->detach();
            foreach ($persona->regimenes as $regimen) {
                $taxRegime = TaxRegime::where('code', $regimen->regimen_id)->first();
                $person->tax_regimes()->detach();
                if ($taxRegime) {
                    if (isset($regimen->fecha_baja)) {
                        $status = 0;
                        $end_date = Carbon::parse($regimen->fecha_baja->date)->format('Y-m-d');
                    } else {
                        $status = 1;
                        $end_date = null;
                    }
                    $person->tax_regimes()->attach($taxRegime->id, [
                        'start_date' => Carbon::parse($regimen->fecha_alta->date)->format('Y-m-d'),
                        'end_date' => $end_date,
                        'status' => $status,
                    ]);
                }
            }
            $address = Address::where('person_id', $person->id)->first();
            $address->update([
                'state' => $persona->entidad_federativa,
                'city' => $persona->municipio_delegacion,
                'zip_code' => $persona->codigo_postal,
                'road_type' => $persona->tipo_vialidad,
                'road_name' => $persona->nombre_vialidad,
                'internal_number' => $persona->numero_interior,
                'external_number' => $persona->numero_exterior,
                'suburb' => $persona->colonia,
            ]);
            RfcData::create([
                'person_id' => $person->id,
                'data' => $persona,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
            return redirect()->route('admin.employees')->with('denied', 'Error al actualizar los datos.');
        }

        Session::forget('employee');
        Session::forget('persona');
        return redirect()->route('admin.clients')->with('success', 'Datos Verificados correctamente.');
    }

    public function checkCIF(Request $request, $id)
    {
        Session::forget('employee');
        Session::forget('persona');
        try {
            $persona = $this->checkRFC($request->rfc, $request->cif);
            $person = Person::find($id);
            Session::put('person', $person);
            Session::put('persona', $persona);
            return view('employee.verified', compact('person', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function export_rfc(Request $request)
    {
        try {
            if ($request->opcion == 'rfc_invalid') {
                $employees = Person::with(['client', 'addresses'])
                    ->whereHas('client', function ($query) {
                        $query->where('rfc_verified', 0);
                    })
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->client->company_name,
                            'zip_code' => $person->addresses[0]->zip_code,
                        ];
                    });
            } elseif ($request->opcion == 'all_active') {
                $employees = Person::with(['client', 'addresses'])
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->client->company_name,
                            'zip_code' => $person->addresses[0]->zip_code,
                        ];
                    });
            } elseif ($request->opcion == 'all') {
                $employees = Person::with(['client', 'addresses'])
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->client->company_name,
                            'zip_code' => $person->addresses[0]->zip_code,
                        ];
                    });
            }

            $batchArchivo = 'eficiente/exports/empleados.txt';
            ($archivo_handle = fopen($batchArchivo, 'w')) or die('No se puede abrir el archivo.');

            foreach ($employees as $index => $fila) {
                fwrite($archivo_handle, $index + 1 . '|' . implode('|', $fila) . "|\n");
            }

            fclose($archivo_handle);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($batchArchivo) . '"');
            header('Content-Length: ' . filesize($batchArchivo));
            readfile($batchArchivo);
        } catch (\Throwable $th) {
            return back()->with('denied', 'Sucedio un error.');
        }
    }

    public function uploadZip(Request $request)
    {
        $zipFilePath = $request->file('zip');
        $extractPath = public_path('eficiente/extracted_files'); // Ruta donde se extraerán los archivos

        $zip = new ZipArchive();
        $extractPath = $extractPath . '/' . uniqid();
        if ($zip->open($zipFilePath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileInfo = $zip->statIndex($i);
                $fileName = $fileInfo['name'];
                $path = $extractPath . '/' . uniqid();
                if (pathinfo($fileName, PATHINFO_EXTENSION) === 'pdf') {
                    $zip->extractTo($path, $fileName);
                    $extractedFilePath = $path . '/' . $fileName;
                    // unlink($extractedFilePath);
                    try {
                        $rutaDocumento = $extractedFilePath;
                        $persona = $this->readPdf($rutaDocumento);
                        $this->createClient($persona);
                        unlink($extractedFilePath);
                    } catch (\Throwable $th) {
                        $resultados[$i]['archivo'] = $fileName;
                        $resultados[$i]['valor'] = 'Verificar archivo. Datos ilegibles o archivo invalido.';
                        $resultados[$i]['status'] = false;
                        unlink($extractedFilePath);
                    }
                } else {
                    $resultados[$i]['archivo'] = $fileName;
                    $resultados[$i]['valor'] = 'Verificar archivo. No es un pdf';
                    $resultados[$i]['status'] = false;
                }
            }
            // return $person;
            $zip->close();
            return back()->with('success', 'Archivo ejecutado correctamente');
        } else {
            return back()->with('denied', 'No se puede leer el archivo');
        }
    }

    public function readPdf($path)
    {
        $rutaDocumento = $path;
        $cif = $this->searchCIF($rutaDocumento);
        $rfc = $this->searchRFC($rutaDocumento);
        return $this->checkRFC($rfc, $cif);
    }

    public function checkRFC($rfc, $cif)
    {
        $scraper = Scraper::create();
        $rfc = Rfc::parse($rfc);
        $person = $scraper->obtainFromRfcAndCif(rfc: $rfc, idCIF: $cif);
        $persona = json_encode($person);
        $persona = json_decode($persona);
        $data = $persona;
        if ($rfc->isFisica()) {
            $data->tipo = 'fisica';
        }
        if ($rfc->isMoral()) {
            $data->tipo = 'moral';
        }
        return $data;
    }

    public function searchCIF($path)
    {
        $parser = new Parser();
        try {
            $documento = $parser->parseFile($path); // Parsear el documento PDF
            $textoCompleto = $documento->getText(); // Obtener el texto completo del PDF
            $cadenaBuscada = 'idCIF:'; // Búsqueda de datos específicos
            $posicion = strpos($textoCompleto, $cadenaBuscada);
            if ($posicion !== false) {
                $idCIF = substr($textoCompleto, $posicion, 18);
                $items = explode(': ', $idCIF);
                return $items[1];
            } else {
                return 'La cadena especificada no se encontró en el PDF.';
            }
        } catch (\Exception $e) {
            return 'Ocurrió un error al leer el PDF: ' . $e->getMessage();
        }
    }

    public function searchRFC($path)
    {
        $parser = new Parser();
        try {
            $documento = $parser->parseFile($path);
            $textoCompleto = $documento->getText();
            $cadenaBuscada = 'RFC:';
            $posicion = strpos($textoCompleto, $cadenaBuscada);

            if ($posicion !== false) {
                $idCIF = substr($textoCompleto, $posicion, 18);
                $items = explode(":\t", $idCIF);
                return $items[1];
            } else {
                return 'La cadena especificada no se encontró en el PDF.';
            }
        } catch (\Exception $e) {
            return 'Ocurrió un error al leer el PDF: ' . $e->getMessage();
        }
    }

    public function createClient($person)
    {
        try {
            DB::beginTransaction();
            $newperson = Person::create([
                'rfc' => $person->rfc,
                'type' => 'client',
                'regimen' => $person->tipo,
                'start_date' => Carbon::parse($person->fecha_inicio_operaciones->date)->format('Y-m-d'),
                'status' => $person->situacion_contribuyente,
            ]);

            $ult = Client::max('id') + 1;
            $regimenCapital = null;
            if ($person->tipo == 'fisica') {
                $name = $person->nombre . ' ' . $person->apellido_paterno . ' ' . $person->apellido_materno;
            } else {
                $name = $person->razon_social;
                $regimenSat = str_replace(' ', '', $person->regimen_de_capital);
                $regimenes = CapitalRegime::all();
                foreach ($regimenes as $regimen) {
                    $regimenSistema = str_replace(' ', '', $regimen->acronym);
                    if ($regimenSat == $regimenSistema) {
                        $regimenCapital = $regimen->id;
                        break;
                    }
                }
            }
            Client::create([
                'n_client' => 'C-' . $ult,
                'person_id' => $newperson->id,
                'capital_regime_id' => $regimenCapital,
                'company_name' => $name,
                'updated_date' => Carbon::parse($person->fecha_ultimo_cambio_situacion->date)->format('Y-m-d'),
                'rfc_verified' => 1,
                'status' => 1,
            ]);
            foreach ($person->regimenes as $regimen) {
                $taxRegime = TaxRegime::where('code', $regimen->regimen_id)->first();
                if ($taxRegime) {
                    if (isset($regimen->fecha_baja)) {
                        $status = 0;
                        $end_date = Carbon::parse($regimen->fecha_baja->date)->format('Y-m-d');
                    } else {
                        $status = 1;
                        $end_date = null;
                    }
                    $newperson->tax_regimes()->attach($taxRegime->id, [
                        'start_date' => Carbon::parse($regimen->fecha_alta->date)->format('Y-m-d'),
                        'end_date' => $end_date,
                        'status' => $status,
                    ]);
                }
            }
            Contact::create([
                'person_id' => $newperson->id,
                'email' => $person->correo_electronico,
                'phone' => '',
            ]);
            Address::create([
                'person_id' => $newperson->id,
                'state' => $person->entidad_federativa,
                'city' => $person->municipio_delegacion,
                'zip_code' => $person->codigo_postal,
                'road_type' => $person->tipo_vialidad,
                'road_name' => $person->nombre_vialidad,
                'internal_number' => $person->numero_interior,
                'external_number' => $person->numero_exterior,
                'suburb' => $person->colonia,
            ]);
            RfcData::create([
                'person_id' => $newperson->id,
                'data' => $person,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    public function validationRfc()
    {
        return view('client.validationEmployee');
    }

    public function uploadResponseSat(Request $request)
    {
        if (!$request->file('archivo')) {
            return back()->with('denied', 'Archivo requerido');
        }
        header('Content-Type: text/html; charset=UTF-8');
        // Nombre del archivo de texto
        $archivo = $request->file('archivo');

        // Abrir el archivo en modo lectura
        $gestor = fopen($archivo, 'r');

        // Verificar si se pudo abrir el archivo
        if ($gestor) {
            // Leer el archivo línea por línea
            while (($linea = fgets($gestor)) !== false) {
                // Dividir la línea en partes usando el separador '|'
                // $datos = explode('|', $linea);
                $datos = explode('|', wordwrap(utf8_decode($linea), 100, '|'));

                $rfc = trim($datos[1]);

                $respuesta = trim($datos[4]); // Código Postal
                $person = Person::where('rfc', $rfc)->first();
                if ($person) {
                    if (strpos($respuesta, 'RFC v?lido') !== false) {
                        $person->employee()->update([
                            'rfc_verified' => 1,
                        ]);
                    } else {
                        $person->employee()->update([
                            'rfc_verified' => 0,
                        ]);
                        $person->update([
                            'comments' => $respuesta,
                        ]);
                    }
                }
            }

            // Cerrar el archivo
            fclose($gestor);
        } else {
            // Manejar el caso en que no se pudo abrir el archivo
            return back()->with('denied', 'No se pudo leer el archivo');
        }
        return redirect()->route('admin.employees')->with('success', 'Datos leidos corectamente.');
    }

    public function createByDocument(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimetypes:application/pdf|max:2000',
        ]);
        try {
            $rutaDocumento = $request->file('pdf');
            $persona = $this->readPdf($rutaDocumento);
            $this->createClient($persona);
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
        if ($request->type == 'employee') {
            return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
        } else {
            return redirect()->route('admin.clients')->with('success', 'Cliente creado correctamente');
        }
    }

    public function createByData(Request $request)
    {
        try {
            $persona = $this->checkRFC($request->rfc, $request->cif);
            $this->createClient($persona);
        } catch (\Throwable $th) {
            return back()->with('denied', 'No se econtro a la persona verificar datos.');
        }
        if ($request->type == 'employee') {
            return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
        } else {
            return redirect()->route('admin.clients')->with('success', 'Cliente creado correctamente');
        }
    }
}
