<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamconHotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damcon_hotos', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type')->nullable();
            $table->foreignId('asset_item_id')->constrained('damcon_asssets')->onDelete('cascade')->nullable();
            $table->date('hoto_date')->nullable();
            $table->string('hoto_supervisor')->nullable();
            $table->string('current_possession')->nullable();
            $table->date('date_of_purchase')->nullable();
            $table->string('item_condition')->nullable();
            // $table->string('asset_incharge')->nullable();
            $table->string('asset_brand')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('color')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('milage')->nullable();
            $table->string('last_updated_milage')->nullable();            
            $table->float('purchase_price',16,4)->nullable();
            $table->longText('specifications_1')->nullable();
            $table->longText('specifications_2')->nullable();
            $table->longText('description')->nullable();
            $table->longText('comments')->nullable();
            $table->foreignId('handover_emp_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('handingover_per_cinc')->nullable();
            $table->string('handingover_emp_name')->nullable();    
            $table->string('handingover_emp_damcon_id')->nullable();    
            $table->string('handingover_father_name')->nullable();    
            $table->string('handingover_date_join')->nullable();    
            $table->string('handingover_designation')->nullable();    
            $table->string('handingover_location')->nullable();
            $table->string('handingover_project_id')->nullable();
            $table->foreignId('takeover_emp_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('takingover_per_cinc')->nullable();
            $table->string('takingover_emp_name')->nullable();
            $table->string('takingover_emp_damcon_id')->nullable();
            $table->string('takingover_father_name')->nullable();
            $table->string('takingover_date_join')->nullable();
            $table->string('takingover_designation')->nullable();
            $table->string('takingover_region')->nullable();
            $table->string('takingover_location')->nullable();
            $table->string('takingover_project_id')->nullable();
            $table->json('document_file')->nullable();
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
        Schema::dropIfExists('damcon_hotos');
    }
}
