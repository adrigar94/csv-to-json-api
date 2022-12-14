<?php

namespace App\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatusCheckController
{

    #[Route('/status', name: 'check_status', methods: ['GET'])]
    public function status(): JsonResponse
    {
        $json = json_encode([
            'success' => true
        ]);
        return new JsonResponse($json, 200, [], true);
    }
}
