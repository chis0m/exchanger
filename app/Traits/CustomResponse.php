<?php
namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait CustomResponse
{

  public function success(string $message, array $data = [], $status_code = 200)
  {
      $data['success'] = true;
      $data['message'] = $message;

      return response()->json($data, $status_code);
  }


  public function resources(array $resources = [])
  {
      return $this->success('Data Fetched Successfully', $resources);
  }


  public function resource_error($data = [])
  {
      return $this->error($data['message'], $data['code'], $data['errors'], $data['error']);
  }


  public function error(string $message, int $code = 500, array $errors = [], array $error_data = [])
  {
      $data = [
          'success' => false,
          'message' => $message,
      ];

      if (count($errors)) {
          $data['errors'] = $errors;
      }

      if (count($error_data)) {
          $data['data'] = $error_data;
      }

      return response()->json($data, $code);
  }


  public function exception(\Exception $exception)
  {
      return $this->error($exception->getMessage(), 500, [
          'message' => $exception->getMessage(),
          'file' => $exception->getFile(),
          'line' => $exception->getLine(),
          'trace' => $exception->getTrace(),
      ]);
  }
  

  public function form_errors(array $errors, $code = 422, $message = 'Incorrect form data')
  {
      return $this->error($message, $code, $errors);
  }

}