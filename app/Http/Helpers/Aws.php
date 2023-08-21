<?php

namespace App\Http\Helpers;

use Aws\S3\S3Client;

class Aws{
  function connect() {
    //   $SPACES_KEY  = S3::where('key_name','SPACES_KEY')->first()->key_value;
    //   $SPACES_SECRET = S3::where('key_name','SPACES_SECRET')->first()->key_value;
      try
      {
  
       return new S3Client([
          'version' => 'latest',
          'region'  => 'nyc3',
          'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
          'credentials' => [
              'key'    => 'LXN3CWYQSMF7BNLWMOL4',
              'secret' => 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4',
          ],
      ]);
   } catch(\Exception $e) {
      echo $e->getMessage();
  }
  }
}