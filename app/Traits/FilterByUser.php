<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait FilterByUser
{
    protected static function bootFilterByUser()
    {
        if (!app()->runningInConsole()) {
//            static::creating(function ($model) {
//                $model->created_by_id = Auth::check() ? Auth::User()->id : null;
//                $model->created_by_team_id = Auth::check() ? Auth::User()->team_id : null;
//            });

            $currentUser = Auth::user();
            if (!$currentUser) {
                return;
            }

            $canSeeAllRecordsRoleId = config('quickadmin.can_see_all_records_role_id');
            $modelName = class_basename(self::class);

            if (! is_null($canSeeAllRecordsRoleId) &&
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

            if ($currentUser->role->id == 3) {
                if ($addScope) {
                    if (((new self)->getTable()) == 'teams') {
                        static::addGlobalScope('created_by_team_id', function (Builder $builder) use ($currentUser) {
                            $builder->where('created_by_team_id', session('team_id'))
                                ->orWhere('id', session('team_id'));
                        });
                    } else {
                        static::addGlobalScope('created_by_team_id', function (Builder $builder) use ($currentUser) {
                            $builder->where('created_by_team_id', session('team_id'));
                        });
                    }
                }
            } else {
                if ($addScope) {
                    if (((new self)->getTable()) == 'users') {
                        static::addGlobalScope('created_by_id', function (Builder $builder) use ($currentUser) {
                            $builder->where([
                                'created_by_id' => $currentUser->id,
                                'created_by_team_id' => session('team_id')
                                ])
                                ->orWhere('id', $currentUser->id);
                        });
                    } else {
                        static::addGlobalScope('created_by_id', function (Builder $builder) use ($currentUser) {
                            $builder->where([
                                'created_by_id' => $currentUser->id,
                                'created_by_team_id' => session('team_id')
                            ]);
                        });
                    }
                }
            }
        }
    }
}
