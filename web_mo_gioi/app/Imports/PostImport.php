<?php

namespace App\Imports;

use App\Enums\PostStatusEnum;
use App\Models\Company;
use App\Models\Post;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PostImport implements ToArray,WithHeadingRow
{

    public function array(array $array): void
    {
        foreach ($array as $each){
            try {
                $companyName = $each['cong_ty'];
                $language = $each['ngon_ngu'];
                $city = $each['dia_diem'];
                $link = $each['link'];
                if(!empty($companyName)){
                    $companyID = Company::firstOrCreate([
                        'name'=>$companyName,
                    ],[
                        'city' => $city,
                        'country' => 'VietNam',
                    ])->id;
                }else{
                    $companyID = null;
                }


                $post = Post::create([
                    'job_title' =>$language,
                    'company_id' => $companyID,
                    'city' =>$city,
                    'status'=>PostStatusEnum::ADMIN_APPROVED,
                ]);
                $languages = explode(',',$language);
                foreach ($languages as $language){
                    \App\Models\Language::firstOrCreate([
                        'name'=>trim($language),
                    ]);
                }
                \App\Models\File::create([
                    'post_id' => $post->id,
                    'link' => $link,
                    'type' => \App\Enums\FileTypeEnum::JD,
                ]);
            } catch (\Exception $exception){
                dd($each);
            }

        }

    }
}
