<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionQueryRequest;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends ApiController
{
    //
    public function getAll(DivisionQueryRequest $divisionQueryRequest)
    {
        $perPage = $divisionQueryRequest->input('per_page', 10);
        $page = $divisionQueryRequest->input('page', 1);
        $divisions = Division::where('name', 'like', '%' . $divisionQueryRequest->name . '%')
            ->paginate($perPage, ['*'], 'page', $page);
        return $this->success(['divisions' => $divisions->items()] , "Success fetch divisions" , 200 , $divisions);
    }
}
