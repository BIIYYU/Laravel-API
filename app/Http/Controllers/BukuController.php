<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Buku::orderBy('judul','asc')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data ditemukan',
            'data'    => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {   
        $data_buku = new Buku;

        $rules = [
            'judul'=>'required',
            'pengarang'=>'required',
            'tanggal_publikasi'=>'required|date'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Data Gagal Ditambahkan',
                'data' => $validator->errors()
            ]);
        }

        $data_buku->judul = $request->judul;
        $data_buku->pengarang = $request->pengarang;
        $data_buku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $data_buku->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $data = Buku::find($id);
        if($data){
            return response()->json([
                'status'  => true,
                'message' => 'Data ditemukan',
                'data'    => $data
            ],200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
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
        $data_buku = Buku::find($id);
        if(empty($data_buku)){
            return response()->json([
                'status' => false,
                'message' => 'Data Buku Tidak ditemukan'
            ]);
        }

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tanggal_publikasi' => 'required|date'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Data Buku Gagal Update',
                'data' => $validator->errors()
            ]);
        } 

        $data_buku->judul = $request->judul;
        $data_buku->pengarang = $request->pengarang;
        $data_buku->tanggal_publikasi = $request->tanggal_publikasi;

        $post = $data_buku->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses Mengupdate Data Buku'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $data_buku = Buku::find($id);
        if(empty($data_buku)){
            return response()->json([
                'status' => false,
                'message' => 'Data Buku Tidak ditemukan'
            ]);
        }

        $post = $data_buku->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil dihapus'
        ]);
    }
}
