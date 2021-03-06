<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;
    use Search;

    protected $searchable = ['name', 'description'];

    protected $fillable = ['name', 'description', 'user_id', 'quest_id', 'npc_id', 'location_id', 'notebook_id', 'organization_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function npc()
    {
        return $this->belongsTo(NPC::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function notelettes()
    {
        return $this->morphToMany(Notelette::class, 'noteletteable');
    }

    public function notebook()
    {
        return $this->belongsTo(Notebook::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
