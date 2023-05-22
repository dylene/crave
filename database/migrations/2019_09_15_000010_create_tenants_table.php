<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();

            // your custom columns may go here
            $table->string('company', 512)->unique();
            $table->string('email')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('payment_gateway_id')->nullable();

            $table->timestamps();
            $table->json('data')->nullable();

            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
