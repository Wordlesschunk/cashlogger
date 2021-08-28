<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Form\CsvImportType;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Filesystem
     */
    private $system;

    /**
     * BaseController constructor.
     * @param EntityManagerInterface $entityManager
     * @param Filesystem $system
     */
    public function __construct(EntityManagerInterface $entityManager, Filesystem $system)
    {
        $this->entityManager = $entityManager;
        $this->system = $system;
    }

    #[Route('/', name: 'base_app')]
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(CsvImportType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['attachment']->getData();
            $file->move('../src/csvUploaded', 'transactions.csv');

            $csv = Reader::createFromPath('../src/csvUploaded/transactions.csv', 'r');

            $csv->setHeaderOffset(0);

            foreach ($csv as $row) {

                $transactions = (new Transactions())
                    ->setDate($row['Date'])
                    ->setDescription($row['Description'])
                    ->setMoneyIn($row['Money in'])
                    ->setMoneyOut($row['Money Out']);


                $this->entityManager->persist($transactions);
            }

            $this->entityManager->flush();
            $this->system->remove('../src/csvUploaded/transactions.csv');

            return $this->redirectToRoute('base_app');
        }

        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
            'form' => $form->createView(),
        ]);
    }
}