<?php

use App\Models\Enums\TunnelStatus;
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
        Schema::create('tunnels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained();
            $table->string('slug');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('local_address');
            $table->string('remote_address');
            $table->string('domain');
            $table->string('status')->default(TunnelStatus::ACTIVE->value);
            $table->string('api')->unique();
            $table->string('to_ports_api')->nullable();
            $table->string('winbox')->unique();
            $table->string('to_ports_winbox')->nullable();
            $table->string('web')->unique();
            $table->string('to_ports_web')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tunnels');
    }
};
