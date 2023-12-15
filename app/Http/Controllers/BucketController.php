<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class BucketController extends Controller
{
    public function createFolder(){
        
        $bucketName = config('filesystems.disks.s3.bucket'); // Replace with your custom bucket name
        $folderName = Str::lower(Str::random(10)); // Specify the folder name you want to create

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => config('aws.region'),
            'credentials' => [
                'key' => 'AKIAVC7LJSPJ6TRFBRBJ',
                'secret' => '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',
            ],
        ]);

        try {
            // Create an empty object with a folder-like key
            $s3->putObject([
                'Bucket' => $bucketName,
                'Key' => $folderName . '/', // Append a forward slash to the folder name
                'Body' => ''
            ]);
            return response()->json(['message' => $folderName]);
        } catch (AwsException $e) {
            // Display an error message if an exception occurs
            echo "Error creating folder: " . $e->getMessage();
        }
    }

    public function uploadFiles(Request $request){    //To be removed
        $bucketName = config('filesystems.disks.s3.bucket');
        $folderName = $request->folder;
        $uploadedFiles = $request->file('files');
        
        foreach ($uploadedFiles as $file) {
            // Check the file size and use multi-part upload if it's greater than 100MB
            if ($file->getSize() > 100 * 1024 * 1024) {
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region' => config('aws.region'),
                    'credentials' => [
                        'key' => 'AKIAVC7LJSPJ6TRFBRBJ',
                        'secret' => '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',
                    ],
                ]);

                $s3->upload(
                    $bucketName,
                    $folderName.'/' . $file->getClientOriginalName(),
                    fopen($file->getRealPath(), 'rb'),
                    'multipart'
                );
            } else {
                // Use regular upload for smaller files
                Storage::disk('s3')->putFileAs(
                    'your_folder_name',
                    $file,
                    $file->getClientOriginalName()
                );
            }
        }
        
        return response()->json(['message' => "Success"]);
    }

    public function getPresignedURL(Request $request){   

        $isThumbnail = filter_var($request->input('thumbnail'), FILTER_VALIDATE_BOOLEAN);
        $bucket = $isThumbnail ? config('filesystems.disks.s3.thumbnail_bucket') : config('filesystems.disks.s3.bucket');
        $key = $request->input('inBucketURL');
        $expiration = '+1 hour'; // URL expiration time (e.g., +1 hour, +5 minutes, etc.)

        $s3Client = Storage::disk('s3')->getClient();

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $key,
        ]);

        // $middleware = new PresignedUrlMiddleware($s3Client, $command);

        $presignedUrl = $s3Client->createPresignedRequest($command, $expiration)->getUri()->__toString();

        Log::Info($presignedUrl);

        return $presignedUrl;
    }

    public function deleteFromS3($bucketName, $s3Path)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => config('aws.region'),
            'credentials' => [
                'key' => 'AKIAVC7LJSPJ6TRFBRBJ',
                'secret' => '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',
            ],
        ]);

        try {
            $s3->deleteObject([
                'Bucket' => $bucketName,
                'Key' => $s3Path,
            ]);
            // Construct the path to the thumbnail image
            $filePureName = explode('.',basename($s3Path))[0];
            $thumbnailPath = dirname($s3Path) . '/thumbnail/' . $filePureName .'.jpg';

            Log::info($thumbnailPath);


            // Delete the associated thumbnail image if it exists
            if ($s3->doesObjectExist($bucketName, $thumbnailPath)) {
                $s3->deleteObject([
                    'Bucket' => $bucketName,
                    'Key' => $thumbnailPath,
                ]);
            }
            return true; // Return true if the deletion is successful
        } catch (AwsException $e) {
            // Handle the exception if the deletion fails
            return false;
        }
    }
}
