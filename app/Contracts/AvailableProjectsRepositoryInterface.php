<?php

namespace App\Contracts;

use App\DTO\ProjectDTO;

interface AvailableProjectsRepositoryInterface
{
    /**
     * @return ProjectDTO[]
     */
    public function availableProjects() : array;
}
