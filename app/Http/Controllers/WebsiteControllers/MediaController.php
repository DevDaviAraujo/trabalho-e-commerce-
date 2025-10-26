<?php

namespace App\Http\Controllers\WebsiteControllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Content;
use App\Models\Card;
use App\Models\Category;
use App\Models\Link;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use getID3;
use Illuminate\Support\Str;

class MediaController extends Controller
{

    public function save_file(object $file, string $morph_id, string $morph_type, string $pathDir, bool $updating = false)
    {

        $file_path = $file->getRealPath();
        $file_name = Str::random(2) . time() . '.' . $file->getClientOriginalExtension();
        $file_type = mime_content_type($file_path);
        $store_path = $pathDir . '/' . $file_name;
        $file_width = getimagesize($file_path)[0];
        $file_height = getimagesize($file_path)[1];


        Storage::disk('public')->put($store_path, file_get_contents($file_path));

        $modelMap = $morph_type;

        DB::beginTransaction();

        try {

            if (Storage::disk('public')->exists($store_path)) {

                if ($updating) {

                    $modelClass = $modelMap[$morph_type];

                    $content = $modelClass::where('id', $morph_id)->first();

                    $oldFile = $content->image->deleteDir();

                    $image = $content->image->update([
                        'file' => $file_name,
                        'file_type' => $file_type,
                        'width' => $file_width,
                        'height' => $file_height,
                    ]);

                } else {

                    $image = Media::create([
                        'file' => $file_name,
                        'file_type' => $file_type,
                        'width' => $file_width,
                        'height' => $file_height,
                        'origin_type' => $morph_type,
                        'origin_id' => $morph_id,
                    ]);
                }
            }

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Upload de imagem com Sucesso!'
            ];
        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Algo deu errado, tente novamente.',
                'error' => $e
            ];
        }
    }

    public function delete(string $mediaId)
    {

        DB::beginTransaction();

        try {

            $media = Media::find($mediaId);

            $media->deleteDir();
            $media->delete();

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Conteúdo deletado com sucesso!',

            ];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Algo deu errado, tente novamente.'
            ];
        }
    }
}
