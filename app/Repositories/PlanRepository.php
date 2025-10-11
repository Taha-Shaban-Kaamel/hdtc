<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function all($paginate = 10)
    {
        return Plan::latest()->paginate($paginate);
    }

    public function find($id)
    {
        return Plan::findOrFail($id);
    }

    public function create(array $data)
    {
        return Plan::create($data);
    }

    public function update($id, array $data)
    {
        $plan = $this->find($id);
        $plan->update($data);
        return $plan;
    }

    public function delete($id)
    {
        $plan = $this->find($id);
        return $plan->delete();
    }
}
