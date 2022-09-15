<?php

namespace App\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatusCheck
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
