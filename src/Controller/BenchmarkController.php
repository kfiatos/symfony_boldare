<?php

namespace App\Controller;

use App\Commands\BenchmarkCommand;
use App\Dto\SiteUrlsDto;
use App\Helpers\BenchmarkDataFormatters\BenchmarkResultsTwigViewFormatter;
use App\Service\BenchmarkQueryService;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BenchmarkController extends AbstractController
{
    public function benchmark(Request $request, CommandBus $commandBus, BenchmarkQueryService $benchmarkQueryService)
    {
        if($request->getMethod() !== Request::METHOD_POST) {
            return $this->render('benchmark/benchmark.html.twig');
        }

        $baseSite = $request->get('base_site', '');
        $comparedSites = $request->get('compared_sites');
        $notificationEmailAddress = $request->get('email', '');
        $notificationEmailAddress = filter_var($notificationEmailAddress, FILTER_SANITIZE_EMAIL);
        $notificationEmailAddress = filter_var($notificationEmailAddress, FILTER_VALIDATE_EMAIL);

        list($baseSite, $isValidBaseSiteInput) = $this->validateBaseSiteInput($baseSite);
        list($comparedSites, $isValidComparedSitesInput) = $this->validateComparedSitesInput($comparedSites);


        if (!$isValidBaseSiteInput || !$isValidComparedSitesInput || $notificationEmailAddress === false) {
            $this->addFlash('error', 'Both input fields has to be filled and email has to be valid');
            return $this->render('benchmark/benchmark.html.twig');
        }

        $benchmarkedSitesDto = new SiteUrlsDto($baseSite, $comparedSites, new \DateTime(''));

        //Hardcoded for the sake of simplicity (can be loaded from for ex: authenticated user)
        $mobileNumber = '123456789';
        $benchmarkCommand = new BenchmarkCommand(
            $benchmarkedSitesDto,
            $notificationEmailAddress,
            $mobileNumber
        );

        $commandBus->handle($benchmarkCommand);

        $benchmarkResults =
            $benchmarkQueryService->findBenchmarkResultsByBaseSiteAndDate($benchmarkedSitesDto->getBenchmarkDate());

        $results = BenchmarkResultsTwigViewFormatter::prepareResults($benchmarkResults);

        return $this->render('benchmark/benchmark.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @param string $baseSite
     * @return array
     */
    protected function validateBaseSiteInput(string $baseSite): array
    {
        $isValid = true;
        if (empty($baseSite)) {
            $isValid = false;
        }

        $baseSite = filter_var($baseSite, FILTER_SANITIZE_URL);
        $baseSite = filter_var($baseSite, FILTER_VALIDATE_URL);

        if ($baseSite === false) {
            $isValid = false;
        }

        return [
            $baseSite,
            $isValid
        ];
    }

    /**
     * @param string $comparedSites
     * @return array
     */
    protected function validateComparedSitesInput($comparedSites): array
    {
        $isValid = true;
        if (empty($comparedSites)) {
            $isValid = false;
        }

        $comparedSites = str_replace([',', '|'], ',', $comparedSites);
        $comparedSites = explode(',', $comparedSites);

        foreach ($comparedSites as &$comparedSite) {
            $comparedSite = filter_var(trim($comparedSite), FILTER_SANITIZE_URL);
            $comparedSite = filter_var($comparedSite, FILTER_VALIDATE_URL);
        }
        //remove false values (validated to be incorrect)
        $comparedSites = array_filter($comparedSites);

        return [
            $comparedSites,
            $isValid
        ];
    }


}
