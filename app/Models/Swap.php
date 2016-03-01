<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class Swap extends Model
{
    use Validatable;

    protected $fillable = [
        'name'
    ];

    private $rules = [
        'name' => 'required|max:255',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'swap_tags', 'swap_id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishes()
    {
        return $this->belongsToMany('App\Models\Tag', 'swap_wishes', 'swap_id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function toArray()
    {
        $data =  [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author,
            'tags' => $this->tags,
            'wishes' => $this->wishes
        ];

        $data['author']['rating'] = $this->author ? $this->author->rating() : 0;

        return $data;
    }
}
