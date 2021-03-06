<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'theme', 'status'
    ];

    /**
     * Get the messages of ticket
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->with(['file', 'user'])->orderBy('id', 'desc');
    }

    /**
     * Get the user of the ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
