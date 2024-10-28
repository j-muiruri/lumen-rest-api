<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $rules = [
            'status' => 'nullable|string|in:pending,completed',
            'due_date' => 'nullable|date_format:Y-m-d',
            'search' => 'nullable|string'
        ];

        $input = Validator::make(request()->all(), $rules);


        if ($input->fails()) {
            $data = [
                'success' => false,
                'data' => $input->errors()->first()
            ];

            return response()->json($data, 422);
        }

        $data = new Task();
        $query = request()->only(['status', 'due_date', 'search']);

        foreach ($query as $field => $value) {
            if ($field == 'search') {
                $data = $data->where('title', 'like', "%$value%");
            } else {
                $data = $data->where($field, $value);
            }
        }

        $data = $data->paginate(10);

        $data = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($data, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|unique:tasks,title',
            'description' => 'required|string',
            'due_date' => 'required|date_format:Y-m-d||after:today'
        ];

        $input = Validator::make($request->all(), $rules);


        if ($input->fails()) {
            $data = [
                'success' => false,
                'data' => $input->errors()->first()
            ];

            return response()->json($data, 422);
        }

        $task = Task::create($input->validated());

        $data = [
            'success' => true,
            'data' => $task,
            'message' => 'Task created successfully'
        ];


        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $task = Task::find($id);
        if ($task) {

            $data = [
                'success' => true,
                'data' => $task
            ];
            $status = 200;
        } else {

            $data = [
                'success' => false,
                'message' => 'Task not found',
                'data' => $task
            ];
            $status = 404;
        }

        return response()->json($data, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'title' => [
                'required',
                'string',
                Rule::unique('tasks', 'title')->ignore($id, 'id'),
            ],
            'description' => 'required|string',
            'status' => 'required|string|in:pending,completed',
            'due_date' => 'required|date_format:Y-m-d||after:today'
        ];

        $messages = [
            'status.in' => 'The selected status should be either pending or completed'
        ];

        $input = Validator::make($request->all(), $rules, $messages);

        if ($input->fails()) {
            $data = [
                'success' => false,
                'data' => $input->errors()->first()
            ];

            return response()->json($data, 422);
        }


        $task = Task::find($id);

        $task->update($input->validated());

        $data = [
            'success' => true,
            'data' => $task,
            'message' => 'Task updated successfully'
        ];


        return response()->json($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();

            $data = [
                'success' => true,
                'message' => 'Task deleted successfully'
            ];
            $status = 200;
        } else {
            $data = [
                'success' => false,
                'message' => 'Task not found',
            ];
            $status = 404;
        }

        return response()->json($data, $status);
    }
}
