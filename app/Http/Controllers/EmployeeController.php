<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Models\BloodType;
use App\Models\Employee;
use App\Models\IdentificationEmployee;
use App\Models\InstituteHealth;
use App\Models\MaritalStatus;
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
            $cif = $this->CIF($rutaDocumento);
            $rfc = Rfc::parse($this->RFC($rutaDocumento));
            $person = $scraper->obtainFromRfcAndCif(rfc: $rfc, idCIF: $cif);
            $persona = json_encode($person);
            $persona = json_decode($persona);
            return $persona;
            $employee = Employee::find($id);
            Session::put('employee', $employee);
            Session::put('persona', $persona);
            return view('employee.verified', compact('employee', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function CIF($path)
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

    public function RFC($path)
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
            $scraper = Scraper::create();

            $rfc = Rfc::parse($request->rfc);

            $person = $scraper->obtainFromRfcAndCif(rfc: $rfc, idCIF: $request->cif);
            $persona = json_encode($person);
            $persona = json_decode($persona);
            $employee = Employee::find($id);
            Session::put('employee', $employee);
            Session::put('persona', $persona);
            return view('employee.verified', compact('employee', 'persona'));
        } catch (\Throwable $th) {
            return back()->with('denied', 'Verificar archivo <br> Datos ilegibles o archivo invalido.');
        }
    }

    public function export_rfc()
    {
        // Datos que deseas exportar
        $employees = Employee::get()->map(function ($employee) {
            return [
                'rfc' => $employee->id,
                'full_name' => $employee->name . ' ' . $employee->paternal_surname . ' ' . $employee->maternal_surname,
                'zip_code',
            ];
        });

        // Nombre del archivo de texto
        $archivo = 'datos.txt';
        $employees = $employees->toArray();

        // Abrir el archivo en modo escritura
        ($archivo_handle = fopen($archivo, 'w')) or die('No se puede abrir el archivo.');

        // Iterar sobre los datos y escribir en el archivo
        foreach ($employees as $fila) {
            fwrite($archivo_handle, implode('|', $fila) . "|\n");
        }

        // Cerrar el archivo
        fclose($archivo_handle);

        // Descarga del archivo
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($archivo) . '"');
        header('Content-Length: ' . filesize($archivo));
        readfile($archivo);
        return view('employee.export');
    }
    public function uploadZip(Request $request)
    {
        //public_path('eficiente/zip/CUHC990830HCSRTR06.zip')
        $zipFilePath = $request->file('zip');
        $extractPath = public_path('eficiente/extracted_files'); // Ruta donde se extraerán los archivos

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath) === true) {
            // Iterar sobre cada archivo dentro del ZIP

            for ($i = 0; $i < $zip->numFiles; $i++) {
                // Obtener información del archivo
                $fileInfo = $zip->statIndex($i);
                // Nombre del archivo dentro del ZIP
                $fileName = $fileInfo['name'];

                // Extraer el contenido del archivo a la ruta especificada
                // echo "Extracted file path: $extractedFilePath\n";

                if (pathinfo($fileName, PATHINFO_EXTENSION) === 'pdf') {
                    $zip->extractTo($extractPath, $fileName);

                    $extractedFilePath = $extractPath . '/' . $fileName;
                    // unlink($extractedFilePath);
                    try {
                        $scraper = Scraper::create();
                        $rutaDocumento = $extractedFilePath;
                        $cif = $this->CIF($rutaDocumento);
                        $rfc = Rfc::parse($this->RFC($rutaDocumento));
                        $person = $scraper->obtainFromRfcAndCif(rfc: $rfc, idCIF: $cif);
                        $persona = json_encode($person);
                        $persona = json_decode($persona);

                        $resultados[$i]['respuesta'] = $persona;
                        $resultados[$i]['status'] = true;

                        if ($rfc->isFisica()) {
                            $resultados[$i]['tipo'] = 'fisica';
                        }

                        if ($rfc->isMoral()) {
                            $resultados[$i]['tipo'] = 'moral';
                        }
                    } catch (\Throwable $th) {
                        $resultados[$i]['archivo'] = $fileName;
                        $resultados[$i]['respuesta'] = 'Verificar archivo. Datos ilegibles o archivo invalido.';
                        $resultados[$i]['status'] = false;
                        $resultados[$i]['tipo'] = 'error';
                    }
                } else {
                    $resultados[$i]['archivo'] = $fileName;
                    $resultados[$i]['respuesta'] = 'Verificar archivo. No es un pdf';
                    $resultados[$i]['status'] = false;
                    $resultados[$i]['tipo'] = 'error';
                }
            }
            // Cerrar el archivo ZIP
            $zip->close();
            return $resultados;
        } else {
            // Si no se puede abrir el archivo ZIP, maneja el error según sea necesario
            return back()->with('denied','No se puede leer el archivo');
        }
    }
}
