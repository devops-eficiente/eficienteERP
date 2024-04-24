<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\Address;
use App\Models\BloodType;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Employee;
use App\Models\IdentificationEmployee;
use App\Models\InstituteHealth;
use App\Models\MaritalStatus;
use App\Models\TaxRegime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpCfdi\CsfScraper\Scraper;
use PhpCfdi\Rfc\Rfc;
use Smalot\PdfParser\Parser;
use ZipArchive;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);
        // return $employees;
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $bloodTypes = BloodType::all();
        $instituteHealths = InstituteHealth::all();
        $maritalStatus = MaritalStatus::all();
        $identificationEmployees = IdentificationEmployee::all();
        return view('employee.create', compact('bloodTypes', 'instituteHealths', 'maritalStatus', 'identificationEmployees'));
    }

    public function store(EmployeeStoreRequest $request)
    {
        try {
            $data = $request->all();
            $ult = Employee::max('id') + 1;
            $data['n_employee'] = 'E' . $ult;
            DB::beginTransaction();
            Employee::create($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('denied', $th->getMessage());
        }
        return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
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

    public function continue()
    {
        $employee = Session::get('employee');
        $persona = Session::get('persona');
        $employee->update([
            'rfc_verified' => 1,
        ]);
        Session::forget('employee');
        Session::forget('persona');
        return redirect()->route('admin.employees')->with('success', 'Datos Verificados correctamente.');
    }

    public function edit_data()
    {
        $employee = Session::get('employee');
        $persona = Session::get('persona');
        $employee->update([
            'rfc_verified' => 1,
            'name' => $persona->nombre,
            'paternal_surname' => $persona->apellido_paterno,
            'maternal_surname' => $persona->apellido_materno,
            'rfc' => $persona->rfc,
            'curp' => $persona->curp,
            'zip_code' => $persona->codigo_postal,
        ]);
        Session::forget('employee');
        Session::forget('persona');
        return redirect()->route('admin.employees')->with('success', 'Datos Verificados correctamente.');
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

        $batchArchivo = 'empleados.txt';
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
        //public_path('eficiente/zip/CUHC990830HCSRTR06.zip')
        $zipFilePath = $request->file('zip');
        $extractPath = public_path('eficiente/extracted_files'); // Ruta donde se extraerán los archivos

        $zip = new ZipArchive();
        $extractPath = $extractPath . '/' . uniqid();
        if ($zip->open($zipFilePath) === true) {
            // Iterar sobre cada archivo dentro del ZIP

            for ($i = 0; $i < $zip->numFiles; $i++) {
                // Obtener información del archivo
                $fileInfo = $zip->statIndex($i);
                // Nombre del archivo dentro del ZIP
                $fileName = $fileInfo['name'];

                // Extraer el contenido del archivo a la ruta especificada
                // echo "Extracted file path: $extractedFilePath\n";
                $path = $extractPath . '/' . uniqid();
                if (pathinfo($fileName, PATHINFO_EXTENSION) === 'pdf') {
                    $zip->extractTo($path, $fileName);

                    $extractedFilePath = $path . '/' . $fileName;
                    // unlink($extractedFilePath);
                    try {
                        $rutaDocumento = $extractedFilePath;
                        $persona = $this->readPdf($rutaDocumento);
                        // return Carbon::parse($persona->regimenes[0]->fecha_alta->date)->format('Y-m-d');
                        // return date('Y-m-d',$persona->regimenes[0]->fecha_alta->date);
                        // return 'hola';
                        // foreach($persona->regimenes as $regimen){
                        //     return date('Y-m-d',$regimen->fecha_alta->date);
                        //     return $regimen->fecha_alta->date;
                        // }
                        if ($persona->tipo == 'fisica') {
                            $this->personaFisica($persona);
                        } else {
                            $this->personaMoral($persona);
                        }
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
            // Cerrar el archivo ZIP
            $zip->close();
            return back()->with('success', 'Archivo ejecutado correctamente');
        } else {
            // Si no se puede abrir el archivo ZIP, maneja el error según sea necesario
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

    public function personaFisica($person)
    {
        try {
            DB::beginTransaction();
            $ult = Employee::max('id') + 1;
            $employee = Employee::create([
                'n_employee' => 'E' . $ult,
                'paternal_surname' => $person->apellido_paterno,
                'maternal_surname' => $person->apellido_materno,
                'name' => $person->nombre,
                'zip_code' => $person->codigo_postal,
                'curp' => $person->curp,
                'rfc' => $person->rfc,
                'nss' => '',
                'n_identification' => '',
                'gender' => 'Otro',
                'nationality' => 'Mexicana',
                'birthdate' => $person->fecha_nacimiento->date,
                'rfc_data' => $person,
                'contacts' => [
                    'email' => $person->correo_electronico,
                    'telephone' => '',
                ],
                'emergency_contacts' => '',
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
                    $employee->tax_regimes()->attach($taxRegime->id, [
                        'start_date' => Carbon::parse($regimen->fecha_alta->date)->format('Y-m-d'),
                        'end_date' => $end_date,
                        'status' => $status,
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function personaMoral($person)
    {
        try {
            DB::beginTransaction();
            $client = Client::create([
                'company_name' => $person->razon_social,
                'capital_regime' => $person->regimen_de_capital,
                'rfc' => $person->rfc,
                'start_date' => $person->fecha_inicio_operaciones->date,
                'status' => $person->situacion_contribuyente == 'ACTIVO' ? 1 : 0,
                'updated_date' => $person->fecha_ultimo_cambio_situacion->date,
                'state' => $person->entidad_federativa,
                'city' => $person->municipio_delegacion,
                'rfc_data' => $person,
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
                    $client->tax_regimes()->attach($taxRegime->id, [
                        'start_date' => Carbon::parse($regimen->fecha_alta->date)->format('Y-m-d'),
                        'end_date' => $end_date,
                        'status' => $status,
                    ]);
                }
            }

            Contact::create([
                'client_id' => $client->id,
                'email' => $person->correo_electronico,
                'phone' => '',
            ]);
            Address::create([
                'client_id' => $client->id,
                'zip_code' => $person->codigo_postal,
                'road_type' => $person->tipo_vialidad,
                'road_name' => $person->nombre_vialidad,
                'internal_number' => $person->numero_interior,
                'external_number' => $person->numero_exterior,
                'suburb' => $person->colonia,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // return $th->getMessage();
        }
        // return true;
    }
    public function validationRfc()
    {
        return view('employee.validationEmployee');
    }
    public function uploadResponseSat(Request $request)
    {
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
                $employee = Employee::where('rfc',$rfc)->first();
                if($employee){
                    if (strpos($respuesta, 'RFC v?lido') !== false) {
                        $employee->update([
                            'rfc_verified' => 1
                        ]);
                    }else{
                        $employee->update([
                            'comments' => $respuesta
                        ]);
                    }
                }
            }

            // Cerrar el archivo
            fclose($gestor);
        } else {
            // Manejar el caso en que no se pudo abrir el archivo
            return back()->with('denied','No se pudo leer el archivo');
        }
    }
}
