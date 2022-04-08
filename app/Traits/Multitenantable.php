<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Multitenantable {

    protected static function bootMultitenantable()
    {
        if (auth()->hasUser()) {


            static::creating(function ($model) {
                $model->customer_id = auth()->user()->customer_id;
            });

           if  (auth()->user()->hasanyrole('Customer Admin|Firm User')) {
            static::addGlobalScope('customer_id', function (Builder $builder) {
                $builder->where('customer_id', auth()->user()->customer_id);
            });

            if  (auth()->user()->hasanyrole('Firm User')) {
                static::addGlobalScope('user_id', function (Builder $builder) {
                    $builder->leftjoin('firms_users as fuser', 'fuser.firm_id', '=', 'firms.firma_id');
                    $builder->where('user_id', auth()->user()->id);
                });
            }

          }
        }
    }

}