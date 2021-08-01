<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Entity\DailyTotal;
use App\Repository\DailyTotalRepository;
use App\Service\CmcService;
use App\Service\DailyTotalService;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'chart')]

    public function chart(ChartBuilderInterface $chartBuilder, DailyTotalRepository $dailyTotalRepository): Response
    {   

        $labels = [];
        $datasets = [];

        $chartdata = $dailyTotalRepository->findBy(array(), array('date' => 'DESC'), 7);

        foreach($chartdata as $data) {
               $labels[] = $data->getDate()->format('d/m');
               $datasets[] = $data->getValue();
         }
        
         $reversedlabels = array_reverse($labels);
         $reverseddatasets = array_reverse($datasets);

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $reversedlabels,
            'datasets' => [
                [
                    'label' => 'Daily Total',
                    'borderColor' => 'rgb(31, 195, 108)',
                    'data' => $reverseddatasets,
                ],
            ],
        ]);

        $chart->setOptions([
            'legend' => false,
        ]);

        return $this->render('chart/chart.html.twig', [
            'values' => $dailyTotalRepository->findAll(),
            'chart' => $chart,
        ]);
    }
}
