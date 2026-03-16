<?php

namespace App\Services;
use App\Models\Client;

class ClientService
{
    public function create(array $data)
    {
        return Client::create($data);
    }

    public function list()
    {
        return Client::paginate();
    }

    public function find(int $id)
    {
        return Client::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $client = $this->find($id);
        $client->update($data);
        return $client;
    }

    public function delete(int $id)
    {
        $client = $this->find($id);
        $client->delete();
    }

}
    
