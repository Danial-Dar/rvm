<?php

namespace App\Observers;

use App\Models\PostCard;

use Illuminate\Support\Facades\Log;


/*postcard */

use Treinetic\ImageArtist\lib\PolygonShape;
use Treinetic\ImageArtist\lib\Text\TextBox;
use Treinetic\ImageArtist\lib\Text\Color;
use Treinetic\ImageArtist\lib\Text\Font;
use Treinetic\ImageArtist\lib\Overlays\Overlay;
use Treinetic\ImageArtist\lib\Image;
use Imagick;
use App\Models\Address;


class PostCardObserver
{
    /**
     * Handle the PostCard "created" event.
     *
     * @param  \App\Models\PostCard  $postCard
     * @return void
     */
    public function created(PostCard $postCard)
    {
        //
        Log::info('Log message', array('context' => 'Other helpful information','data'=>$postCard));

        //Log::useDailyFiles(storage_path().'/logs/name-of-log.log');
         //   Log::info([$postCard]);
        echo $path = storage_path().'/app/public/';


            $img2 = new Image($path.$postCard->front);
            $img1 = new Image($path.$postCard->back);
            $img2->merge($img1,0,401);
            $img2->save($path."./merged.png",IMAGETYPE_PNG);

            $img3 = new Image($path."./merged.png");



            $get_address_detail = Address::find($postCard->to);

            echo "<pre>";print_r($get_address_detail);



            $textBox = new TextBox(400,280);
            $textBox->setColor(new Color(0,0,0 ));
            $textBox->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
            $textBox->setSize(10);
            $textBox->setMargin(95);
            $textBox->setText($get_address_detail->first_name  ." ". $get_address_detail->last_name);

            $textBox1 = new TextBox(410,280);
            $textBox1->setColor(new Color(0,0,0 ));
            $textBox1->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
            $textBox1->setSize(10);
            $textBox1->setMargin(90);
            $textBox1->setText($get_address_detail->company_name);

            $textBox2 = new TextBox(510,300);
            $textBox2->setColor(new Color(0,0,0 ));
            $textBox2->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
            $textBox2->setSize(10);
            $textBox2->setMargin(85);
            $textBox2->setText($get_address_detail->address);


            $textBox3 = new TextBox(610,300);
            $textBox3->setColor(new Color(0,0,0 ));
            $textBox3->setFont(Font::getFont(Font::$NOTOSERIF_REGULAR));
            $textBox3->setSize(10);
            $textBox3->setMargin(80);
            $textBox3->setText($get_address_detail->city.' , '.$get_address_detail->state.' '.$get_address_detail->zip);
            $img3->setTextBox($textBox,($img3->getWidth()-$textBox->getWidth()),$img3->getHeight()* (5/7));
            $img3->setTextBox($textBox1,($img3->getWidth()-$textBox->getWidth()),$img3->getHeight()* (5/7));
            $img3->setTextBox($textBox2,($img3->getWidth()-$textBox->getWidth()),$img3->getHeight()* (5/7));
            $img3->setTextBox($textBox3,($img3->getWidth()-$textBox->getWidth())/1.5,$img3->getHeight()* (5/7));
            $fnameo = time().'_merged.png';
            $img3->save($path.'/'.$fnameo,IMAGETYPE_PNG);

            $img3->dump();


            /*$pdf = new Imagick($path."./mergedcc.png");
                $pdf->setImageFormat('pdf');
                $pdf->writeImages($path.'/combined.pdf', true);*/



                /*$tempf = public_path('images/convert/'.$name1.'-%0d'.'_split.pdf');
             //echo 'convert '.$names.' '.$tempf;
             //echo "<br>";
             
             $name =  public_path('images/convert/'.$imageName);


             
            echo  'convert '.$name.' split '.$tempf;*/

            $fname = time().'_combined.pdf';

             $outp = storage_path('/app/public/'.$fnameo);
            $inpu = storage_path('/app/public/'. $fname);

            echo $outp;

            //magick convert .\mergedcc.png .\combinedtt.pdf
              shell_exec('magick convert   '.$outp.' ' .$inpu);

              $postCardpdf = PostCard::find($postCard->id);

              $postCardpdf->pdf = $fname;

              $postCardpdf->save();
               // shell_exec(convert D:\xampp\htdocs\email_rvm3\storage\app\public\mergedcc.png  D:\xampp\htdocs\email_rvm3\storage\app\public\combined.pdf);










        echo "<pre>";print_r($postCard);
        //exit;
    }

    /**
     * Handle the PostCard "updated" event.
     *
     * @param  \App\Models\PostCard  $postCard
     * @return void
     */
    public function updated(PostCard $postCard)
    {
        //
    }

    /**
     * Handle the PostCard "deleted" event.
     *
     * @param  \App\Models\PostCard  $postCard
     * @return void
     */
    public function deleted(PostCard $postCard)
    {
        //
    }

    /**
     * Handle the PostCard "restored" event.
     *
     * @param  \App\Models\PostCard  $postCard
     * @return void
     */
    public function restored(PostCard $postCard)
    {
        //
    }

    /**
     * Handle the PostCard "force deleted" event.
     *
     * @param  \App\Models\PostCard  $postCard
     * @return void
     */
    public function forceDeleted(PostCard $postCard)
    {
        //
    }
}
