<?php

    use App\Models\Keyword;
    use App\Models\Page;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateKeywordPageTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('keyword_page', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Page::class);
                $table->foreignIdFor(Keyword::class);
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
            Schema::dropIfExists('keyword_page');
        }
    }