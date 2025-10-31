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

    public function save_file(object $file, string $morph_id, string $morph_type, string $pathDir)
    {
        $file_path = $file->getRealPath();
        $extension = strtolower($file->getClientOriginalExtension());
        $file_name = Str::random(2) . time() . '.' . $extension;
        $file_type = mime_content_type($file_path);
        $store_path = $pathDir . '/' . $file_name;

        $width = null;
        $height = null;

        $isImage = str_starts_with($file_type, 'image/');
        $isVideo = str_starts_with($file_type, 'video/');

        if ($isImage) {
            [$width, $height] = getimagesize($file_path);
        }

        if ($isVideo) {
            try {
                $ffprobe = \FFMpeg\FFProbe::create();
                $videoStream = $ffprobe->streams($file_path)->videos()->first();
                $width = $videoStream->get('width');
                $height = $videoStream->get('height');
            } catch (\Exception $e) {
                $width = null;
                $height = null;
            }
        }


        // Save file to storage
        Storage::disk('public')->put($store_path, file_get_contents($file_path));

        DB::beginTransaction();

        try {
            if (Storage::disk('public')->exists($store_path)) {
                Media::create([
                    'file' => $file_name,
                    'file_type' => $file_type,
                    'width' => $width,
                    'height' => $height,
                    'origin_type' => $morph_type,
                    'origin_id' => $morph_id,
                ]);
            }

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Upload de arquivo com sucesso!',
                'type' => $isVideo ? 'video' : 'image'
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'message' => 'Algo deu errado, tente novamente.',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function destroy($id)
{
    $media = Media::findOrFail($id);

    DB::beginTransaction();

    try {
        
        $media->deleteDir();

        $media->delete();

        DB::commit();

        return redirect()->back()->with('success', 'Arquivo removido com sucesso.');
    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with(
            'error',
            'Algo deu errado, tente novamente. ' . $e->getMessage()
        );
    }
}

}
