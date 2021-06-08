<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Diabete;
use App\Hoax;
use Auth;
use Illuminate\Support\Facades\Validator;

// require __DIR__ . '/vendor/autoload.php';
use Biobii\NaiveBayes;

// use App\Library\NaiveBayes;

class AdminController extends Controller
{
    // public function logout(){
    //     Auth::logout();
    //     return redirect('/');
    // }

    public function index(){
        // return view('admin.data', [
        //     'diabetes' => Diabete::all(),
        // ]);
        return view('admin.data', [
            'hoax' => Hoax::all(),
        ]);
    }

    public function postData(Request $req){

        Validator::make($req->all(), [
            'csv' => 'required',
        ])->validate();

        $file = $req->file('csv');
        // dd($file->getPathName());

        $datas = [];
        if (($handle = fopen($file->getPathName(), "r")) !== FALSE) {
            while (! feof($handle)) {
                $data = fgetcsv($handle);
                if (!$data) {
                    continue;
                }
                $datas[] = $data;
            }
            fclose($handle);
        }

        $header = $datas[0];
        unset($header[7]);

        // print_r($datas);

        // for ($i=1; $i < count($datas); $i++) {
        //     $dataset = new Diabete;
        //     unset($datas[$i][7]);
        //     $save = array_combine($header, $datas[$i]);
        //     $dataset->age = $save['age'];
        //     $dataset->bsfast = $save['bsfast'];
        //     $dataset->bspp = $save['bspp'];
        //     $dataset->plasma_r = $save['plasma_r'];
        //     $dataset->plasma_f = $save['plasma_f'];
        //     $dataset->hba1c = $save['hba1c'];
        //     $dataset->type = $save['type'];
        //     $dataset->save();
        // }

        $latih = [];
        for ($i=1; $i < count($datas); $i++) {
            unset($datas[$i][7]);
            $dataset = new Hoax;
            $save = array_combine($header, $datas[$i]);
            $dataset->IdData = $save['ID'];
            $dataset->label = $save['label'];
            $dataset->tanggal = date('Y-m-d', strtotime($save['tanggal']));
            $dataset->judul = $save['judul'];
            $dataset->narasi = $save['narasi'];
            $dataset->save();
            $latih[] = $dataset;
        }
        // print_r($dataset);

        return redirect()->route('data');
    }

    public function NaiveBayes(){
        $getLabel = Hoax::selectRaw('(CASE WHEN table_hoax.label = 1 THEN "Positif" ELSE "Negatif" END) AS Label, judul as Judul, narasi as Narasi')->get()->toArray();
        // print_r($getLabel);

        $uji = [];
        for ($i=1; $i < count($getLabel); $i++) {
            $uji[] = [
                'text' => $getLabel[$i]['Narasi'],
                'class' => $getLabel[$i]['Label'],
            ];
        }

        // print_r($uji);

        $nb = new NaiveBayes();
        $nb->setClass(['positif', 'negatif']);

        // proses training
        $nb->training($uji);

        // pengujian
        // echo $nb->predict('alur ceritanya jelek dan aktingnya payah');
        $text = 'alur ceritanya jelek dan aktingnya payah';
        $res = $nb->predict($text);
        // print_r([ 'train' => $train, 'result' => $res, ]);

        return view('admin.uji', [
            'dataUji' => $uji,
            'text' => $text,
            'result' => $res,
        ]);
    }
}
