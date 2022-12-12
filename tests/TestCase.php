<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function ruleFailedControl($failed_parameters, $param, $rule): bool
    {
        $response = false;
        foreach ($failed_parameters as $key => $item)
            if ($key === $param && array_key_exists($rule, $item)) $response = true;
        return $response;
    }

    public function token()
    {
        $this->addUser();
        $data = [
            'username' => 'nuralazmi',
            'password' => '123456',
        ];
        $response = $this->post('/api/login', $data);
        $json = $response->json();
        return $json['datas'][0]['token'];
    }

    public function addUser()
    {
        User::create($this->userData());
    }

    public function userData(): array
    {
        return [
            'name' => 'Azmi Nural',
            'username' => 'nuralazmi',
            'password' => bcrypt('123456'),
        ];
    }
}
