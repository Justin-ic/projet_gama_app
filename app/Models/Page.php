<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Page extends Model
    {
        use HasFactory;

        public  function sections(){
            return $this->belongsToMany(Section::class, 'page_sections');
        }
        public function keywords(){
            return $this->belongsToMany(Keyword::class);
        }
    }