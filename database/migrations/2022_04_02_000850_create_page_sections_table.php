<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    use App\Models\Page;
    use App\Models\Section;

    class CreatePageSectionsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('page_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(Page::class);
                $table->foreignIdFor(Section::class);
                $table->integer('rang')->default(100);
                $table->boolean('active')->default(true);
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
            Schema::dropIfExists('page_sections');
        }
    }