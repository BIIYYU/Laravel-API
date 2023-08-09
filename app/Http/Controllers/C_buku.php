<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class C_buku extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const API_URL = "http://localhost:8000/api/buku";

    public function index(Request $request)
    {
        $current_url = url()->current();

        $client = new Client();
        $url = static::API_URL;

        if($request->input('page') != ''){
            $url .= "?page=".$request->input('page');
        }
        $response = $client->request('GET',$url);

        // dd($response);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);

        $data = $contentArray['data'];
        foreach ($data['links'] as $key => $value) {
            $data['links'][$key]['url2'] = str_replace(static::API_URL,$current_url,$value['url']);
        }


        return view('buku.index',['data'=>$data]);
        
        // echo "<pre>";
        // print_r ($data);
        // echo "</pre>"; exit();
        
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
        $judul             = $request->judul;
        $pengarang         = $request->pengarang;
        $tanggal_publikasi = $request->tanggal_publikasi;

        $parameter = [
            'judul'             => $judul,
            'pengarang'         => $pengarang,
            'tanggal_publikasi' => $tanggal_publikasi
        ];

        $client = new Client();
        $url = "http://localhost:8000/api/buku";
        $response = $client->request('POST', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return 
            redirect()->to('buku')->with('success', 'Berasil Memasukkan Data');
            
        }
        // $data = $contentArray['data'];
        // return view('buku.index',['data' =>$data]);
        // dd($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request('GET',$url);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);

        if($contentArray['status'] != true){
            $error = $contentArray['message'];
            return redirect()->to('buku')->withErrors($error);
        }else{
            $data = $contentArray['data'];
            return view('buku.index',['data'=>$data]);
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
        $judul             = $request->judul;
        $pengarang         = $request->pengarang;
        $tanggal_publikasi = $request->tanggal_publikasi;

        $parameter = [
            'judul'             => $judul,
            'pengarang'         => $pengarang,
            'tanggal_publikasi' => $tanggal_publikasi
        ];

        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return 
            redirect()->to('buku')->with('success', 'Berasil Melakukan Update Data');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = new Client();
        $url = "http://localhost:8000/api/buku/$id";
        $response = $client->request('DELETE', $url);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status'] != true){
            $error = $contentArray['data'];
            return redirect()->to('buku')->withErrors($error)->withInput();
        } else {
            return 
            redirect()->to('buku')->with('success', 'Berasil Menghapus Data');
            
        }
    }
}
