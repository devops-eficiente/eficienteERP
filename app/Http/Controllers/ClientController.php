<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Employee;
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
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'required|mimetypes:application/pdf|max:2000',
        ]);
        Session::forget('employee');
        Session::forget('persona');
        try {
            $scraper = Scraper::create();
            $rutaDocumento = $request->file('pdf');
            $persona = $this->readPdf($rutaDocumento);
            $employee = Employee::find($id);
            Session::put('employee', $employee);
            Session::put('persona', $persona);
            return view('employee.verified', compact('employee', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function checkCIF(Request $request, $id)
    {
        Session::forget('employee');
        Session::forget('persona');
        try {
            $persona = $this->checkRFC($request->rfc, $request->cif);
            $employee = Employee::find($id);
            Session::put('employee', $employee);
            Session::put('persona', $persona);
            return view('employee.verified', compact('employee', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function export_rfc(Request $request)
    {
        if ($request->opcion == 'rfc_invalid') {
            $employees = Employee::where('rfc_verified', 0)
                ->get()
                ->map(function ($employee) {
                    return [
                        'rfc' => $employee->rfc,
                        'full_name' => $employee->name . ' ' . $employee->paternal_surname . ' ' . $employee->maternal_surname,
                        'zip_code' => $employee->zip_code,
                    ];
                });
        } elseif ($request->opcion == 'all_active') {
            $employees = Employee::get()->map(function ($employee) {
                return [
                    'rfc' => $employee->rfc,
                    'full_name' => $employee->name . ' ' . $employee->paternal_surname . ' ' . $employee->maternal_surname,
                    'zip_code' => $employee->zip_code,
                ];
            });
        } elseif ($request->opcion == 'all') {
            $employees = Employee::get()->map(function ($employee) {
                return [
                    'rfc' => $employee->rfc,
                    'full_name' => $employee->name . ' ' . $employee->paternal_surname . ' ' . $employee->maternal_surname,
                    'zip_code' => $employee->zip_code,
                ];
            });
        }

        $batchArchivo = 'eficiente/exports/empleados.txt';
        // Abrir el archivo en modo escritura
        ($archivo_handle = fopen($batchArchivo, 'w')) or die('No se puede abrir el archivo.');

        // Iterar sobre los datos y escribir en el archivo
        foreach ($employees as $index => $fila) {
            fwrite($archivo_handle, $index + 1 . '|' . implode('|', $fila) . "|\n");
        }

        // Cerrar el archivo
        fclose($archivo_handle);

        // Descarga del archivo
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($batchArchivo) . '"');
        header('Content-Length: ' . filesize($batchArchivo));
        readfile($batchArchivo);
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
                    // unlink($extractedFilePath); ELIMINAR ARCHIVO
                    try {
                        $rutaDocumento = $extractedFilePath;
                        $persona = $this->readPdf($rutaDocumento);
                        $this->createClient($persona);
                        // $person[$i] = $persona;
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
            // Cerrar el archivo ZIP
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
            $ult = Client::max('id') + 1;
            DB::beginTransaction();
            $newPerson = Person::create([
                'rfc' => $person->rfc,
                'type' => 'client',
                'regimen' => $person->tipo,
                'start_date' => $person->fecha_inicio_operaciones->date,
                'status' => $person->situacion_contribuyente
            ]);
            if($person->tipo == 'fisica'){
                $name = $person->nombre.' '.$person->apellido_paterno.' '.$person->apellido_materno;
                $regimen = '';
            }else{
                $regimen = $person->regimen_de_capital;
                $name = $person->razon_social;
            }
            Client::create([
                'person_id' => $newPerson->id,
                'n_client' => 'E' . $ult,
                'company_name' => $name,
                'capital_regime' => $regimen,
                'status' => 1,
                'updated_date' => $person->fecha_ultimo_cambio_situacion->date,
                'rfc_verified' => 1,
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
                    $newPerson->tax_regimes()->attach($taxRegime->id, [
                        'start_date' => Carbon::parse($regimen->fecha_alta->date)->format('Y-m-d'),
                        'end_date' => $end_date,
                        'status' => $status,
                    ]);
                }
            }

            Contact::create([
                'person_id' => $newPerson->id,
                'email' => $person->correo_electronico,
                'phone' => '',
            ]);
            Address::create([
                'person_id' => $newPerson->id,
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
                'person_id' => $newPerson->id,
                'data' => $person
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        // return true;
    }

    public function createByDocument(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimetypes:application/pdf|max:2000',
        ]);
        try {
            $scraper = Scraper::create();
            $rutaDocumento = $request->file('pdf');
            $persona = $this->readPdf($rutaDocumento);
            if ($request->type == 'employee') {
                if ($persona->tipo == 'fisica') {
                    $this->createEmployee($persona);
                } else {
                    return back()->with('denied', 'Verificar archivo <br> Solo se pueden dar de alta a personas fisicas..');
                }
            } else {
                return 'En proceso';
            }
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
        if ($request->type == 'employee') {
            return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
        } else {
            return redirect()->route('admin.employees')->with('success', 'Cliente creado correctamente');
        }
    }

    public function createByData(Request $request)
    {
        try {
            $persona = $this->checkRFC($request->rfc, $request->cif);
            if ($request->type == 'employee') {
                if ($persona->tipo == 'fisica') {
                    $this->createEmployee($persona);
                } else {
                    return back()->with('denied', 'Verificar archivo <br> Solo se pueden dar de alta a personas fisicas..');
                }
            } else {
                return 'En proceso';
            }
        } catch (\Throwable $th) {
            return back()->with('denied', 'No se econtro a la persona verificar datos.');
        }

        return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
    }
}
