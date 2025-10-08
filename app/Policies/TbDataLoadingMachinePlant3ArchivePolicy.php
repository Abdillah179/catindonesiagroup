<?php

namespace App\Policies;

use App\Models\User;
use App\Models\tb_data_loading_machine_plant_3_archive;
use Illuminate\Auth\Access\Response;

class TbDataLoadingMachinePlant3ArchivePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, tb_data_loading_machine_plant_3_archive $tbDataLoadingMachinePlant3Archive): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, tb_data_loading_machine_plant_3_archive $tbDataLoadingMachinePlant3Archive): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, tb_data_loading_machine_plant_3_archive $tbDataLoadingMachinePlant3Archive): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, tb_data_loading_machine_plant_3_archive $tbDataLoadingMachinePlant3Archive): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, tb_data_loading_machine_plant_3_archive $tbDataLoadingMachinePlant3Archive): bool
    {
        //
    }
}
