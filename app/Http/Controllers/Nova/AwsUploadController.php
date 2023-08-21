<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use App\Http\Helpers\Aws;
use Illuminate\Support\Facades\Storage;
use Exception;
class AwsUploadController extends Controller
{
    public function upload(Request $request){

        // connect aws
        $client = connectAwsS3();

        // fetch files
        $files = $request->file('files');
        
        // store aws files url in a variable
        $awsStoreFilesURL = null;
        // $filesName = [];
        // $filesURL = [];

        // aws file url
        $awsFileURL= 'https://rvm.nyc3.digitaloceanspaces.com/RVM/';

        // check files count 
        if($files != null){

            // loop files and store in aws
            // foreach($files as $file){
                
                $filename = uniqid().'.'.$files->getClientOriginalExtension();
                $orignalName = $files->getClientOriginalName();
                // $filesName[$orignalName] = $filename;
                
                // $filesName['aws_filename'][] = $filename;
                // array_push($filesName,$orignalName);

                // store file in aws
                try {
                    $client->putObject([
                        'Bucket' => 'RVM',
                        'Key'    => $filename,
                        'Body'   => file_get_contents($files),
                        'ACL'    => 'public-read',
                        'headers' => [
                                'Content-Type' => $files->getMimeType(),
                                'Content-Disposition' => 'attachment'
                            ],
                        ],

                    );

                    // set url 
                    $URL = $awsFileURL.$filename;
                    $awsStoreFilesURL = $URL;

                    return response()->json([
                        'success'=>true,
                        'files_url' => $awsStoreFilesURL,
                        'message' => 'Files store in aws.'
                    ],200);
                } catch(\Exception $e) {
                    \Log::info($e->getMessage());
                    // throw new Exception($e->getMessage());

                    return response()->json([
                        'success'=>false,
                        'files_url' => null,
                        'message'=> $e->getMessage()
                    ],400);
                }

                
                // array_push($awsStoreFilesURL,$URL);
                // $aws = new  Aws();

                // $client1 = $aws->connect();

                // $cmd = $client1->getCommand('GetObject', [
                //     'Bucket' => 'RVM',
                //     'Key'    => $filename,
                //     'Content-Type'=> $file->getMimeType()
                // ]);

                // $expiry = '+5 minutes';

                // try {
                //     $request = $client1->createPresignedRequest($cmd, $expiry);
                //     $presignedUrl = (string) $request->getUri();

                //     array_push($awsStoreFiles,$presignedUrl);

                // } catch(\Exception $e) {
                //     \Log::info($e->getMessage());
                //     throw new Exception($e->getMessage());
                // }

            // }//foreach loop end

            

        }else{
            return response()->json([
                'success'=>false,
                'files_url' => $awsStoreFilesURL,
                'message' => 'Files not store.'
            ],400);
        }
    }

    public function remove(Request $request){
        // connect aws
        $client = connectAwsS3();
        
        $fileName = $request->filename;

        if($fileName != null || $fileName != ''){

            try{
                // remove file from s3 bucket
                $result = $client->deleteObject(array(
                    'Bucket' => 'RVM',
                    'Key'    => $fileName
                ));
                return response()->json([
                    'success'=>true,
                    'message' => 'File removed successfully.',
                ],200);

            }catch(\Exception $e){
                return response()->json([
                    'success'=>false,
                    'message' => $e->getMessage(),
                ],400);
            }
            
        }else{
            return response()->json([
                'success'=>false,
                'message' => 'File not removed.'
            ],400);
        }
    }
}
