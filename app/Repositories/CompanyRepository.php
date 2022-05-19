<?php

namespace App\Repositories;

use App\Models\Company;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface {
    public function get(int $company_id): Company {
        return Company::findOrFail( $company_id );
    }

    public function gets(array $company_ids): Collection {
        return Company::findMany( $company_ids );
    }

    public function all(): Collection {
        return Company::all();
    }

    public function create(array $Company_data): Company {
        $company = new Company( $Company_data );
        $company->saveOrFail();
        return $company;
    }

    public function update( int $company_id, array $company_data): Company {
        $company = $this->get( $company_id );
        $company->fill( $company_data );
        $company->saveOrFail();
        return $company;
    }

    public function delete(int $company_id): bool {
        return Company::destroy( $company_id ) === 1;
    }

    public function activity(): array
    {
        $companies = Company::select(['activity', DB::raw('GROUP_CONCAT(`companyName` SEPARATOR "|") AS companyNames')])
            ->groupBy('activity')
            ->get();
        $return = [[]];
        foreach($companies as $ckey => $company) {
            $return[0][$ckey] = $company['activity'];
            $comps = $company['companyNames'];
            foreach($comps as $key => $c) {
                $return[$key + 1][(int)$ckey] = $c;
            }
        }
        return $return;
    }

    public function foundation(\DateTime $from): Collection
    {
        return Company::select(['companyFoundationDate','companyName'])
            ->where('companyFoundationDate','>=',$from)
            ->orderBy('companyFoundationDate')
            ->get();
    }
}
