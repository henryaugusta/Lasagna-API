<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Guru;
use Illuminate\Database\Seeder;

class PembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Guru();
        $data->name = "Habibullah, S.Pd.";
        $data->contact = "082179970001";
        $data->photo_path = "";
        $data->email = "habibullah@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "M. Asy'ari Rahman, S.Pd.I.";
        $data->contact = "082179970002";
        $data->photo_path = "";
        $data->email = "asyari_rahman@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Muhammad Ihrom, Lc";
        $data->contact = "082179970003";
        $data->photo_path = "";
        $data->email = "m_ihrom@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Ir. Rayis Syamlan";
        $data->contact = "082179970004";
        $data->photo_path = "";
        $data->email = "rayis_syamlan@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Agung Wahyu Suwastanto";
        $data->contact = "082179970005";
        $data->photo_path = "";
        $data->email = "agung_wahyu_suwastanto@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Said, Lc.";
        $data->contact = "082179970006";
        $data->photo_path = "";
        $data->email = "harun_sugiri@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Edi Saputro";
        $data->contact = "082179970007";
        $data->photo_path = "";
        $data->email = "edi_saputro@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Ajang Uli Muhajir, S.Pd.I.";
        $data->contact = "082179970008";
        $data->photo_path = "";
        $data->email = "muhajir@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Sakri Wibowo";
        $data->contact = "082179970009";
        $data->photo_path = "";
        $data->email = "sakri_wibowo@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Fahmi fauzan";
        $data->contact = "082179970010";
        $data->photo_path = "";
        $data->email = "fahmi_fauzan@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "M. Abu Dzar Al Azmi, A.Md.";
        $data->contact = "082179970011";
        $data->photo_path = "";
        $data->email = "abu_dzar@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Subakti, S.Pd";
        $data->contact = "082179970012";
        $data->photo_path = "";
        $data->email = "subakti@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "Nurohmat Palupianto";
        $data->contact = "082179970013";
        $data->photo_path = "";
        $data->email = "nurohmat_palupianto@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

        $data = new Guru();
        $data->name = "M. Husain Ramadhan, S.Pd.";
        $data->contact = "082179970013";
        $data->photo_path = "";
        $data->email = "husain_ramadhan@albinaa.com";
        $data->password = bcrypt("albinaaIBS!");
        $data->save();

    }
}
