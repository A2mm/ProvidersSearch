<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JsonProviderService;
use App\Models\UsersProvider;
use App\Models\TransactionsProvider;
use DB;
class ApiUserJsonController extends Controller
{
    public function __construct()
    {
        $this->storageFolder = 'dataproviders';
    }

    public function fech_users(Request $request, JsonProviderService $JsonProviderService)
    {
        $requestData = $request->all();
        $data        = $JsonProviderService->getAllParents($requestData);
        $total       = count($data);
        $message     = 'success';
        return response()->json([
        	'total'   => $total,
        	'message' => $message,
        	'data'    => $data,
        ]);
    }

}
