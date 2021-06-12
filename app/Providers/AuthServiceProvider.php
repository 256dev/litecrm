<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_DIRECTOR = 'director';

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\CRM\UserPolicy',
        'App\Models\Order' => 'App\Policies\CRM\OrderPolicy',
        'App\Models\Customer' => 'App\Policies\CRM\CustomerPolicy',
        'App\Models\DeviceModel' => 'App\Policies\CRM\DeviceModelPolicy',
        'App\Models\AppSettings' => 'App\Policies\CRM\SettingsPolicy',
        'App\Models\TypeDevice' => 'App\Policies\CRM\TypeDevicePolicy',
        'App\Models\Manufacturer' => 'App\Policies\CRM\ManufacturerPolicy',
        'App\Models\TypeService' => 'App\Policies\CRM\TypeServicePolicy',
        'App\Models\TypeRepairPart' => 'App\Policies\CRM\TypeRepairPartPolicy',
        'App\Models\Defect' => 'App\Policies\CRM\DefectPolicy',
        'App\Models\Condition' => 'App\Policies\CRM\ConditionPolicy',
        'App\Models\Equipment' => 'App\Policies\CRM\EquipmentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
