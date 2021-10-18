<?php

namespace Tests\Feature\Controllers\Api\V1\Question;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itCanListQuestionsWithAnswers(): void
    {
        Question::factory()
            ->has(Answer::factory()->isCorrect()->count(1))
            ->has(Answer::factory()->count(3))
            ->count(50)
            ->create();

        $response = $this->json('GET', route('v1.questions.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('status')
                ->has('data', 5)
                ->has('data.0', fn ($json) =>
                $json->has('content')
                    ->has('answers')
                    ->has('answers.0', fn ($json) =>
                        $json->has('id')
                            ->has('content')
                            ->missing('is_correct')
                            ->missing('created_at')
                            ->missing('updated_at')
                            ->missing('question_id')
                            ->etc()
                    )
                    ->missing('created_at')
                    ->missing('updated_at')
                    ->etc()
                )
            );
    }
}
