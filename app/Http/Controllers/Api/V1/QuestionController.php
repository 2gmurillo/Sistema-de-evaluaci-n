<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\QuestionCollection;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionController extends Controller
{
    /**
     * @return QuestionCollection
     */
    public function index(): QuestionCollection
    {
        return new QuestionCollection($this->questionsWithAnswers());
    }

    /**
     * @return Collection
     */
    private function questionsWithAnswers(): Collection
    {
        return Question::allowed()
            ->select(['id', 'content'])
            ->withAnswers()
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }
}
