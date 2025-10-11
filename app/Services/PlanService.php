<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use Exception;

class PlanService
{
    protected $repo;

    public function __construct(PlanRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllPlans()
    {
        return $this->repo->all();
    }

    public function getPlanById($id)
    {
        return $this->repo->find($id);
    }

    public function createPlan(array $data)
    {
        return $this->repo->create($data);
    }

    public function updatePlan($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deletePlan($id)
    {
        return $this->repo->delete($id);
    }
}
