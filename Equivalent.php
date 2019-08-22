<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equivalent extends Model
{
    protected $fillable = ['category_id', 'subcategory_id', 'indicator_id', 
        'weight_id', 'next_id_on_safe', 'next_id_on_danger'];

    public $timestamps = false;

    public function questions () {
        return $this->belongsToMany(Question::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }

    public function indicator() {
        return $this->belongsTo(Indicator::class);
    }

    public function weight() {
        return $this->belongsto(Weight::class);
    }

    public function fullCategoryStr() {
        return "[" .$this->indicator->name . "] " .$this->category->name . ": ". $this->subcategory['name'] ; 
    }

    public function fullEquivStr() {
        $str = "[";
        foreach ($this->questions as $q) {
            $str = $str. $q->text . ", "; 
        }

        if (strlen($str) > 1) $str= substr($str, 0,-2);

        return $this->fullCategoryStr() . " " . $str . "]";
    }

    public static function allWithQuestions() {
        return Equivalent::has('questions', '>', 0)->get();
    }

    // transform the equivalent into a format for easy export
    public function transformForExport() {
        return [
            'equivalent_id' => $this->id,
            'next_danger_id' => $this->next_id_on_danger,
            'next_safe_id' => $this->next_id_on_safe,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'weight' => $this->weight_id,
            'indicator_id' => $this->indicator_id,
        ];
    }

}
