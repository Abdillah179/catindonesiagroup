<?php

namespace App\Policies;

use App\Models\User;
use App\Models\data_file_laporan_loadingmesin_plant_2_sistem_plant_3;
use Illuminate\Auth\Access\Response;

class DataFileLaporanLoadingmesinPlant2SistemPlant3Policy
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
    public function view(User $user, data_file_laporan_loadingmesin_plant_2_sistem_plant_3 $dataFileLaporanLoadingmesinPlant2SistemPlant3): bool
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
    public function update(User $user, data_file_laporan_loadingmesin_plant_2_sistem_plant_3 $dataFileLaporanLoadingmesinPlant2SistemPlant3): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, data_file_laporan_loadingmesin_plant_2_sistem_plant_3 $dataFileLaporanLoadingmesinPlant2SistemPlant3): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, data_file_laporan_loadingmesin_plant_2_sistem_plant_3 $dataFileLaporanLoadingmesinPlant2SistemPlant3): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, data_file_laporan_loadingmesin_plant_2_sistem_plant_3 $dataFileLaporanLoadingmesinPlant2SistemPlant3): bool
    {
        //
    }
}
