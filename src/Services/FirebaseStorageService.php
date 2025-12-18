<?php
namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseStorageService
{
    private $storage;
    private $bucketName;

    public function __construct()
    {
        $serviceAccountPath = $_ENV['FIREBASE_CREDENTIALS'] ?? __DIR__ . '/../../config/firebase_credentials.json';

        if (!file_exists($serviceAccountPath)) {
            throw new \Exception("Firebase credentials file not found at: {$serviceAccountPath}");
        }

        $this->bucketName = $_ENV['FIREBASE_STORAGE_BUCKET'] ?? null;
        if (!$this->bucketName) {
            throw new \Exception("FIREBASE_STORAGE_BUCKET environment variable is not set. Please add it to your configuration.");
        }

        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $this->storage = $factory->createStorage();
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
        $bucket = $this->storage->getBucket($this->bucketName);

        // Create a unique name for the file to avoid conflicts
        $sanitizedFileName = preg_replace("/[^a-zA-Z0-9.\-_]/", "", $originalFileName);
        $fileName = 'pet_images/' . uniqid() . '-' . $sanitizedFileName;

        $fileStream = fopen($tmpFilePath, 'r');

        $object = $bucket->upload($fileStream, [
            'name' => $fileName,
            'predefinedAcl' => 'publicRead' // Make the file publicly accessible
        ]);

        return $object->info()['mediaLink'];
    }

    /**
     * Deletes a file from Firebase Storage using its public URL.
     *
     * @param string $url The public URL of the file to delete.
     */
    public function deleteFileByUrl(string $url): void
    {
        $bucket = $this->storage->getBucket($this->bucketName);

        // Extract the object path from the URL.
        if (preg_match('/\/o\/(.*?)\?alt=media/', $url, $matches)) {
            $objectPath = urldecode($matches[1]);
            $object = $bucket->object($objectPath);

            if ($object->exists()) {
                $object->delete();
            }
        }
    }
}
