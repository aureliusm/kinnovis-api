<?php

use App\Models\Location;
use App\Models\UnitType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Location::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(UnitType::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('status');
            $table->integer('floor')->nullable();
            $table->float('area')->nullable();
            $table->float('width')->nullable();
            $table->float('depth')->nullable();
            $table->float('volume')->nullable();
            $table->float('ceiling_height')->nullable();
            $table->float('door_height')->nullable();
            $table->float('door_width')->nullable();
            $table->string('door_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
