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
use App\Models\Person;
use App\Models\RfcData;
use App\Models\TaxRegime;
use Carbon\Carbon;
use Exception;
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
        return $request;
        try {
            $person = Person::create([
                'rfc' => $request->rfc,
                'type' => 'fiscal',
            ]);
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
        try {
            if ($request->opcion == 'rfc_invalid') {
                $employees = Person::with(['employee', 'addresses'])
                    ->whereHas('employee', function ($query) {
                        $query->where('rfc_verified', 0);
                    })
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->employee->name . ' ' . $person->employee->paternal_surname . ' ' . $person->employee->maternal_surname,
                            'zip_code' => $person->addresses[0]->zip_code,
                        ];
                    });
            } elseif ($request->opcion == 'all_active') {
                $employees = Person::with(['employee', 'addresses'])
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->employee->name . ' ' . $person->employee->paternal_surname . ' ' . $person->employee->maternal_surname,
                            'zip_code' => $person->addresses[0]->zip_code,
                        ];
                    });
            } elseif ($request->opcion == 'all') {
                $employees = Person::with(['employee', 'addresses'])
                    ->get()
                    ->map(function ($person) {
                        return [
                            'rfc' => $person->rfc,
                            'full_name' => $person->employee->name . ' ' . $person->employee->paternal_surname . ' ' . $person->employee->maternal_surname,
                            'zip_code' => $person->addresses[0]->zip_code,
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
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('denied','Sucedio un error.');
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
                        if ($persona->tipo == 'fiscal') {
                            $this->createEmployee($persona);
                        }
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
            $data->tipo = 'fiscal';
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

    public function createEmployee($person)
    {
        try {
            DB::beginTransaction();
            $newperson = Person::create([
                'rfc' => $person->rfc,
                'type' => 'employee',
                'regimen' => 'fiscal',
                'start_date' => Carbon::parse($person->fecha_inicio_operaciones->date)->format('Y-m-d'),
                'status' => $person->situacion_contribuyente,
            ]);

            $ult = Employee::max('id') + 1;
            Employee::create([
                'n_employee' => 'E' . $ult,
                'person_id' => $newperson->id,
                'paternal_surname' => $person->apellido_paterno,
                'maternal_surname' => $person->apellido_materno,
                'name' => $person->nombre,
                'curp' => $person->curp,
                'rfc' => $person->rfc,
                'nss' => '',
                'n_identification' => '',
                'gender' => 'Otro',
                'nationality' => 'Mexicana',
                'birthdate' => Carbon::parse($person->fecha_nacimiento->date)->format('Y-m-d'),
                'emergency_contacts' => '',
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
        return view('employee.validationEmployee');
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
                            'rfc_verified' => 1
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
            if ($request->type == 'employee') {
                if ($persona->tipo == 'fiscal') {
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

            if ($persona->tipo == 'fiscal') {
                $this->createEmployee($persona);
            } else {
                return back()->with('denied', 'Verificar archivo <br> Solo se pueden dar de alta a personas fisicas..');
            }
        } catch (\Throwable $th) {
            return back()->with('denied', 'No se econtro a la persona verificar datos.');
        }
        if ($request->type == 'employee') {
            return redirect()->route('admin.employees')->with('success', 'Empleado creado correctamente');
        } else {
            return redirect()->route('admin.employees')->with('success', 'Cliente creado correctamente');
        }
    }
}
