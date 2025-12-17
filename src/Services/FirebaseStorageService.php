<?php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseStorageService
{
    private $storage;
    private $defaultBucket;

    public function __construct()
    {
        // Path to your Firebase service account JSON file.
        // It's recommended to store this path in your .env file.
        $serviceAccountPath = $_ENV['FIREBASE_CREDENTIALS'] ?? __DIR__ . '/../../config/firebase_credentials.json';

        if (!file_exists($serviceAccountPath)) {
            throw new \Exception("Firebase credentials file not found at: {$serviceAccountPath}");
        }

        $serviceAccount = ServiceAccount::fromValue($serviceAccountPath);
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        $this->storage = $firebase->getStorage();
        $this->defaultBucket = $firebase->getProject_id() . '.appspot.com';
    }

    /**
     * Uploads an image to Firebase Storage.
     *
     * @param string $tmpFilePath The temporary path of the uploaded file (e.g., $_FILES['image']['tmp_name'])
     * @param string $originalFileName The original name of the file (e.g., $_FILES['image']['name'])
     * @return string The public URL of the uploaded file.
     */
    public function uploadImage(string $tmpFilePath, string $originalFileName): string
    {
        $bucket = $this->storage->getBucket($this->defaultBucket);

        // Create a unique name for the file to avoid conflicts
        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9.\-_]/", "", $originalFileName);
        $fileName = 'pet_images/' . uniqid() . '-' . $sanitizedFileName;

        $fileStream = fopen($tmpFilePath, 'r');

        $object = $bucket->upload($fileStream, [
            'name' => $fileName,
            'predefinedAcl' => 'publicRead' // Make the file publicly accessible
        ]);

        // Return the public URL
        return $object->info()['mediaLink'];
    }
}
