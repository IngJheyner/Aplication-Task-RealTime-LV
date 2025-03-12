<?php

namespace App\Http\Controllers;

use App\Http\Requests\Members\StoreRequest;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {

        $query = $request->query('query');

        $members = DB::table('members');

        if(!is_null($query) && $query != '') {

            $members->where('name', 'LIKE', "%$query%")
                ->orderBy('id', 'DESC');
        }

        return response()->json(['data' => $members->paginate(10)], 200);
    }

    /**
     * Crear un nuevo miembro del proyecto.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse {

        return DB::transaction(function () use ($request) {

            $fields = $request->validated();

            $member = Member::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
            ]);

            return response()->json([
                'member' => $member,
                'message' => 'Miembro del proyecto creado exitosamente',
            ], 200);

        });
    }

    /**
     * Actualizar un proyecto existente.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function update(StoreRequest $request): JsonResponse {

        $fields = $request->validated();

        Member::where('id', $fields['id'])->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
        ]);

        return response()->json([
            'message' => 'Miembro del proyecto actualizado exitosamente',
        ], 200);
    }
}
