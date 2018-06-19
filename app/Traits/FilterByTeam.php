<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait FilterByTeam
{
    protected static function bootFilterByTeam()
    {
        if (! app()->runningInConsole()) {
            $currentUser = Auth::user();
            if (!$currentUser) {
                return;
            }

            $canSeeAllRecordsRoleId = config('quickadmin.can_see_all_records_role_id');
            $modelName = class_basename(self::class);

            if (!is_null($canSeeAllRecordsRoleId) &&
                $canSeeAllRecordsRoleId === $currentUser->role->id
            ) {
                if (Session::get($modelName . '.filter', 'all') == 'my') {
                    Session::put($modelName . '.filter', 'my');
                    $addScope = true;
                } else {
                    Session::put($modelName . '.filter', 'all');
                    $addScope = false;
                }
            } else {
                $addScope = true;
            }

            if ($addScope && session()->has('team_id')) {
                if (((new self)->getTable()) == 'teams') {
                        static::addGlobalScope('team_id', function (Builder $builder) use ($currentUser) {
                            $builder->whereHas('teams', function ($q) {
                                $q->where('id', session('team_id', null));
                            })->orWhereIn('id', $currentUser->teams->pluck('id'));
                        });
////
////                    static::addGlobalScope('team_id', function (Builder $builder) use ($currentUser) {
////                        $builder->where('team_id', $currentUser->team_id)
////                            ->orWhere('id', $currentUser->team_id);
//                    });

                } else {
                    static::addGlobalScope('team_id', function (Builder $builder) {
                        $builder->whereHas('teams', function ($q) {
                            $q->where('id', session('team_id'));
                        });
                    });
//                    static::addGlobalScope('team_id', function (Builder $builder) use ($currentUser) {
//                        $builder->where('team_id', $currentUser->team_id);
//                    });
                }
            }
        }
    }
}
