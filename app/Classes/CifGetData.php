<?php

namespace App\Classes;

use PhpCfdi\CsfScraper\Scraper;
use PhpCfdi\Rfc\Rfc;
use Smalot\PdfParser\Parser;

class CifGetData{

    /**
     * Read a PDF file and extract the CIF data from the PDF.
     *
     * @param string $path The path to the PDF file.
     * @return array An array containing the CIF data.
     * @throws \Exception
     */
    public static function getByDocument(string $path)
    {
        try {
            $cif = self::getIdCif($path);
            $rfc = self::getRfc($path);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
        return self::getCifData($rfc, $cif);
    }

    /**
     * Get the CIF value from the PDF document.
     *
     * The value is extracted from the text of the document by searching for the
     * string 'idCIF:' and then taking the value after the colon.
     *
     * @param string $path The path to the PDF document.
     * @return string The CIF value.
     * @throws \Exception If the PDF document cannot be read.
     */
    public static function getIdCif($path)
    {
        $parser = new Parser();
        try {
            $document = $parser->parseFile($path);
            $text = $document->getText();

            // Search for the 'idCIF:' string in the text.
            $word = 'idCIF:';
            $sentence = strpos($text, $word);

            // If the word is found, extract the CIF value.
            if ($sentence !== false) {
                $idCIF = substr($text, $sentence, 18);
                $arrayWords = explode(': ', $idCIF);
                return $arrayWords[1];
            } else {
                // If the word 'idCIF:' is not found, return an error message.
                return 'La cadena especificada no se encontró en el PDF.';
            }
        } catch (\Exception $e) {
            // If there is an error reading the PDF, throw an exception.
            throw new \Exception('Ocurrió un error al leer el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Get the RFC value from the PDF document.
     *
     * The value is extracted from the text of the document by searching for the
     * string 'RFC:' and then taking the value after the colon.
     *
     * @param string $path The path to the PDF document.
     * @return string The RFC value.
     * @throws \Exception If the PDF document cannot be read.
     */
    public static function getRfc($path)
    {
        $parser = new Parser();
        try {
            $document = $parser->parseFile($path);
            $text = $document->getText();
            $word = 'RFC:';
            $sentence = strpos($text, $word);

            // If the word 'RFC:' is found in the text, extract the RFC value.
            if ($sentence !== false) {
                $idCIF = substr($text, $sentence, 18);
                $arrayWords = explode(":\t", $idCIF);
                return $arrayWords[1];
            } else {
                // If the word 'RFC:' is not found, return an error message.
                return 'La cadena especificada no se encontró en el PDF.';
            }
        } catch (\Exception $e) {
            // If there is an error reading the PDF, throw an exception.
            throw new \Exception('Ocurrió un error al leer el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Get the CIF data using the RFC and CIF values.
     *
     * This method uses the PhpCfdi\CsfScraper library to obtain the data from the
     * CDFI (Centro de Documentación Fiscal de Internet) using the RFC and CIF values.
     * The data is then processed and returned as an array.
     *
     * @param string $rfc The RFC value.
     * @param string $cif The CIF value.
     * @return array The CIF data.
     * @throws \Exception If there is an error obtaining the data from the CDFI.
     */
    public function getCifData(string $rfc, string $cif)
    {
        try {
            $scraper = Scraper::create();
            $rfc = Rfc::parse($rfc);
            $dataCdfi = $scraper->obtainFromRfcAndCif(rfc: $rfc, idCIF: $cif);
            $person = json_encode($dataCdfi);
            $person = json_decode($person);
            $arrayCif = $person;
            if ($rfc->isFisica()) {
                // If the RFC is a physical person, set the type to 'fisica'.
                $arrayCif->tipo = 'fisica';
            }
            if ($rfc->isMoral()) {
                // If the RFC is a moral person, set the type to 'moral'.
                $arrayCif->tipo = 'moral';
            }
        } catch (\Throwable $th) {
            // If there is an error obtaining the data from the CDFI, throw an exception.
            throw new \Exception($th->getMessage());
        }
        return $arrayCif;
    }
}
