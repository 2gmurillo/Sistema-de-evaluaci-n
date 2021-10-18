<?php

namespace Tests\Feature\Controllers\Api\V1\TestResult;

use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itCanCheckTestResult(): void
    {
        $correctAnswers = Answer::factory()
            ->isCorrect()
            ->count(4)
            ->create()
            ->pluck('id')
            ->toArray();

        $incorrectAnswers = Answer::factory()
            ->count(1)
            ->create()
            ->pluck('id')
            ->toArray();

        $answers = array_merge($correctAnswers, $incorrectAnswers);

        $response = $this->postJson(route('v1.test-result.check'), ['answers' => $answers]);

        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('status')
                ->has('data', fn($json) =>
                    $json->has('answers', fn($json) =>
                        $json->where('correct', 4)
                            ->where('incorrect', 1)
                    )
                )
        );
    }

    /**
     * @test
     * @dataProvider invalidDataProvider
     * @param $data
     * @param string $message
     */
    public function itCanValidateRequestDataToCheckTestResult($data, string $message)
    {
        $response = $this->postJson(route('v1.test-result.check'), ['answers' => $data]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson(fn(AssertableJson $json) =>
            $json->has('status')
                ->has('data', fn($json) =>
                    $json->where('answers', [$message])
                )
        );
    }

    /**
     * @return array
     */
    public function invalidDataProvider(): array
    {
        return [
            'The answers field is required.' => [[], 'The answers field is required.'],
            'The answers field must be an array.' => ['string', 'The answers must be an array.'],
            'The answers field must have registered answers.' => [[1, 2, 3, 4, 5], 'The selected answers is invalid.'],
        ];
    }
}
