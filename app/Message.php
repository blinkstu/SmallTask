<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content'
    ];

    /**
     * Get the user of the ticket
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * File
     */
    public function file()
    {
        return $this->belongsTo(Files::class);
    }

    /**
     * Get the user of the ticket
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
