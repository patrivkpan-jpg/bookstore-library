<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BookModel;

class BookController extends Controller
{
    /**
     * Get books based on search and order by criteria
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (!isset($data['search'])) {
            $data['search'] = '';
        }
        $books = BookModel::where('title', 'LIKE', "%{$data['search']}%")
            ->orWhere('author', 'LIKE', "%{$data['search']}%")
            ->orderBy($data['field'], $data['sort'])
            ->get();
        return $books;
    }

    /**
     * Store a new book in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [ 
            'title' => [
                'required',
                'max:255',
                Rule::unique('books')->where('author', $data['author'])
            ],
            'author' => [
                'required',
                'max:255'
            ],
            'cover_img' => [
                'required',
                'image'
            ]
        ]);
        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }

        try {
            // Create helper for uploading
            $img = $request->file('cover_img');
            $data['cover_img'] = $img->store('images', ['disk' => 'uploads']);
            $response = BookModel::create($data);
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('Something went wrong with the request.', 400);
        }
    }

    /**
     * Retrieve a specific book by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            return BookModel::where('id', $id)
                ->get();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('Something went wrong with the request.', 400);
        }
    }

    /**
     * Update a specific book by id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_method']);
        if ($data['cover_img'] === 'undefined') {
            unset($data['cover_img']);
        }
        $validator = Validator::make($data, [ 
            'title' => [
                'required',
                'max:255',
                Rule::unique('books')->where('author', $data['author'])
            ],
            'author' => [
                'required',
                'max:255'
            ],
            'cover_img' => [
                'sometimes',
                'image'
            ]
        ]);
        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }

        try {
            if ($request->file('cover_img') !== null) {
                $img = $request->file('cover_img');
                $data['cover_img'] = $img->store('images', ['disk' => 'uploads']);
            }
            $response = BookModel::where('id', $id)
                ->update($data);
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('Something went wrong with the request.', 400);
        }
    }

    /**
     * Delete a specific book by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = BookModel::destroy($id);
            return response()->json($response, 200);
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return response()->json('Something went wrong with the request.', 400);
        }
    }
}
