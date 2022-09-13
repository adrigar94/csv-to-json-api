<?php

namespace App\Controllers;

use App\CsvToJson;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CsvToJsonParserController
{

    private CsvToJson $csv_to_json_service;

    public function __construct()
    {
        $this->csv_to_json_service = new CsvToJson();
    }

    #[Route('/csv2json/parser', name: 'csv_to_json_parser', methods: ['POST'])]
    public function parser(Request $request): JsonResponse
    {
        $csv_file = $request->files->get('csv');
        if ($csv_file and $csv_file instanceof UploadedFile) {
            $csv_content = file_get_contents($csv_file->getPathname());
        } else {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'message' => 'file missing'
            ]));
        }
        $this->csv_to_json_service->setcsv($csv_content);
        $json = $this->csv_to_json_service->__invoke();
        return new JsonResponse($json, 200, [], true);
    }


    #[Route('/status', name: 'csv_to_json_parser', methods: ['GET'])]
    public function status(): JsonResponse
    {
        $json = json_encode([
            'success' => true
        ]);
        return new JsonResponse($json, 200, [], true);
    }
}
