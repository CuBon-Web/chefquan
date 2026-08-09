<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Librarys;
use App\models\MessContact;
use App\Services\CloudflareImageService;

class AllController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('img')) {
            return response()->json(['data' => 'fail'], 500);
        }

        $image = $request->file('img');
        $response = $this->cloudflareService->uploadImage($image);

        if (empty($response['success']) || empty($response['result']['variants'][0])) {
            return response()->json([
                'data' => 'fail',
                'errors' => $response['errors'] ?? null,
            ], 500);
        }

        return response()->json([
            'messenge' => 'success',
            'path' => $response['result']['variants'][0],
        ], 200);
    }
    public function uploadImageMulti(Request $request)
    {
        $uploadId = [];
        if($files = $request->file('file')){
            foreach($request->file('file') as $key => $file){
                $name = rand().$file->getClientOriginalName();
                $fielname = $file->move('uploads/imagesMuli/', $name);
                $uploadId[] = '/uploads/images/'.$name;
            }
        }
        return response()->json([
            'messenge' => 'success',
            'path' => $uploadId
        ],200);
    }
    public function fileStore(Request $request)
    {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);
         
        $insert['title'] = $generated_new_name;
        return response()->json([
            'messenge' => 'success',
            'path' => $insert
        ],200);
    }
    public function listMesscontact(Request $request)
    {
        $keyword = trim((string) $request->keyword);
        $type = trim((string) $request->type);
        $query = MessContact::query()->orderBy('id', 'DESC');

        if ($type !== '' && in_array($type, ['booking', 'contact'], true)) {
            $query->where('type', $type);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('mess', 'LIKE', '%' . $keyword . '%');
            });
        }

        return response()->json([
            'data' => $query->get(),
            'message' => 'success'
        ]);
    }

    public function updateMesscontactStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status' => 'required|in:new,confirmed,cancelled,done',
        ]);

        $item = MessContact::find($request->id);
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy yêu cầu'], 404);
        }

        $item->status = $request->status;
        $item->save();

        return response()->json([
            'data' => $item,
            'message' => 'success'
        ]);
    }
}
