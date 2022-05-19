<?php

namespace App\Repositories;

use App\Models\Company;
use \Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface {
    public function get(int $company_id): Company;
    public function gets(array $company_ids): Collection;
    public function all(): Collection;
    public function create(array $company_data): Company;
    public function update( int $company_id, array $todo_data): Company;
    public function delete(int $company_id): bool;
    public function activity(): array;
    public function foundation(\DateTime $from): Collection;
}
