<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            1 => 'Mathematics & Informatics',
            2 => 'Physique',
            3 => 'AP',
        ];

        $specializations = [
            1 => [
                'Computer Science', 'Data Science', 'AI', 'Cybersecurity', 'Software Engineering',
                'Web Dev', 'Mobile Dev', 'Big Data', 'Networking', 'Database Systems',
                'Machine Learning', 'Cloud Computing', 'Information Systems', 'HCI',
                'Distributed Systems', 'Quantum Computing', 'Comp Math', 'Game Dev', 'Bioinformatics', 'NLP'
            ],
            2 => [
                'Theoretical Physics', 'Nuclear Physics', 'Astrophysics', 'Quantum Mechanics', 'Optics',
                'Thermodynamics', 'Statistical Physics', 'Particle Physics', 'Solid State Physics', 'Plasma Physics',
                'Fluid Mechanics', 'Biophysics', 'Electromagnetism', 'Comp Physics', 'Materials Science',
                'Mechanics', 'Condensed Matter', 'Acoustics', 'Space Physics', 'Geophysics'
            ],
            3 => [
                'Algebra', 'Analysis', 'Geometry', 'Probability', 'Statistics',
                'Topology', 'Math Logic', 'Numerical Analysis', 'Discrete Math', 'Diff Eq',
                'Functional Analysis', 'Combinatorics', 'Dyn Systems', 'Math Physics', 'Control Theory',
                'Graph Theory', 'Cryptography', 'Linear Algebra', 'Stochastic Proc', 'Operations Research'
            ]
        ];

        foreach ($specializations as $deptId => $names) {
            foreach ($names as $name) {
                Specialization::create([
                    'name' => $name,
                    'department_id' => $deptId,
                ]);
            }
        }
    }
}
