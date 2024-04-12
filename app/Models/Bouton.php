<?php

    namespace App\Models;

    use App\Models\Swiper;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

    class Bouton extends Model
    {
        use HasFactory;

        public function sliders(){
            return $this->belongsToMany(Slider::class);
        }
    }