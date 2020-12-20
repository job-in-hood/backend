<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        $representation = $user->forCompany($company);

        return $representation && $representation->hasPermissionTo('company-update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        $representation = $user->forCompany($company);

        return $representation && $representation->hasPermissionTo('company-delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function restore(User $user, Company $company)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function forceDelete(User $user, Company $company)
    {
        //
    }


    /**
     * Determine whether the user can create a job post.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function createJob(User $user, Company $company)
    {
        $representation = $user->forCompany($company);

        return $representation && $representation->hasPermissionTo('job-create');
    }


    /**
     * Determine whether the user can delete a job post.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function deleteJob(User $user, Company $company)
    {
        $representation = $user->forCompany($company);

        return $representation && $representation->hasPermissionTo('job-delete');
    }


    /**
     * Determine whether the user can edit a job post.
     *
     * @param User $user
     * @param Company $company
     * @return mixed
     */
    public function editJob(User $user, Company $company)
    {
        $representation = $user->forCompany($company);

        return $representation && $representation->hasPermissionTo('job-edit');
    }


}
