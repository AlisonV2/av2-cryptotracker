<?php

namespace App\Controller;

use App\Entity\Transaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TransactionType;
use DateTime;

class TransactionController extends AbstractController

{   
    #[Route('/addtransaction', name: 'addtransaction')]

    public function addTransaction (Request $request): Response 
    
    {
        $transactions = new Transaction;

        $form = $this->createForm(TransactionType::class, $transactions, ['add' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $transactions = $form->getData();
            $transactions ->setDate(new DateTime ());
            $transactions ->setTransactionType('add');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transactions);
            $entityManager->flush(); 

            return $this->redirectToRoute('addtransaction');
        }

        return $this->render('transaction/addtransaction.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/removetransaction', name: 'removetransaction')]

    public function removeTransaction (Request $request): Response 
    
    {
        $transactions = new Transaction;

        $form = $this->createForm(TransactionType::class, $transactions, ['add' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $transactions = $form->getData();
            $transactions ->setDate(new DateTime ());
            $transactions ->setTransactionType('remove');
            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transactions);
            $entityManager->flush(); 

            return $this->redirectToRoute('removetransaction');
        }

        return $this->render('transaction/removetransaction.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
