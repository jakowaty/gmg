<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\DistrictService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{
    #[Route(path: '/district', name: 'district_index')]
    public function index(Request $request, DistrictService $districtService): Response
    {
        $filters = $request->query->all('filters');

        return $this->render('district/index.html.twig', [
            'pagination' => $districtService->createPagination(filters: $filters),
            'filters' => $filters
        ]);
    }

    #[Route(path: '/district/{id}/upload', name: 'district_file_receive')]
    public function fileReceive(string $id, Request $request, DistrictService $districtService): Response
    {
        if ($request->files->count() !== 1) {
            return new Response("There must be uploaded exactly one file");
        }

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        try {
            $fileName = $districtService->uploadFileForDistrict($id, $file);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage());
        }

        return new Response($fileName, Response::HTTP_CREATED);
    }

}