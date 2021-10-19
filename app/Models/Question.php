<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * Get the answers for the question.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Scope a query to only include allowed questions, which means questions that
     * have at least one correct answer and one incorrect answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAllowed(Builder $query): Builder
    {
        return $query->hasCorrectAnswers()->hasIncorrectAnswers();
    }

    /**
     * Scope a query to include correct answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeHasCorrectAnswers(Builder $query): Builder
    {
        return $query->whereHas('answers', function (Builder $query){
            $query->where('is_correct', true);
        });
    }

    /**
     * Scope a query to include incorrect answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeHasIncorrectAnswers(Builder $query): Builder
    {
        return $query->whereHas('answers', function (Builder $query){
            $query->where('is_correct', false);
        });
    }

    /**
     * Scope a query to include all answers.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithAnswers(Builder $query): Builder
    {
        return $query->with([
            'answers' => function ($query) {
                $query->allAnswers();
            }
        ]);
    }
}
