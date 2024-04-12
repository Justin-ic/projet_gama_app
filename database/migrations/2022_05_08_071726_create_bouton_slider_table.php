<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    use App\Models\Bouton;
    use App\Models\Slider;

    class CreateBoutonSliderTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('bouton_slider', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Bouton::class);
                $table->foreignIdFor(Slider::class);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('bouton_slider');
        }
    }