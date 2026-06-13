<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            ['name' => 'Aadhar Card', 'document_type' => 'provider', 'is_required' => false],
            ['name' => 'Driving Licence', 'document_type' => 'provider', 'is_required' => true],
            ['name' => 'Business Registration', 'document_type' => 'shop', 'is_required' => true],
            ['name' => 'Shop & Establishment License', 'document_type' => 'shop', 'is_required' => true],
            ['name' => 'Passport', 'document_type' => 'provider', 'is_required' => true],
            ['name' => 'Pan Card', 'document_type' => 'provider', 'is_required' => false],
        ];

        foreach ($documents as $document) {
            Document::firstOrCreate(
                ['name' => $document['name']],
                array_merge($document, ['status' => 'active'])
            );
        }
    }
}