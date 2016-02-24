<?php namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models\Access\User
 */
class System extends BaseModel {

	protected $table = 'system';

	protected $casts = [
        'content' => 'array',
    ];


    public static function updateBudget($budget)
    {
    	$year = date('Y');

    	for($i = 0; $i < 12; $i++)
    	{
    		DB::table('statistic_expenses')
                ->where('year', $year)
                ->where('month', $i + 1)->update(['budget' => $budget[$i] ]);
    	}
    }

    public static function newBudget($budget)
    {
        $year = date('Y');

        for($i = 0; $i < 12; $i++)
        {
            DB::table('statistic_expenses')->insert([
                'year' => $year,
                'month' => $i + 1,
                'budget' => $budget[$i]
            ]);
        }
    }

    public static function hasBudget($year)
    {
        if (DB::table('statistic_expenses')->where('year', $year)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function addExpense($amount)
    {
        $thisMonthExpense = System::getThisMonthExpense();

        DB::table('statistic_expenses')
            ->where('year', date('Y'))
            ->where('month', date('n'))
            ->update(['cost' => $thisMonthExpense + $amount]);
    }

    public static function getThisMonthExpense()
    {
        $expense = DB::table('statistic_expenses')
            ->where('year', date('Y'))
            ->where('month', date('n'))
            ->first();
            
        return $expense->cost;
    }
}
