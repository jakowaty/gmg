<?php declare(strict_types=1);

namespace App\Controller;

use App\Enum\City;
use App\Message\Command\FetchDistrictCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/fetch')]
class FetchController extends AbstractController
{
    #[Route(path: '/gdansk', name: 'fetch_gdansk')]
    public function gdansk(MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new FetchDistrictCommand(
            City::GDANSK,
            range(1, 35),
            'https://www.gdansk.pl/subpages/dzielnice/html/4-dzielnice_mapa_alert.php?id=%d'
        ));

        return $this->redirectToRoute('district_index');
    }

    #[Route(path: '/krakow', name: 'fetch_krakow')]
    public function krakow(MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new FetchDistrictCommand(
            City::KRAKOW,
            range(25527, 25544),
            'https://www.bip.krakow.pl/?bip_id=1&mmi=%d'
        ));

        return $this->redirectToRoute('district_index');
    }
}