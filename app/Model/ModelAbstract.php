<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Class ModelAbstract
 * @package App\Model
 */
class ModelAbstract extends Model
{
    /**
     * @param $query Builder
     * @param $param
     * @return mixed
     */
    public function scopeLike($query, $param)
    {
        collect($param)->each(function ($value, $name) use ($query) {

            if(is_numeric($value)) {
                $query->where(
                    $name,
                    $value
                );
                return true;
            }

            $this->sanitizeInput(strtoupper($value), strtoupper($name));

            if(strtoupper($value) === 'TRUE' || strtoupper($value) === 'FALSE') {
                $query->where(
                    $name,
                    (filter_var($value, FILTER_VALIDATE_BOOLEAN))
                );
                return true;
            }

            $query->where(
                DB::raw("UNACCENT(UPPER($name))"),
                'LIKE',
                DB::raw("UNACCENT(UPPER('%{$value}%'))")
            );

            return true;
        });

        return $query;
    }

    /**
     * @param $value string
     * @param $name string
     */
    private function sanitizeInput($value, $name)
    {
        $valuesError = collect([
            'SELECT', 'ALTER', 'DROP',
            'DELETE', 'TRUNCATE', 'JOIN',
            'WHERE', 'FROM', 'UNION',
            'INTERSECT', 'MINUS', 'BEGIN',
            'COMMIT', 'ROLLBACK', 'OWNER'
        ]);

        $valuesError->each(function($sqlExpression) use ($value, $name) {

            if(strpos($value, $sqlExpression) !== false || strpos($name, $sqlExpression) !== false) {
                throw new Exception('Attemp to  a SQL injection', 403);
            }

        });
        return;
    }

}
