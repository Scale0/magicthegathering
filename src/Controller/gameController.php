<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MapService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class gameController extends AbstractController
{
    private $mapService;
    public function __construct(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    public function index()
    {
        $tiles = $this->mapService->generate();

        $data = [];
        for ($i = 1; $i <= max(array_keys($tiles)); $i++) {
            if (array_key_exists($i, $tiles)) {
                for($j = 1; $j <= max(array_keys($tiles[$i])); $j++) {
                    $data[$i][$j] = $this->mapService->getEmptyTile()->getSymbol();
                    if (array_key_exists($j, $tiles[$i])) {
                        $data[$i][$j] = $tiles[$i][$j]['symbol'];
                    }
                }
            }
        }
        return $this->render('game/index.html.twig', ['data' => $data]);
    }
}
