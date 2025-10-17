<?php

namespace Tests\Feature;

use App\Domain\LLM\Data\LLMResponseData;
use App\Domain\LLM\Drivers\ChatGPTDriver;
use App\Domain\LLM\Services\LLMService;
use App\Jobs\ProcessLLMRequestJob;
use App\Models\TravelRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class LLMServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_response_with_chatgpt_driver(): void
    {
        config(['services.openai.api_key' => 'test-key']);

        $service = new LLMService;

        $response = $service->generateResponse(
            'Teste de prompt',
            'chatgpt',
            ['context' => 'teste']
        );

        $this->assertInstanceOf(LLMResponseData::class, $response);
        $this->assertEquals('chatgpt', $response->driver);
    }

    public function test_returns_error_when_driver_not_found(): void
    {
        $service = new LLMService;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Driver 'invalid_driver' não encontrado");

        $service->generateResponse('Teste', 'invalid_driver');
    }

    public function test_can_get_available_drivers(): void
    {
        $service = new LLMService;

        $drivers = $service->getAvailableDrivers();

        $this->assertIsArray($drivers);
    }

    public function test_can_register_custom_driver(): void
    {
        $service = new LLMService;

        $mockDriver = $this->createMock(\App\Domain\LLM\Contracts\LLMDriverInterface::class);
        $mockDriver->method('getName')->willReturn('test_driver');
        $mockDriver->method('isAvailable')->willReturn(true);
        $mockDriver->method('generateResponse')->willReturn('Test response');

        $service->registerDriver('test_driver', $mockDriver);

        $response = $service->generateResponse('Test', 'test_driver');

        $this->assertEquals('test_driver', $response->driver);
    }

    public function test_chatgpt_driver_is_available_when_api_key_set(): void
    {
        config(['services.openai.api_key' => 'test-key']);

        $driver = new ChatGPTDriver('test-key');

        $this->assertTrue($driver->isAvailable());
        $this->assertEquals('chatgpt', $driver->getName());
    }

    public function test_chatgpt_driver_is_not_available_when_api_key_empty(): void
    {
        $driver = new ChatGPTDriver('');

        $this->assertFalse($driver->isAvailable());
    }

    public function test_process_llm_request_job_dispatches_correctly(): void
    {
        Queue::fake();

        $travelRequest = TravelRequest::factory()->create([
            'status' => 'completed',
        ]);

        ProcessLLMRequestJob::dispatch($travelRequest, 'chatgpt');

        Queue::assertPushed(ProcessLLMRequestJob::class);
    }

    public function test_travel_request_service_can_initiate_llm_analysis(): void
    {
        Queue::fake();

        $travelRequest = TravelRequest::factory()->create();
        $service = app(\App\Domain\TravelRequests\Services\TravelRequestService::class);

        $service->initiateLLMAnalysis($travelRequest, 'chatgpt');

        Queue::assertPushed(ProcessLLMRequestJob::class);
    }
}
