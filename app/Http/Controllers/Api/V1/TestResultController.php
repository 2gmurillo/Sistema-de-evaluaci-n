<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CheckTestResultRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TestResultController extends Controller
{
    /**
     * @param CheckTestResultRequest $request
     * @return JsonResponse
     */
    public function check(CheckTestResultRequest $request): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => [
                'answers' => $this->getTestResult($request)
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getTestResult(Request $request): array
    {
        $answers = $this->getCheckedAnswers($request);

        return [
            'correct' => $this->getAmount($answers, true),
            'incorrect' => $this->getAmount($answers, false),
        ];
    }

    /**
     * @param Request $request
     * @return Collection
     */
    private function getCheckedAnswers(Request $request): Collection
    {
        return DB::table('answers')
            ->whereIn('id', $request->get('answers'))
            ->select(DB::raw('count(is_correct) as amount, is_correct'))
            ->groupBy('is_correct')
            ->get();
    }

    /**
     * @param Collection $answers
     * @param bool $isCorrect
     * @return int
     */
    private function getAmount(Collection $answers, bool $isCorrect): int
    {
        return $answers->where('is_correct', $isCorrect)->pluck('amount')->first() ?? 0;
    }
}
