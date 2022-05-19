<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('companyId')->autoIncrement();
            $table->string('companyName',255);
            $table->string('companyRegistrationNumber',255)->default('0-0');
            $table->date('companyFoundationDate')->nullable();
            $table->string('country',255)->default('');
            $table->unsignedInteger('zipCode');
            $table->string('city',255)->default('');
            $table->string('streetAddress',600)->default('');
            $table->float('latitude')->default(0);
            $table->float('longitude')->default(0);
            $table->string('companyOwner',255)->default('');
            $table->integer('employees')->default(0);
            $table->string('activity',600)->default('');
            $table->tinyInteger('active')->default(0);
            $table->string('email');
            $table->unique('email');
            $table->string('password',255)->default('');
            $table->timestamp('date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index(['companyName','companyFoundationDate', 'email', 'date']);
        });
        DB::unprepared("CREATE TRIGGER companies_check_date_update
        BEFORE UPDATE ON companies
        for each row
        begin
            if (old.date IS NOT NULL && new.date != old.date) then
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'date already set';
            end if ;
        end;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `companies_check_date_update`');
        Schema::dropIfExists('companies');
    }
};
