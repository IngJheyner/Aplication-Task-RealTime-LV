<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Enums\TaskPinnedStatus;
use App\Http\Requests\Projects\PinnedRequest;
use App\Http\Requests\Projects\StoreRequest;
use App\Models\Project;
use App\Models\TaskProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {

        $query = $request->query('query');

        $projects = Project::with('task_progress');

        if(!is_null($query) && $query != '') {

            $projects->where('name', 'LIKE', "%$query%")
                ->orderBy('id', 'DESC');
        }

        return response()->json(['data' => $projects->paginate(10)], 200);
    }

    /**
     * Mostrar un proyecto específico.
     *
     * @param Request $request
     * @param string $slug
     * @return JsonResponse
     */
    public function show(Request $request, $slug): JsonResponse {
        $project = Project::where('slug', $slug)
            ->with(['tasks.taskMembers.member'])
            ->firstOrFail(); // Buscar el proyecto por su slug y lanzar una excepción si no se encuentra

        return response()->json(['data' => $project], 200);
    }

    /**
     * Crear un nuevo proyecto.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse {

        return DB::transaction(function () use ($request) {

            $fields = $request->validated();

            $project = Project::create([
                'name' => $fields['name'],
                'start_date' => $fields['start_date'],
                'end_date' => $fields['end_date'],
                'status' => ProjectStatus::NOT_STARTED,
                'slug' => Project::createSlug($fields['name']),
            ]);

            TaskProgress::create([
                'project_id' => $project->id,
                'pinned_on_dashboard' => TaskPinnedStatus::NOT_PINNED_ON_DASHBOARD,
                'progress' => 0,
            ]);

            return response()->json([
                'project' => $project,
                'message' => 'Proyecto creado exitosamente',
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

        $project = Project::where('id', $fields['id'])->update([
            'name' => $fields['name'],
            'start_date' => $fields['start_date'],
            'end_date' => $fields['end_date'],
            'slug' => Project::createSlug($fields['name']),
        ]);

        return response()->json([
            'message' => 'Proyecto actualizado exitosamente',
        ], 200);
    }

    /**
     * Actualizar el estado de un proyecto.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function pinnedProject(PinnedRequest $request): JsonResponse {

        return DB::transaction(function () use ($request) {
            $fields = $request->validated();

            TaskProgress::where('pinned_on_dashboard', TaskPinnedStatus::PINNED_ON_DASHBOARD)->update([
                'pinned_on_dashboard' => TaskPinnedStatus::NOT_PINNED_ON_DASHBOARD,
            ]);

            TaskProgress::where('project_id', $fields['project_id'])->update([
                'pinned_on_dashboard' => TaskPinnedStatus::PINNED_ON_DASHBOARD,
            ]);

            return response()->json([
                'message' => 'Proyecto fijado en el panel exitosamente',
            ]);
        });
    }

    public function countProjects(): JsonResponse {

        $projects = Project::count();
        return response()->json([
                'count' => $projects,
        ]);

    }

    /**
     * Obtener el proyecto fijado en el panel.
     *
     * @return JsonResponse
     */
    public function getPinnedProject(): JsonResponse {

        $project = DB::table('task_progress')
            ->join('projects', 'task_progress.project_id', '=', 'projects.id')
            ->select('projects.id', 'projects.name')
            ->where('task_progress.pinned_on_dashboard', TaskPinnedStatus::PINNED_ON_DASHBOARD)
            ->first();
        return !is_null($project) ? response()->json(['data' => $project]) : response()->json(['data' => null]);
    }
}
