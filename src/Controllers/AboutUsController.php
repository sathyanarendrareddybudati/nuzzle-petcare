<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;
/**
 * AboutUsController
 * Handles the request for the Nuzzle PetCare About Us page.
 */
class AboutUsController extends Controller {

    /**
     * Renders the static About Us page.
     * * @return void
     */
    public function index() {
        // --- 1. Data Initialization (Minimal for a static page) ---
        
        // Define any variables that the view (HTML file) might need.
        $page_data = [
            'brand_name' => 'Nuzzle',
            'page_title' => 'Meet the Team - Nuzzle PetCare',
            // In a real app, you might fetch team members from a database here:
            // 'team_members' => $this->teamModel->getVisibleMembers() 
        ];

        // Extract the array into local variables for the view script 
        // (e.g., $brand_name, $page_title will now be available in the view).
        extract($page_data);
        
        // --- 2. View Rendering ---

        // The controller includes the PHP file that contains the HTML/CSS structure.
        // Assuming your HTML/CSS file is saved as 'about-us-view.php' in a 'views' directory.
        $view_path = 'views/about-us-view.php'; 
        
        if (file_exists($view_path)) {
            // This includes the HTML/CSS code, allowing it to use the variables above.
            require $view_path;
        } else {
            // Fallback if the view is missing (Good practice)
            echo "Error: About Us view file not found!";
        }
    }
}

// --- Usage Example (How the router would call this) ---
/*
$controller = new AboutUsController();
$controller->index();
*/

?>