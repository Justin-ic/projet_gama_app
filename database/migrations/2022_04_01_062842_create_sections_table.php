<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateSectionsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('sections', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique('sectionName');
                $table->string('vue');
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('img')->nullable();
                $table->string('option')->nullable();
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
            Schema::dropIfExists('sections');
        }
    }