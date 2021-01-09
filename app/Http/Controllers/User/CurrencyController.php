<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Currency\Threshold as ThresholdRequest;
use App\Http\Requests\Currency\UpdateThreshold as UpdateThresholdRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Exception;
use App\User;
use DB;

class CurrencyController extends Controller
{
    protected $currencyservice;

    public function __construct(CurrencyService $currencyservice)
    {
        $this->currencyservice = $currencyservice;
    }

    public function createThreshold(ThresholdRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->currencyservice->create($request)->toArray();
            DB::commit();
            return $this->success('Currency Threshold created Successful', $data, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respond($e);
        }
    }

    public function updateThreshold($id, UpdateThresholdRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $this->currencyservice->update($id, $request)->toArray();
            DB::commit();
            return $this->success('Currency Threshold Updated Successfully', $data, Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respond($e);
        }
    }

    public function get()
    {
        $data = $this->currencyservice->get()->toArray();
        return $this->success('Currency Threshold Updated Successfully', $data, Response::HTTP_OK);
    }
}
