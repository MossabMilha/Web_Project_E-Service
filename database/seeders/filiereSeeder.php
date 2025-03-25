<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class filiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('filieres')->insert([
            [
                'name' => 'AP1',
                'description' => '1ere année Cycle Préparatoire',
                'coordinator_id' => 12,
                'department_id' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'AP2',
                'description' => '2eme année Cycle Préparatoire',
                'coordinator_id' => 12,
                'department_id' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Genie Civil
            [
                'name' => 'GC1',
                'description' => '1ere année Génie Civil',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GC2',
                'description' => '2eme année Génie Civil',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GC3 HYD',
                'description' => '3eme année Génie Civil (Hydraulique)',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GC3 BPC',
                'description' => '3eme année Génie Civil (Bâtiments et Travaux Publics)',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Genie Informatique
            [
                'name' => 'GI1',
                'description' => '1ere année Génie Informatique',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GI2',
                'description' => '2eme année Génie Informatique',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GI3 GL',
                'description' => '3eme année Génie Informatique (Génie Logiciel)',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GI3 BI',
                'description' => '3eme année Génie Informatique (Business Intelligence)',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GI3 MI',
                'description' => '3eme année Génie Informatique (Médias et Interactions)',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Ingénierie des données
            [
                'name' => 'ID1',
                'description' => '1ere année Ingénierie des données',
                'coordinator_id' => 12,
                'department_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ID2',
                'description' => '2eme année Ingénierie des données',
                'coordinator_id' => 12,
                'department_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ID3',
                'description' => '3eme année Ingénierie des données',
                'coordinator_id' => 12,
                'department_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Transformation Digitale et Intelligence Artificielle
            [
                'name' => 'TDIA1',
                'description' => '1ere année Transformation Digitale et Intelligence Artificielle',
                'coordinator_id' => 12,
                'department_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'TDIA2',
                'description' => '2eme année Transformation Digitale et Intelligence Artificielle',
                'coordinator_id' => 12,
                'department_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'TDIA3',
                'description' => '3eme année Transformation Digitale et Intelligence Artificielle',
                'coordinator_id' => 12,
                'department_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Génie énergétique et énergies renouvelables
            [
                'name' => 'GEER1',
                'description' => '1ere année Génie énergétique et énergies renouvelables',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GEER2',
                'description' => '2eme année Génie énergétique et énergies renouvelables',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GEER3',
                'description' => '3eme année Génie énergétique et énergies renouvelables',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Génie de l’Eau et de l’Environnement
            [
                'name' => 'GEE1',
                'description' => '1ere année Génie de l’Eau et de l’Environnement',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GEE2',
                'description' => '2eme année Génie de l’Eau et de l’Environnement',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GEE3',
                'description' => '3eme année Génie de l’Eau et de l’Environnement',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Génie Mécanique
            [
                'name' => 'GM1',
                'description' => '1ere année Génie Mécanique',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GM2',
                'description' => '2eme année Génie Mécanique',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'GM3',
                'description' => '3eme année Génie Mécanique',
                'coordinator_id' => 12,
                'department_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
