<?php

namespace App\Http\Controllers;

use App\Imports\SantriImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


class DataController extends Controller
{
    public function importExcelSantri(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $fileName = rand() . $file->getClientOriginalName();

            $file->move('file_santri', $fileName);

            Excel::import(new SantriImport(), public_path('/file_santri/' . $fileName));

            return back()->with(["success"=>"Berhasil Mengimport Data Santri"]);

        } catch (\Exception $exception) {
            return $exception;
        }

    }
}
