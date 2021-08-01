<?php

namespace App\Controller;

use App\Entity\DailyTotal;
use App\Repository\DailyTotalRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CmcService;
use DateInterval;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]

    public function DailyValue(CmcService $cmcService, TransactionRepository $transactionRepository)
    {   
        $showLastTransactions = $transactionRepository -> getLastTransactions('add');
       
        $btcPrice = $cmcService->getApiPrice('BTC');
        $ethPrice = $cmcService->getApiPrice('ETH');
        $xrpPrice = $cmcService->getApiPrice('XRP');
        
        $btcQuantity = $transactionRepository->getTotalQuantity('BTC');
        $ethQuantity = $transactionRepository->getTotalQuantity('ETH');
        $xrpQuantity = $transactionRepository->getTotalQuantity('XRP');

        $btcCurrentPrice = $btcQuantity * $btcPrice;
        $ethCurrentPrice = $ethQuantity * $ethPrice;
        $xrpCurrentPrice = $xrpQuantity * $xrpPrice;

        $dailyTotal = $btcCurrentPrice + $ethCurrentPrice + $xrpCurrentPrice;

        return $this->render('home/home.html.twig', [
            'total' => $dailyTotal,
            'transactions' => $showLastTransactions,
            'currentBTCPrices' => $btcPrice,
            'currentETHPrices' => $ethPrice, 
            'currentXRPPrices' => $xrpPrice, 
            'btcQuantity' => $btcQuantity,
            'ethQuantity' => $ethQuantity,
            'xrpQuantity' => $xrpQuantity,
        ]);
    }
    #[Route('/cron', name: 'cron')]

    public function SaveDailyValue(CmcService $cmcService, TransactionRepository $transactionRepository)
    {   
        $showLastTransactions = $transactionRepository -> getLastTransactions('add');
        
        $btcPrice = $cmcService->getApiPrice('BTC');
        $ethPrice = $cmcService->getApiPrice('ETH');
        $xrpPrice = $cmcService->getApiPrice('XRP');
        
        $btcQuantity = $transactionRepository->getTotalQuantity('BTC');
        $ethQuantity = $transactionRepository->getTotalQuantity('ETH');
        $xrpQuantity = $transactionRepository->getTotalQuantity('XRP');

        $btcCurrentPrice = $btcQuantity * $btcPrice;
        $ethCurrentPrice = $ethQuantity * $ethPrice;
        $xrpCurrentPrice = $xrpQuantity * $xrpPrice;

        $dailyTotal = $btcCurrentPrice + $ethCurrentPrice + $xrpCurrentPrice;

        /*$today = new DateTime();
        $yesterday = $today->sub(new DateInterval('P1D'));

        if ($today !== $yesterday)*/

            $total = new DailyTotal();

            $total ->setDate(new DateTime());
            $total ->setValue($dailyTotal);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($total);
            $entityManager->flush(); 

        return $this->render('home/home.html.twig', [
            'total' => $dailyTotal,
            'totalvalue' => $total,
            'transactions' => $showLastTransactions,
            'currentBTCPrices' => $btcPrice,
            'currentETHPrices' => $ethPrice, 
            'currentXRPPrices' => $xrpPrice, 
            'btcQuantity' => $btcQuantity,
            'ethQuantity' => $ethQuantity,
            'xrpQuantity' => $xrpQuantity,
        ]);
    }
}