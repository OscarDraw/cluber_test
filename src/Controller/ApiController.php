<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity;

define("unit_price", 3);

class ApiController extends AbstractController
{
    
    /**
     * @Route("/api", name="api")
     */
    public function getAll(): Response
    {
        $movies = $this->getDoctrine()
            ->getRepository(Entity\Movie::class)
            ->findAll();
        if (!$movies) {
            return $this->json('No movies found' , 404);
        }
        $data = [];

        foreach ($movies as $movie) {
            $data[] = [
                'id' => $movie->getId(),
                'name' => $movie->getName(),
                'type' => $this->getTypeById($movie->getType()),
            ];
        }


        return $this->json($data);
    }

    /**
     * @Route("/api/type/{type}", name="movie_type", methods={"GET"})
     */
    public function showByType(int $type): Response
    {
        $movies = $this->getDoctrine()
            ->getRepository(Entity\Movie::class)
            ->findBy(array('type' => $type));

        if (!$movies) {
            return $this->json('No movies found' , 404);
        }

        $data = [];

        foreach ($movies as $movie) {
            $data[] = [
                'id' => $movie->getId(),
                'name' => $movie->getName()
            ];
        }

        return $this->json([
            'type' => $this->getTypeById($type), 
            'movies' => $data
        ]);
    }

    /**
     * @Route("/api/invoice/", name="new_invoice", methods={"POST"})
     */
    public function newInvoice(Request $request): Response
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $total = 0;
        $totalPoints = 0;
        $date_invoice = ($json['date']) ? new \DateTime('@'.strtotime($json['date'])) : new \DateTime('@'.strtotime('now'));
        $costumer = $this->getDoctrine()
            ->getRepository(Entity\Costumer::class)
            ->find($json['costumer_id']);

        $invoice = new Entity\Invoice();
        $invoice->setCustomer($costumer);
        $invoice->setRentalStartDate($date_invoice);
        
        try {
            $entityManager->persist($invoice);
            $entityManager->flush();
        } catch (\Throwable $th) {
            return $this->json("Error saving invoice");
        }

        $moviesRental = $json['movies'];
        foreach ($moviesRental as $key => $movie){
            if($movie['movie_id']){
                $price = 0;
                $points = 0;
                
                $movie_date = date($json['date']);
                $Rental = new Entity\MovieRental();
                $Rental->setInvoice(($invoice) ? $invoice : null);
                $Rental->setReturnDate(($movie['return_date']) ? new \DateTime('@'.strtotime($movie['return_date'])) : new \DateTime('@'.strtotime('now')));

                $movieClass = $this->getDoctrine()
                    ->getRepository(Entity\Movie::class)
                    ->find($movie['movie_id']);

                $Rental->setMovie($movieClass);
    
    
                // Calculating price and loyatly points
                if($movieClass){

                    $type = $movieClass->getType();

                    //days difference
                    $day_start = new \DateTime($movie_date);
                    $day_end  = new \DateTime($movie['return_date']);
                    $day_diff = $day_start->diff($day_end);
                    $day_diff_num = $day_diff->format('%r%a');

                    switch($type){
                        case 0:
                            $price += unit_price * $day_diff_num;
                            $points = 2;
                            break;
                        case 1:
                            $price += (unit_price * 3);
                            for ($i=4; $i <= $day_diff_num; $i++) { 
                                $price += unit_price;
                            }
                            $points = 1;
                            break;
                        case 2:
                            $price += (unit_price * 5);
                            for ($i=4; $i <= $day_diff_num; $i++) { 
                                $price += unit_price;
                            }
                            $points = 1;
                            break;
                    }
                }

                $Rental->setPrice($price);
                $Rental->setPoints($points);
                $total += $price;
                $totalPoints += $points;

                try {
                    $entityManager->persist($Rental);
                    $entityManager->flush();
                } catch (\Throwable $th) {
                    return $this->json("Error saving Rental");
                }
            }
        }
        $costumer->setLoyaltyPoints(($costumer) ? $costumer->getLoyaltyPoints() + $totalPoints : $totalPoints);
 
        try {
            $entityManager->persist($costumer);
            $entityManager->flush();
        } catch (\Throwable $th) {
            return $this->json("Error saving costumer");
        }

        $entityManager->flush();
 
        return $this->json([
            'status' => 'Created new invoice successfully with id ' . $invoice->getId(),
            'price' => $total
        ]);
    }

    /**
     * @Route("/api/loyalty/{customer_id}", name="customer_loyalty", methods={"GET"})
     */
    public function getLoyaltycustomer(int $customer_id): Response
    {
        $costumer = $this->getDoctrine()
            ->getRepository(Entity\Costumer::class)
            ->find($customer_id);

        if (!$costumer) {
            return $this->json('No costumer found' , 404);
        }

        $points = $costumer->getLoyaltyPoints();

        return $this->json([
            'customer' => $costumer->getName(), 
            'points' => $points
        ]);
    }

    public function getTypeById($id): string
    {
        switch($id){
            case 0:
                return 'New';
            case 1:
                return 'Normal';
            case 2:
                return 'Old';
        }
    }

}
