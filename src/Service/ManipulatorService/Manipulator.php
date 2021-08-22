<?php


namespace App\Service\ManipulatorService;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SplFileObject;

class Manipulator
{
    public $location;

    private ValidatorInterface $validator;

    private SluggerInterface $slugger;

    private $order = 'alphabetical';

    private $file;

    public function __construct(ValidatorInterface $validator, SluggerInterface $slugger)
    {
        $this->validator = $validator;
        $this->slugger = $slugger;
    }

    public function setOrder($ordering)
    {
        $this->order = $ordering;
    }


    //sets the folder location to save files
    public function setLocation($location)
    {
        if ($location !== null) {
            $this->location = $location;
        }
    }

    public function processFile($uploadedFile)
    {
        $this->file = $uploadedFile;

        try {
            $errors = $this->validate();

            if (count($errors)) {
                $errorMessage = $errors[0]->getMessage();
                return new JsonResponse(['file' => $errorMessage], 422);
            }

            //save the file
            $this->saveTempFile();

            //create array of strings
            $stringArray = $this->createStringsArray();

            //order the array
            $stringArray = $this->orderArray($stringArray);

            $newFilePath = $this->buildNewSheet($stringArray);

            if(file_exists($this->file->getPathname())) {
                unlink($this->file->getPathname());
            }

            return new JsonResponse(['filePath' => $newFilePath], 200);

        } catch (\Exception $e) {
            return new JsonResponse([$e->getMessage()], 500);
        }
    }

    private function validate(): ConstraintViolationListInterface
    {
        $fileConstraints = new File();
        $fileConstraints->mimeTypes = ['text/plain', "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
        return $this->validator->validate($this->file, $fileConstraints);
    }

    private function saveTempFile(): void
    {
        $originalFilename = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $extension = $this->file->getClientOriginalExtension();
        $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $extension;
        try {
            $this->file = $this->file->move(
                $this->location,
                $newFilename
            );
        } catch (FileException $e) {
            throw $e;
        }
    }

    private function createStringsArray()
    {
        $extension = $this->file->getExtension();
        $stringsArray = false;
        switch ($extension) {
            case 'csv':
            case 'txt':
                $stringsArray = $this->parseTextFile();
                break;
            case 'xlsx':
                $stringsArray = $this->parseSpreadSheet();
                break;
            default:
        }

        return $this->cleanUpStrings($stringsArray);
    }

    private function parseTextFile()
    {
        $file = new SplFileObject($this->file->getPathname());
        $stringsArray = [];

        while (!$file->eof()) {
            $stringsArray[] = preg_replace("/\r|\n/", "", $file->fgets());
        }

        return $stringsArray;
    }

    private function cleanUpStrings($stringsArray)
    {
        $stringsArray = array_filter($stringsArray, function ($value) {
            return !is_null($value) && $value !== '';
        });
        return array_unique($stringsArray, SORT_STRING);
    }

    /**
     * @throws Exception
     */
    private function parseSpreadSheet(): array
    {
        $inputFileType = IOFactory::identify($this->file->getPathname());
        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($this->file->getPathname());
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray(
            'A1:A' . $highestRow,     // The worksheet range that we want to retrieve
            false,        // Value that should be returned for empty cells
            TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            false         // Should the array be indexed by cell row and cell column
        );

        $stringsArray = [];

        foreach ($dataArray as $row) {
            if ($row[0]) {
                $stringsArray[] = $row[0];
            }
        }

        return $stringsArray;
    }

    private function orderArray(array $stringsArray)
    {
        if ($this->order === 'alphabetical') {

            sort($stringsArray, SORT_STRING);

        } elseif ($this->order === 'length') {

            usort($stringsArray, static function ($a, $b) {
                return strlen($a) - strlen($b);
            });

        }
        return $stringsArray;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function buildNewSheet($stringArray): string
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $data = [];

        foreach($stringArray as $string){
            $data[] = [$string];
        }

        $sheet->fromArray($data, null, 'A1');

        $sheet->setTitle('Sorted strings');

        $writer = new Xlsx($spreadsheet);
        $fileName = '/sorted_sheet'.uniqid('', true).'.xlsx';
        $excelFilepath =  $this->location . $fileName;

        $writer->save($excelFilepath);

        return $fileName;
    }


}