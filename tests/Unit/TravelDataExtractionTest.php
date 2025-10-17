<?php

namespace Tests\Unit;

use App\Domain\Chat\Services\TravelTemplateService;
use Tests\TestCase;

class TravelDataExtractionTest extends TestCase
{
    private TravelTemplateService $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = new TravelTemplateService;
    }

    public function test_extracts_people_count_from_message(): void
    {
        $message = 'preciso de preparar uma viagem para 2 pessoas, de rio de janeiro para são paulo';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('2', $extractedData['adults']);
    }

    public function test_extracts_city_from_and_destination(): void
    {
        $message = 'preciso de preparar uma viagem para 2 pessoas, de rio de janeiro para são paulo';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('Rio de Janeiro', $extractedData['city_from']);
        $this->assertEquals('São Paulo', $extractedData['city_destination']);
    }

    public function test_extracts_multiple_data_from_complex_message(): void
    {
        $message = 'Olá, sou João Silva, email joao@test.com, telefone +351912345678. Preciso de uma viagem para 3 pessoas de Lisboa para Madrid';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('João Silva', $extractedData['full_name']);
        $this->assertEquals('joao@test.com', $extractedData['email']);
        $this->assertEquals('+351912345678', $extractedData['mobile_phone']);
        $this->assertEquals('3', $extractedData['adults']);
        $this->assertEquals('Lisboa', $extractedData['city_from']);
        $this->assertEquals('Madrid', $extractedData['city_destination']);
    }

    public function test_extracts_people_count_with_different_patterns(): void
    {
        $testCases = [
            'viagem para 4 pessoas' => '4',
            'preciso de 2 adultos' => '2',
            '3 viajantes de Porto' => '3',
            'para 5 passageiros' => '5',
        ];

        foreach ($testCases as $message => $expectedCount) {
            $extractedData = $this->templateService->extractTravelDataFromMessage($message);
            $this->assertEquals($expectedCount, $extractedData['adults'], "Failed for message: {$message}");
        }
    }

    public function test_extracts_cities_with_different_patterns(): void
    {
        $testCases = [
            'de Porto para Lisboa' => ['city_from' => 'Porto', 'city_destination' => 'Lisboa'],
            'parto de Madrid para Barcelona' => ['city_from' => 'Madrid', 'city_destination' => 'Barcelona'],
            'vou de Paris para London' => ['city_from' => 'Paris', 'city_destination' => 'London'],
        ];

        foreach ($testCases as $message => $expected) {
            $extractedData = $this->templateService->extractTravelDataFromMessage($message);

            if (isset($expected['city_from'])) {
                $this->assertEquals($expected['city_from'], $extractedData['city_from'], "Failed city_from for message: {$message}");
            }
            if (isset($expected['city_destination'])) {
                $this->assertEquals($expected['city_destination'], $extractedData['city_destination'], "Failed city_destination for message: {$message}");
            }
        }
    }

    public function test_handles_english_messages(): void
    {
        $message = 'I need to prepare a trip for 2 people from New York to Miami';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('2', $extractedData['adults']);
        $this->assertEquals('New York', $extractedData['city_from']);
        $this->assertEquals('Miami', $extractedData['city_destination']);
    }

    public function test_handles_spanish_messages(): void
    {
        $message = 'Necesito preparar un viaje para 3 personas desde Barcelona hasta Madrid';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('3', $extractedData['adults']);
        $this->assertEquals('Barcelona', $extractedData['city_from']);
        $this->assertEquals('Madrid', $extractedData['city_destination']);
    }

    public function test_returns_empty_array_when_no_data_found(): void
    {
        $message = 'Olá, como está?';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEmpty($extractedData);
    }

    public function test_extracts_email_and_phone(): void
    {
        $message = 'Meu email é teste@exemplo.com e telefone +351912345678';

        $extractedData = $this->templateService->extractTravelDataFromMessage($message);

        $this->assertEquals('teste@exemplo.com', $extractedData['email']);
        $this->assertEquals('+351912345678', $extractedData['mobile_phone']);
    }

    public function test_extracts_name_from_different_patterns(): void
    {
        $testCases = [
            'Meu nome é João Silva' => 'João Silva',
            'Sou Maria Santos' => 'Maria Santos',
            'Chamo-me Pedro Costa' => 'Pedro Costa',
        ];

        foreach ($testCases as $message => $expectedName) {
            $extractedData = $this->templateService->extractTravelDataFromMessage($message);
            $this->assertEquals($expectedName, $extractedData['full_name'], "Failed for message: {$message}");
        }
    }
}
