<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CaretakerProfile;

class CaretakerProfilesController extends Controller
{
    public function index(): void
    {
        $filters = [
            'location' => $_GET['location'] ?? null,
            'availability' => $_GET['availability'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        $profileModel = new CaretakerProfile();
        $profiles = $profileModel->findAllWithFilters($filters);

        $this->render('caretaker-profiles/index', [
            'pageTitle' => 'Find Pet Care Services',
            'profiles' => $profiles,
            'filters' => $filters,
        ]);
    }
}
