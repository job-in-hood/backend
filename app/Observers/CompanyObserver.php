<?php

namespace App\Observers;

use App\Models\Company;
use App\Notifications\CompanyCreated;
use Illuminate\Support\Facades\Notification;

class CompanyObserver
{
    /**
     * Handle the company "created" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        $company->notify(new CompanyCreated($company));
    }

    /**
     * Handle the company "updated" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the company "deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the company "restored" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the company "force deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
