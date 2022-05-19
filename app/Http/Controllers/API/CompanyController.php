<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Repositories\CompanyRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;

class CompanyController extends Controller
{
    private static array $valid = [
        'companyName' => 'required|max:255',
        'companyRegistrationNumber' => 'required|max:255',
        'companyFoundationDate' => 'required',
        'country' => 'required|max:255',
        'zipCode' => 'required',
        'city' => 'required|max:255',
        'streetAddress' => 'required|max:600',
        'latitude' => 'required',
        'longitude' => 'required',
        'companyOwner' => 'required|max:255',
        'employees' => 'required',
        'activity' => 'required|max:600',
        'active' => 'required',
        'email' => 'required',
        'password' => 'max:255',
    ];

    public function __construct(private CompanyRepositoryInterface $companyRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->companyRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = self::$valid;
        $valid['password'] = 'required|max:255';
        $request->validate($valid);

        return response()->json($this->companyRepository->create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->companyRepository->get($id));
    }

    /**
     * Display more specified resources.
     *
     * @param  string  $ids
     * @return \Illuminate\Http\Response
     */
    public function shows($ids)
    {
        return response()->json($this->companyRepository->gets(explode(',',$ids)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, self::$valid);
        return response()->json($this->companyRepository->update($id,$request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->companyRepository->delete($id)) {
            return response()->json([
                'message' => 'A cég sikeresen törölve!'
            ]);
        }
        return response()->json([
            'message' => 'Sikertelen törlés!'
           ]);
    }

    public function activity()
    {
        return response()->json($this->companyRepository->activity());
    }

    public function foundation()
    {
        $from = new \DateTime();
        $from->setDate(2001, 1, 1);
        $from->setTime(0,0,0,0);
        $foundations = $this->companyRepository->foundation($from)->toArray();
        $now = new \DateTime();
        $oneDay = new \DateInterval('P1D');
        $output = [];
        while($from <= $now)
        {
            $dateString = $from->format('Y.m.d');
            $add = [];
            foreach($foundations as $k => $val) {
                if ( $dateString == $val['companyFoundationDate'] ) {
                    $add[] = $val['companyName'];
                    unset($foundations[$k]);
                } else {
                    break;
                }
            }
            $output[$dateString] = count($add)>0 ? implode(', ', $add) : null;
            $from->add($oneDay);
        }
        return response()->json($output);
    }
}
