<?php

namespace App\Controllers;

use App\Domain\Csv\Domain\Csv;
use App\Domain\Csv\Application\CsvToJson;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CsvToJsonParserController
{

    #[Route('/csv2json/parser', name: 'csv_to_json_parser', methods: ['POST'])]
    public function parser(Request $request): JsonResponse
    {
        $csv_to_json_service = new CsvToJson();

        $csv_file = $request->files->get('csv');
        if ($csv_file and $csv_file instanceof UploadedFile) {
            $csv_content = file_get_contents($csv_file->getPathname());
        } else {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'message' => 'file missing'
            ]),200,[],true);
        }

        $csv = new Csv($csv_content,';');
        $csv_to_json_service->setcsv($csv);
        $json = $csv_to_json_service();
        
        return new JsonResponse($json, 200, [], true);
    }
}
