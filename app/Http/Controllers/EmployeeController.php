<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeQueryRequest;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends ApiController
{
    //

    public function store(EmployeeStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            //code...
            $validated = $request->validated();

            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;

            $data = $validated;
            $data['division_id'] = $validated['division'];
            unset($data['division']);
            $employee = Employee::create($data);
            DB::commit();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Employee successfully created.'
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
    }



    public function getAll(EmployeeQueryRequest $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $employees = Employee::where('name', 'like', '%' . $request->name . '%')->with('division')
            ->paginate($perPage, ['*'], 'page', $page);
        $employees->getCollection()->transform(function ($employee) {
            if ($employee->image) {
                $employee->image = url('/') . Storage::url($employee->image);
            }
            return $employee;
        });
        return $this->success(['employees' => $employees->items()], "Success fetch employees", 200, $employees);
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::where('id', $id)->first();
            if (!$employee) {
                return $this->error("Failed to delete, employee not found", 404);
            }
            $employee->delete();
            return response()->json(
                [
                    'message' => 'Success delete employee',
                    'status' => 'success'
                ]
            );
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(),  500);
        }
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::where('id' , $id)->first();

            if(!isset($employee)){
                return $this->error("Failed to update, employee not found", 404);
            }

            $validated = $request->validated();


            if ($request->hasFile('image')) {
                if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                    Storage::disk('public')->delete($employee->image);
                }
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }

            $validated['division_id'] = $validated['division'];
            unset($validated['division']);

            $employee->update($validated);

            DB::commit();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Employee successfully updated.'
                ],
                200
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error($th->getMessage(), 500);
        }
    }
}
