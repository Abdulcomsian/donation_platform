<?php

namespace App\Http\Handlers;
use App\Models\{Mailing};

class MailingHandler{

    public function updateUserMail($request){
        $htmlContent = $request->description;
        $userId = auth()->user()->id;
        $mailType = $request->type;

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHtml($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);

        //getting all the images in the conten
        $images = $dom->getElementsByTagName('img');

        //loop over the images
        foreach($images as $item => $image){
            $data = $image->getAttribute("src");
            $styles = $image->getAttribute("style");

            if(strpos($data , "base64"))
            {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                //convert base image to image
                $imgData = base64_decode($data);
                $image_name= time().$item.'.png';
                $path = public_path().'/assets/uploads/email/' . $image_name;
                file_put_contents($path, $imgData);
                $image->removeAttribute('src');
                $image->setAttribute('src', '/assets/uploads/email/'.$image_name);
                $image->setAttribute('max-width' , '100% !important;');
                $image->setAttribute('width' , $styles);
                $image->setAttribute('height' , 'auto');
                $image->removeAttribute("style");
            }
        }
        $content = $dom->saveHTML();

        Mailing::updateOrCreate(
            ['user_id' => $userId , 'type' => $mailType],
            ['user_id' => $userId , 'type' => $mailType , 'html_content' => $content]
        );


        return ['status' => true , 'msg' => 'Mail Added Successfully'];



    }
}