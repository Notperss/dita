<?php

namespace Database\Factories\TransactionArchive\Archive;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionArchive\Archive\ArchiveContainer>
 */
class ArchiveContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        $fake = $this->faker;
        // $textSample = 'SDM/005/C/2024/' . $fake->numberBetween(0, 100);
        $textSample = $fake->regexify('[A-Z]{3}/005/C/2024/[0-4]{3}');

        return [
            'company_id' => '11',
            'division_id' => $fake->numberBetween(3, 19),
            'number_container' => '005',
            // 'main_location' => $this->faker->city(),
            'main_location' => 'lokasi utama',
            'sub_location' => 'AREA LEMARI 1',
            'detail_location' => 'lemari kiri',
            'description_location' => $fake->sentence(),
            'main_classification_id' => '15',
            'sub_classification_id' => '191',
            'subseries' => null,
            'period_active' => '1 tahun',
            'period_inactive' => '2 tahun',
            'expiration_active' => '2021-05-05',
            'expiration_inactive' => '2026-05-05',
            'description_active' => $fake->sentence(),
            'description_inactive' => $fake->sentence(),
            'description_retention' => $fake->paragraph(),
            'number_app' => $textSample,
            'number_catalog' => $textSample,
            'number_document' => $textSample,
            'number_archive' => $textSample,
            'regarding' => $fake->sentence(),
            'tag' => $fake->sentence(),
            'document_type' => 'COPY',
            'archive_type' => 'PROYEK',
            'amount' => $fake->numberBetween(0, 100) . '' . $fake->randomElement(['lembar', 'jilid', 'box',]),
            'archive_in' => $fake->dateTimeBetween('-5 week', '+1 days'),
            'year' => '2024',
            'status' => '1',
            'content_file' => null,
            'file' => null,
        ];
    }
}
