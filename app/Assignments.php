<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model
{
	protected $fillable=[
		'type',
		'title',
        'question',
        'answer_1',
        'answer_2',
        'answer_3',
        'correct_answer',
        'location'
    ];
    protected $table = 'assignments';
}
