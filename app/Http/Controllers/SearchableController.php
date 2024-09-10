<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

// Keyword abstract means MUST be overridden later.
abstract class SearchableController extends Controller
{
    abstract function getQuery() : Builder;
    function filterByTerm(Builder $query, ?string $term): Builder
    {
       

        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%");
                });
            }
        }

        return $query;
    }
    function prepareSearch(array $search): array
    {
        // null coalescing Operator
        $search['term'] = $search['term'] ?? null;
        return $search;
    }
    function filter(Builder $query, array $search): Builder
    {
        return $this->filterByTerm($query, $search['term']);
    }
    function search(array $search): Builder
    {
        $query = $this->getQuery();
        return $this->filter($query, $search);
    }
    // For easily searching by code.
    function find(string $code): Model
    {
        return $this->getQuery()->where('code', $code)->firstOrFail();
    }
}
