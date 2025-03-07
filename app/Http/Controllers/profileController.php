<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index(){
        //m just waiting for you to push so I can use data from the database
        $student = [
            'id' => 1,
            'contact_info_id' => 1,
            'birth_info_id' => 1,
            'bac_info_id' => 1,
            'CIN' => 'G123456',
            'CNE' => 'G123456',
            'first_name' => 'Mossab',
            'last_name' => 'Milha',
        ];
        $birth_info = [
            'id' => 1,
            'gender' => 'male',
            'birth_date' => '1999-01-01',
            'birth_city' => 'Casablanca',
            'birth_province' => 'Casablanca',
            'birth_place' => 'Casablanca',
            'birth_city_ar' => 'الدار البيضاء',
            'birth_province_ar' => 'الدار البيضاء',
            'birth_place_ar' => 'الدار البيضاء',
        ];
        $baccaulaureate = [
            'id' => 1,
            'bac_year' => '2018',
            'bac_type' => 'Sciences Maths A',
            'bac_mention' => 'Bien',
            'bac_origin' => 'Public',
            'academy' => 'Casablanca',
            'hight_school' => 'Lycée Lyautey',
            'hight_school_type' => 'Public',
        ];
        $student_parent = [
            'id' => 1,
            'student_id' => 1,
            'parent_phone' => '0612345678',
            'father_profession' => 'Ingénieur',
            'mother_profession' => 'Médecin',
            'parents_province' => 'Casablanca',
            'parents_adresse' => 'Casablanca',
        ];
        $contact = [
            'id' => 1,
            'phone' => '0612345678',
            'email' => 'example@gmail.com',
            'institution_email' => 'example@etu.uae.ac.ma',
        ];
        $information = [
            'student' => ['title' => "Identification De L'Etudiant", 'data' => $student],
            'birth_info' => ['title' => "Informations De Naissance", 'data' => $birth_info],
            'baccaulaureate' => ['title' => "Informations Du Baccalauréat", 'data' => $baccaulaureate],
            'student_parent' => ['title' => "Informations Des Parents", 'data' => $student_parent],
            'contact' => ['title' => "Informations De Contact", 'data' => $contact]
        ];
        return view('profile',['information' => $information]);
    }
}
