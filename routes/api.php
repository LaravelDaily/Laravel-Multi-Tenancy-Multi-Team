<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::get('team-members/{id}', ['uses' => 'TeamMembersController@show', 'as' => 'team-members.show']);
});
