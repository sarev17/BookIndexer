<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Index;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::with('indices');
        if(isset($_GET['titulo'])){
            $books = $books->where('title','like','%'.$_GET['titulo'].'%');
        }

        return response()->json(['books' => $books->get()], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'titulo' => 'required|string',
        //     'indices' => 'required|array',
        //     'indices.*.titulo' => 'required|string',
        //     'indices.*.pagina' => 'required|integer',
        //     'indices.*.subindices' => 'nullable|array',
        //     'indices.*.subindices.*.titulo' => 'required|string',
        //     'indices.*.subindices.*.pagina' => 'required|integer',
        // ], [
        //     'titulo.required' => 'O campo título é obrigatório.',
        //     'indices.required' => 'O campo índices é obrigatório.',
        //     'indices.*.titulo.required' => 'O título do índice é obrigatório.',
        //     'indices.*.pagina.required' => 'A página do índice é obrigatória.',
        //     'indices.*.pagina.integer' => 'A página do índice deve ser um número inteiro.',
        //     'indices.*.subindices.*.titulo.required' => 'O título do subíndice é obrigatório.',
        //     'indices.*.subindices.*.pagina.required' => 'A página do subíndice é obrigatória.',
        //     'indices.*.subindices.*.pagina.integer' => 'A página do subíndice deve ser um número inteiro.',
        // ]);

        // return $request->titulo;
        $book = Book::create([
            'user_id' => User::where('api_token', $request->bearerToken())->first()->id,
            'title' => $request->titulo,
        ]);
        // Cadastrar os índices e subíndices
        foreach ($request->indices as $indiceData) {

            try{$indice = Index::create([
                'title' => $indiceData['titulo'],
                'page' => $indiceData['pagina'],
                'book_id' => $book->id
            ]);}catch(Exception $e){
                continue;
            }
            if (isset($indiceData['subindices'])) {
                foreach ($indiceData['subindices'] as $subindiceData) {
                    try {
                        Index::create([
                            'title' => $subindiceData['titulo'],
                            'page' => $subindiceData['pagina'],
                            'parent_index_id' => $indice->id,
                            'book_id' => $book->id
                        ]);
                    } catch (Exception $e) {
                        continue;
                    }
                }
            }
        }
        return response()->json(['message' => 'Livro cadastrado com sucesso'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
