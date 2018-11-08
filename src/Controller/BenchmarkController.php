<?php

namespace App\Controller;

use App\Dto\SiteUrlsDto;
use App\Service\Benchmark;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BenchmarkController extends AbstractController
{
    public function index()
    {
        return $this->render('benchmark/index.html.twig', [
            'controller_name' => 'BenchmarkController',
        ]);
    }

    public function benchmark(Request $request, Benchmark $benchmark)
    {
        //TODO add symfony form with validation
        $site1Url = $request->get('site1');
        $site2Url = $request->get('site2');

        $benchmarkedSitesDto = new SiteUrlsDto($site1Url, $site2Url);

        $benchmark->performSiteBenchmark($benchmarkedSitesDto);
        $results = $benchmark->getBenchmarkResultsForView();
        return new Response($results, Response::HTTP_OK);
    }


}
