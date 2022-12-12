<?php
/*
 * Yazar : Azmi Nural
 * Tarih : 12 Aralık 2022
 * Açıklama : Controller cevapları için bu sayfa kullanılır. Return fonksiyonları tekrarlanmaması için
 * burada tanımlanmıştır.
 */

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{

    public array $logs = [];
    public bool $debug = false;
    public int $status_code = 200;
    public array $response = [
        'status' => false,
        'messages' => [],
        'failed_parameters' => [],
        'logs' => [],
        'datas' => [],
    ];

    /**
     * Json tipinde api raporu sunar
     */
    public function apiResponse(): JsonResponse
    {
        if ($this->debug) $this->response['logs'] = $this->logs;
        if ($this->status_code >= 200 && $this->status_code <= 210) $this->response['status'] = true;
        return response()->json($this->response, $this->status_code);
    }

    public function addLog($log): void
    {
        $this->logs[] = $log;
    }

    public function addMessage($message): void
    {
        $this->response['messages'][] = $message;
    }

    public function setFailedParameters($parameters): void
    {
        $this->response['failed_parameters'] = $parameters;
    }

    public function setData($data): void
    {
        $this->response['datas'][] = $data;
    }

    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    public function setStatusCode(int $code): void
    {
        $this->status_code = $code;
    }

}
