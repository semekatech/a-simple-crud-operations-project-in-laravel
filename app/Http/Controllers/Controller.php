<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function CheckPermission($role)
    {
      $uid=User::where('id',auth()->user()->id)->first();
        $users =DB::table('permissions')
        ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
        ->select('permissions.*', 'role_permissions.permission_id', 'role_permissions.role_id')
        ->where('permissions.name',$role)
        ->where('role_permissions.role_id',$uid->role_id)
        ->first();
      return $users;
    }
    public function paginatedIndex(Request $request, $query)
    {
        $pagination = json_decode($request->pagination);
        $pagination->per_page = $pagination->rowsPerPage;
        $pagination->current_page = $pagination->page;

        $request->merge(
            [
                "page" => $pagination->page,
                "pagination" => [
                    'per_page' => $pagination->per_page,
                    'current_page' => $pagination->current_page,
                    'sortBy' => $pagination->sortBy,
                    'descending' => $pagination->descending,
                    'page' => $pagination->page,
                    'rowsPerPage' => $pagination->rowsPerPage,
                    'rowsNumber' => $pagination->rowsNumber,
                    'from' => $pagination->from,
                    'to' => $pagination->to
                ]
            ]
        );

        if ($request->filled("pagination.sortBy")) {
            $dir = $request->boolean("pagination.descending", false) ? "desc" : "asc";
            $sortBy = $request->input("pagination.sortBy");
            $query->orderBy($sortBy, $dir);
        }
        if ($request->filled("filter")) {
            $terms = $request->input("filter");
            $this->applySearchFilters($query, $terms);
        }
        $records = $query->paginate($request->input("pagination.rowsPerPage"));
        return $this->toPaginatedResponse($records);
    }

    protected function applySearchFilters(&$query, $terms)
    {

    }

    protected function toPaginatedResponse($records)
    {
        return $records;
    }


}
