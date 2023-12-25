<?php

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BucketController extends Controller
{
    protected $s3Client;

    public function __construct()
    {
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => config('aws.region'),
            'credentials' => [
                'key' => config('aws.key'),
                'secret' => config('aws.secret'),
            ],
        ]);
    }

    public function createFolder()
    {
        $bucketName = config('filesystems.disks.s3.bucket');
        $folderName = Str::lower(Str::random(10));

        try {
            $this->s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $folderName . '/',
                'Body' => ''
            ]);

            return response()->json(['message' => $folderName]);
        } catch (AwsException $e) {
            Log::error("Error creating folder: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create folder'], 500);
        }
    }

    public function uploadFiles(Request $request)
    {
        $bucketName = config('filesystems.disks.s3.bucket');
        $folderName = $request->folder;
        $uploadedFiles = $request->file('files');

        foreach ($uploadedFiles as $file) {
            if ($file->getSize() > 100 * 1024 * 1024) {
                $this->uploadLargeFile($bucketName, $folderName, $file);
            } else {
                $this->uploadSmallFile($folderName, $file);
            }
        }

        return response()->json(['message' => "Success"]);
    }

    protected function uploadLargeFile($bucketName, $folderName, $file)
    {
        // Handle large file upload using multipart
        // ...
    }

    protected function uploadSmallFile($folderName, $file)
    {
        // Handle regular file upload
        Storage::disk('s3')->putFileAs(
            $folderName,
            $file,
            $file->getClientOriginalName()
        );
    }

    public function getPresignedURL(Request $request)
    {
        // ...
        try {
            $command = $this->s3Client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            $presignedUrl = $this->s3Client->createPresignedRequest($command, $expiration)->getUri()->__toString();

            Log::info($presignedUrl);

            return $presignedUrl;
        } catch (AwsException $e) {
            Log::error("Error generating presigned URL: " . $e->getMessage());
            return response()->json(['error' => 'Failed to generate presigned URL'], 500);
        }
    }

    public function deleteFromS3($bucketName, $s3Path)
    {
        // ...
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $bucketName,
                'Key' => $s3Path,
            ]);

            // ...
            
            return true;
        } catch (AwsException $e) {
            Log::error("Error deleting from S3: " . $e->getMessage());
            return false;
        }
    }
}
