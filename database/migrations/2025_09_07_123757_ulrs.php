<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('original_url', 2048);
            $table->string('short_code', 8)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['short_code']);
            $table->index(['original_url']); // For deduplication
        });
    }

    public function down()
    {
        Schema::dropIfExists('urls');
    }
};