<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Tasks\TaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Crear una nueva tarea
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function createTask(TaskRequest $request): JsonResponse {

        return DB::transaction(function () use ($request) {

            $fields = $request->validated();

            $task = Task::create([
                'name' => $fields['name'],
                'project_id' => $fields['project_id'],
                'status' => TaskStatus::NOT_STARTED,
            ]);

            for ($i=0; $i <count($fields['member_ids']) ; $i++) {
                // Agregar id proyecto a task_member
                $task->taskMembers()->create([
                        'member_id' => $fields['member_ids'][$i],
                        'project_id' => $fields['project_id'],
                        'task_id' => $task->id
                ]);
            }

            return response()->json([
                'message' => 'La tarea se ha creado con éxito.',
            ], 200);

        });
    }

    /**
     * Actualizar estado de tarea de no iniciada a pendiente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToNotStartedToPending(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::PENDING);
        return response()->json([
                'message' => 'La tarea se ha movido a pendiente.',
        ]);
    }

    /**
     * Actualizar estado de tarea de no iniciada a completada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToNotStartedToCompleted(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::COMPLETED);
        return response()->json([
                'message' => 'La tarea se ha movido a completada.',
        ]);
    }

    /**
     * Actualizar estado de tarea de no iniciada a completada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToPendingToCompleted(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::COMPLETED);
        return response()->json([
                'message' => 'La tarea se ha movido a completada.',
        ]);
    }

    /**
     * Actualizar estado de tarea de pendiente a no iniciada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToPendingToNotStarted(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::NOT_STARTED);
        return response()->json([
                'message' => 'La tarea se ha movido a no iniciada.',
        ]);
    }

    /**
     * Actualizar estado de tarea de completada a pendiente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToCompletedToPending(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::PENDING);
        return response()->json([
                'message' => 'La tarea se ha movido a pendiente.',
        ]);
    }

    /**
     * Actualizar estado de tarea de completada a no iniciada
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function taskToCompletedToNotStarted(Request $request): JsonResponse {

        Task::changeTaskStatus($request->task_id, TaskStatus::NOT_STARTED);
        return response()->json([
                'message' => 'La tarea se ha movido a no iniciada.',
        ]);
    }
}
