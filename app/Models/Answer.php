<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    /**
     * Get the question that owns the answer.
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Scope a query to only include correct answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCorrectAnswers(Builder $query): Builder
    {
        return $this->getRandomAnswers($query, true);
    }

    /**
     * Scope a query to only include incorrect answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIncorrectAnswers(Builder $query): Builder
    {
        return $this->getRandomAnswers($query, false);
    }

    /**
     * Scope a query to include all answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAllAnswers(Builder $query): Builder
    {
        return $query->correctAnswers()->union($this->incorrectAnswers());
    }

    /**
     * Get random answers.
     *
     * @param Builder $query
     * @param bool $isCorrect
     * @return Builder
     */
    private function getRandomAnswers(Builder $query, bool $isCorrect): Builder
    {
        return $query->where('is_correct', $isCorrect)
            ->select('id', 'question_id', 'content', 'is_correct')
            ->inRandomOrder();
    }
}
