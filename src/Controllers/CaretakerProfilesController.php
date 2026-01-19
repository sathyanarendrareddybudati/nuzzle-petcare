<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CaretakerProfile;

class CaretakerProfilesController extends Controller
{
    public function index(): void
    {
        $filters = [
            'location' => isset($_GET['location']) ? htmlspecialchars(trim($_GET['location'])) : null,
            'availability' => isset($_GET['availability']) ? htmlspecialchars(trim($_GET['availability'])) : null,
            'sort' => isset($_GET['sort']) ? htmlspecialchars(trim($_GET['sort'])) : 'newest',
        ];

        $profileModel = new CaretakerProfile();
        $profiles = $profileModel->findAllWithFilters($filters);

        $this->render('caretaker-profiles/index', [
            'pageTitle' => 'Find Pet Care Services',
            'profiles' => $profiles,
            'filters' => $filters,
        ]);
    }

    public function show(int $id): void
    {
        if ($id <= 0) {
            $this->redirect('/errors/404');
            return;
        }

        $profileModel = new CaretakerProfile();
        $profile = $profileModel->find($id);

        if (!$profile) {
            $this->redirect('/errors/404');
            return;
        }

        $this->render('caretaker-profiles/show', [
            'profile' => $profile,
        ]);
    }
}
