<?php

use App\Http\Controllers\Api\Admin\HomeController;
use App\Http\Controllers\Api\Admin\AdminRequestController;
use App\Http\Controllers\Api\Admin\BnyadmRequstController;
use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\OperationController;
use App\Http\Controllers\Api\Admin\OrgnizationController;
use App\Http\Controllers\Api\Admin\TaskController;
use App\Http\Controllers\Api\Admin\PolicyController;
use App\Http\Controllers\Api\Admin\NotifictionUserController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\NotificationRequestController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Orgnization\HomeController as HomeOrganizationController;
use App\Http\Controllers\Api\Orgnization\BnyadmRequstController as OrgnizationBnyadmRequstController;
use App\Http\Controllers\Api\Orgnization\EventController as OrgnizationEventController;
use App\Http\Controllers\Api\Orgnization\LocationController as OrgnizationLocationController;
use App\Http\Controllers\Api\Orgnization\OperationController as OrgnizationOperationController;
use App\Http\Controllers\Api\Orgnization\RequestController;
use App\Http\Controllers\Api\Orgnization\TaskController as OrgnizationTaskController;
use App\Http\Controllers\Api\Orgnization\UserController as OrgnizationUserController;
use App\Http\Controllers\Api\Orgnization\ProjectController;
use App\Http\Controllers\Api\Orgnization\NewsFeedsController;
use App\Http\Controllers\Api\User\ApplyController;
use App\Http\Controllers\Api\User\BnyadmController;
use App\Http\Controllers\Api\User\HistoryController;
use App\Http\Controllers\Api\User\HomePageController;
use App\Http\Controllers\Api\User\LocationController as UserLocationController;
use App\Http\Controllers\Api\User\RequestListController;
use App\Http\Controllers\Api\User\ShakwaController;
use App\Http\Controllers\Api\User\EventUserController;
use App\Http\Controllers\Api\User\UserNewsFeedsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/policies', [AuthenticationController::class, 'policies']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/verify-email', [AuthenticationController::class, 'verifyEmail']);
Route::post('/forget-password', [AuthenticationController::class, 'forgetPassword']);
Route::get('/user/cityCountryList', [UserLocationController::class, 'GetCity']);
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword']);


    Route::middleware((['auth:sanctum','IsAdmin']))->group(function () {// UserNewsFeedsController
        Route::get('/admin/policy', [PolicyController::class, 'view']);
        Route::post('/admin/policy/update', [PolicyController::class, 'update']);

///////////////////////////////////////////// Notification //////////////////////////////////////////////////

        Route::get('/admin/noti/view', [NotificationRequestController::class, 'view']);
        Route::get('/admin/noti/notification_num', [NotificationRequestController::class, 'notification_num']);
        Route::post('/admin/noti/view_notification', [NotificationRequestController::class, 'view_notification']);
        Route::post('/admin/noti/view_request/{id}', [NotificationRequestController::class, 'view_request']);

///////////////////////////////////////////// Notification //////////////////////////////////////////////////

        Route::get('/admin/notification', [NotifictionUserController::class, 'view']);
        Route::get('/admin/notification/item/{id}', [NotifictionUserController::class, 'notification']);
        Route::post('/admin/notification/add', [NotifictionUserController::class, 'create']);
        Route::post('/admin/notification/update/{id}', [NotifictionUserController::class, 'modify']);
        Route::delete('/admin/notification/delete/{id}', [NotifictionUserController::class, 'delete']);

///////////////////////////////////////////// Home //////////////////////////////////////////////////
        Route::get('/admin/profile', [AuthenticationController::class, 'userProfile']);
        Route::post('/admin/profile_update', [AuthenticationController::class, 'editUserProfile']);

///////////////////////////////////////////// Home //////////////////////////////////////////////////

        Route::get('/admin/Home', [HomeController::class, 'view']);

///////////////////////////////////////////// News Feeds //////////////////////////////////////////////////

        Route::get('/admin/news_feeds', [NewsFeedsController::class, 'view']);
        Route::get('/admin/news_feeds/item/{id}', [NewsFeedsController::class, 'news_feeds']);
        Route::post('/admin/news_feeds/add', [NewsFeedsController::class, 'create']);
        Route::post('/admin/news_feeds/update/{id}', [NewsFeedsController::class, 'modify']);
        Route::delete('/admin/news_feeds/delete/{id}', [NewsFeedsController::class, 'delete']);

///////////////////////////////////////////// Countries //////////////////////////////////////////////////

        Route::get('/admin/country', [LocationController::class, 'GetCountry']);

        Route::post('/admin/country/add', [LocationController::class, 'addCountry']);

        Route::put('/admin/country/update/{id}', [LocationController::class, 'UpdateCountry']);

        Route::delete('/admin/country/delete/{id}', [LocationController::class, 'DeleteCountry']);

//////////////////////////////////////////////////// Cities //////////////////////////////////////////////////

        Route::get('/admin/city', [LocationController::class, 'GetCity']);

        Route::post('/admin/city/add', [LocationController::class, 'addCity']);

        Route::put('/admin/city/update/{id}', [LocationController::class, 'UpdateCity']);

        Route::delete('/admin/city/delete/{id}', [LocationController::class, 'DeleteCity']);

//////////////////////////////////////////////////// Zones //////////////////////////////////////////////////

        Route::get('/admin/zone', [LocationController::class, 'GetZones']);

        Route::post('/admin/zone/add', [LocationController::class, 'addZone']);

        Route::put('/admin/zone/update/{id}', [LocationController::class, 'UpdateZone']);

        Route::delete('/admin/zone/delete/{id}', [LocationController::class, 'DeleteZone']);

/////////////////////////////////////////////////// Users ////////////////////////////////////////////////////

        Route::get('/admin/users', [UserController::class, 'getUsers']);

        Route::put('/admin/user/status/{id}', [UserController::class, 'status']);

        Route::put('/admin/user/statusGroup', [UserController::class, 'statusGroup']);

        Route::get('/admin/user/{id}', [UserController::class, 'getUser']);

        Route::post('/admin/user/add', [UserController::class, 'addUser']);

        Route::put('/admin/user/update/{id}', [UserController::class, 'updateUser']);

        Route::delete('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);
        
        Route::delete('/admin/user/deleteGroup', [UserController::class, 'deleteGroup']);

//////////////////////////////////////////////// Orgnization //////////////////////////////////////////////////

        Route::get('/admin/organization', [OrgnizationController::class, 'getOrgnization']);

        Route::get('/admin/organization/{id}', [OrgnizationController::class, 'getOrgnizationById']);

        Route::post('/admin/organization/add', [OrgnizationController::class, 'addOrgnization']);

        Route::put('/admin/organization/status/{id}', [OrgnizationController::class, 'status']);

        Route::put('/admin/organization/statusGroup', [OrgnizationController::class, 'statusGroup']);

        Route::put('/admin/organization/update/{id}', [OrgnizationController::class, 'updateOrgnization']);

        Route::delete('/admin/organization/delete/{id}', [OrgnizationController::class, 'deleteOrgnization']);

        Route::delete('/admin/organization/deleteGroup', [OrgnizationController::class, 'deleteGroup']);


////////////////////////////////////////////////// Events ////////////////////////////////////////////////////

        Route::get('/admin/event', [EventController::class, 'getEvents']);

        Route::get('/admin/event/{id}', [EventController::class, 'getEventById']);

        Route::post('/admin/event/add', [EventController::class, 'addEvent']);

        Route::put('/admin/event/update/{id}', [EventController::class, 'updateEvent']);

        Route::delete('/admin/event/delete/{eventId}', [EventController::class, 'deleteEvent']);

        Route::delete('/admin/event/deleteGroup', [EventController::class, 'deleteGroup']);

/////////////////////////////////////////////////// Tasks ////////////////////////////////////////////////////////

        Route::get('/admin/task', [TaskController::class, 'getTasks']);

        Route::get('/admin/task/{id}', [TaskController::class, 'getTaskById']);

        Route::post('/admin/task/add', [TaskController::class, 'addTask']);

        Route::put('/admin/task/update/{id}', [TaskController::class, 'updateTask']);

        Route::delete('/admin/task/delete/{id}', [TaskController::class, 'deleteTask']);

        Route::delete('/admin/task/deleteGroup', [TaskController::class, 'deleteGroup']);

//////////////////////////////////////////////////// Requests ////////////////////////////////////////////////////////

        Route::get('/admin/request', [AdminRequestController::class, 'getAllRequest']);

        Route::get('/admin/request/{id}', [AdminRequestController::class, 'getRequestById']);

        Route::put('/admin/request/accept/{id}', [AdminRequestController::class, 'acceptRequest']);

        Route::put('/admin/request/reject/{id}', [AdminRequestController::class, 'rejectRequest']);

        Route::delete('/admin/request/delete/{id}', [AdminRequestController::class, 'deleteRequest']);

        Route::put('/admin/request/acceptGroup', [AdminRequestController::class, 'acceptGroup']);

        Route::put('/admin/request/rejectGroup', [AdminRequestController::class, 'rejectGroup']);

        Route::delete('/admin/request/deleteGroup', [AdminRequestController::class, 'deleteGroup']);

//////////////////////////////////////////////// Shakwa and Suggest ////////////////////////////////////////////////////////

        Route::get('/admin/shakwa', [UserController::class, 'getShakawy']);

        Route::get('/admin/suggest', [UserController::class, 'getSuggests']);

//////////////////////////////////////////////////// OPERATION /////////////////////////////////////////////////////////

        Route::get('/admin/getEventDetails/{eventId}', [OperationController::class, 'getEventsDetails']);

        Route::get('/admin/getTaskDetails/{taskId}', [OperationController::class, 'getTasksDetails']);

        Route::get('/admin/getEventVolunteers/{eventId}', [OperationController::class, 'getEventVolunteers']);

        Route::get('/admin/getTaskVolunteers/{taskId}', [OperationController::class, 'getTaskVolunteers']);

        Route::put('/admin/changeEventVolunteerStatus/{volunteerId}', [OperationController::class, 'changeEventVolunteerStatus']);

        Route::put('/admin/changeTaskVolunteerStatus/{volunteerId}', [OperationController::class, 'changeTaskVolunteerStatus']);

        Route::get('/admin/getEventShakawy/{eventId}', [OperationController::class, 'getEventShakwat']);

        Route::get('/admin/getTaskShakawy/{taskId}', [OperationController::class, 'getTaskShakwat']);

        Route::get('/admin/getEventSuggest/{eventId}', [OperationController::class, 'getEventSuggest']);

        Route::get('/admin/getTaskSuggest/{taskId}', [OperationController::class, 'getTaskSuggest']);

        Route::put('/admin/readEventSuggest/{eventId}', [OperationController::class, 'ReadEventSuggest']);

        Route::put('/admin/readTaskSuggest/{taskId}', [OperationController::class, 'ReadTaskSuggest']);

////////////////////////////////////////////////////// Bnyadm /////////////////////////////////////////////////////////

        Route::get('/admin/bnyadm', [BnyadmRequstController::class, 'getBnyadmRequstList']);

        Route::get('/admin/bnyadm/{id}', [BnyadmRequstController::class, 'getBnyadmRequstDetails']);

        Route::put('/admin/bnyadm/accept/{id}', [BnyadmRequstController::class, 'acceptBnyadmRequst']);

        Route::put('/admin/bnyadm/reject/{id}', [BnyadmRequstController::class, 'rejectBnyadmRequst']);

        Route::put('/admin/bnyadm/acceptGroup', [BnyadmRequstController::class, 'acceptGroup']);

        Route::put('/admin/bnyadm/rejectGroup', [BnyadmRequstController::class, 'rejectGroup']);





    });






    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/news_feeds', [UserNewsFeedsController::class, 'view']);

        Route::post('user/delete_account', [AuthenticationController::class, 'delete_account']);

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::put('/user/profile/update', [AuthenticationController::class, 'editUserProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);

        Route::post('/user/attend_event', [EventUserController::class, 'user_location']);

        Route::get('/user/notifications', [HomePageController::class, 'notifications']);
        
        Route::get('/user/eventsAndTasks', [HomePageController::class, 'getEventsAndTaks']);

        Route::get('/user/historyRequests',[HistoryController::class,'getHistoryAttend']);
        Route::get('/user/upcomingEvents',[HistoryController::class,'events']);
        Route::get('/user/upcomingTasks',[HistoryController::class,'tasks']);

        Route::get('/user/pendingApproved',[RequestListController::class,'PendingApproved']);

        Route::post('/user/Apply',[ApplyController::class,'applyFor']);

        Route::get('/user/shakwa',[ShakwaController::class,'getShakwa']);

        Route::post('/user/shakwa/add',[ShakwaController::class,'AddShakwa']);

        Route::get('/user/suggest',[ShakwaController::class,'getSuggest']);

        Route::post('/user/suggest/add',[ShakwaController::class,'AddSuggest']);

        Route::post('/user/bebnyadm',[BnyadmController::class,'BeBnyadm']);

        Route::get('/user/OrgnizationList',[ApplyController::class,'OrginizationList']);


    });




    Route::middleware((['auth:sanctum','IsOrgniazation']))->group(function () {

        Route::get('/ornization/news_feeds', [NewsFeedsController::class, 'view']);
        Route::get('/ornization/news_feeds/item/{id}', [NewsFeedsController::class, 'news_feeds']);
        Route::post('/ornization/news_feeds/add', [NewsFeedsController::class, 'create']);
        Route::post('/ornization/news_feeds/update/{id}', [NewsFeedsController::class, 'modify']);
        Route::delete('/ornization/news_feeds/delete/{id}', [NewsFeedsController::class, 'delete']);

        ///////////////////////////////////////////// Notification //////////////////////////////////////////////////

        Route::get('/ornization/noti/view', [NotificationRequestController::class, 'view']);
        Route::get('/ornization/noti/notification_num', [NotificationRequestController::class, 'notification_num']);
        Route::post('/ornization/noti/view_notification', [NotificationRequestController::class, 'view_notification']);
        Route::post('/ornization/noti/view_request/{id}', [NotificationRequestController::class, 'view_request']);

///////////////////////////////////////////// Notification //////////////////////////////////////////////////

        Route::get('/ornization/notification', [NotifictionUserController::class, 'view']);
        Route::get('/ornization/notification/item/{id}', [NotifictionUserController::class, 'notification']);
        Route::post('/ornization/notification/add', [NotifictionUserController::class, 'create']);
        Route::post('/ornization/notification/update/{id}', [NotifictionUserController::class, 'modify']);
        Route::delete('/ornization/notification/delete/{id}', [NotifictionUserController::class, 'delete']);

        ////////////////////////////////////////////////////// Bnyadm /////////////////////////////////////////////////////////

        Route::get('/ornization/project', [ProjectController::class, 'view']);
        Route::get('/ornization/project/item/{id}', [ProjectController::class, 'project']);
        Route::post('/ornization/project/add', [ProjectController::class, 'create']);
        Route::post('/ornization/project/update/{id}', [ProjectController::class, 'modify']);
        Route::delete('/ornization/project/delete/{id}', [ProjectController::class, 'delete']);

        ////////////////////////////////////////////////////// Bnyadm /////////////////////////////////////////////////////////

        Route::get('/ornization/Home', [HomeOrganizationController::class, 'view']);

        Route::get('/ornization/profile', [OrgnizationUserController::class, 'OrnizationPrfile']);

        Route::put('/ornization/profile/update', [OrgnizationUserController::class, 'editOrgnizationProfile']);

        Route::get('/ornization/users', [OrgnizationUserController::class, 'getOrgnizationUsers']);

        Route::get('/ornization/user/{id}', [OrgnizationUserController::class, 'getUser']);

        Route::post('/ornization/user/add', [OrgnizationUserController::class, 'addUser']);

        Route::put('/ornization/user/update/{id}', [OrgnizationUserController::class, 'updateUser']);
        
        Route::delete('/ornization/user/delete/{id}', [OrgnizationUserController::class, 'deleteUser']);

        Route::delete('/ornization/user/deleteGroup', [OrgnizationUserController::class, 'deleteGroup']);

        Route::get('/ornization/task', [OrgnizationTaskController::class, 'getOrgnizationTasks']);

        Route::get('/ornization/task/{id}', [OrgnizationTaskController::class, 'getTaskById']);

        Route::post('/ornization/task/add', [OrgnizationTaskController::class, 'addTask']);

        Route::put('/ornization/task/update/{id}', [OrgnizationTaskController::class, 'updateTask']);

        Route::delete('/ornization/task/delete/{id}', [OrgnizationTaskController::class, 'deleteTask']);

        Route::delete('/ornization/task/deleteGroup', [OrgnizationTaskController::class, 'deleteGroup']);

        Route::get('/ornization/event', [OrgnizationEventController::class, 'getEvents']);

        Route::get('/ornization/event/{id}', [OrgnizationEventController::class, 'getEventById']);

        Route::post('/ornization/event/add', [OrgnizationEventController::class, 'addEvent']);

        Route::put('/ornization/event/update/{id}', [OrgnizationEventController::class, 'updateEvent']);

        Route::delete('/ornization/event/delete/{eventId}', [OrgnizationEventController::class, 'deleteEvent']);
        
        Route::delete('/ornization/event/deleteGroup', [OrgnizationEventController::class, 'deleteGroup']);

        Route::get('/orgnization/getCountry', [OrgnizationLocationController::class, 'GetCountry']);

        Route::get('/orgnization/getCity', [OrgnizationLocationController::class, 'GetCity']);

        Route::get('/orgnization/getZone', [OrgnizationLocationController::class, 'GetZones']);

        //////

        Route::get('/orgnization/request', [RequestController::class, 'getAllRequest']);

        Route::put('/orgnization/request/accept/{id}', [RequestController::class, 'acceptRequest']);

        Route::put('/orgnization/request/reject/{id}', [RequestController::class, 'rejectRequest']);

        Route::put('/orgnization/request/attend/{id}', [RequestController::class, 'attendRequest']);

        Route::put('/orgnization/request/lost/{id}', [RequestController::class, 'lostRequest']);

    //////

        Route::get('/orgnization/getEventDetails/{eventId}', [OrgnizationOperationController::class, 'getEventsDetails']);

        Route::get('/orgnization/getTaskDetails/{taskId}', [OrgnizationOperationController::class, 'getTasksDetails']);

        Route::get('/orgnization/getEventVolunteers/{eventId}', [OrgnizationOperationController::class, 'getEventVolunteers']);

        Route::get('/orgnization/getTaskVolunteers/{taskId}', [OrgnizationOperationController::class, 'getTaskVolunteers']);

        Route::put('/orgnization/changeEventVolunteerStatus/{volunteerId}', [OrgnizationOperationController::class, 'changeEventVolunteerStatus']);

        Route::put('/orgnization/changeTaskVolunteerStatus/{volunteerId}', [OrgnizationOperationController::class, 'changeTaskVolunteerStatus']);

        Route::get('/orgnization/getEventShakawy/{eventId}', [OrgnizationOperationController::class, 'getEventShakwat']);

        Route::get('/orgnization/getTaskShakawy/{taskId}', [OrgnizationOperationController::class, 'getTaskShakwat']);

        Route::get('/orgnization/getEventSuggest/{eventId}', [OrgnizationOperationController::class, 'getEventSuggest']);

        Route::get('/orgnization/getTaskSuggest/{taskId}', [OrgnizationOperationController::class, 'getTaskSuggest']);

        Route::put('/orgnization/readEventSuggest/{eventId}', [OrgnizationOperationController::class, 'readEventSuggest']);

        Route::put('/orgnization/readTaskSuggest/{taskId}', [OrgnizationOperationController::class, 'readTaskSuggest']);

///////

        Route::get('/orgnization/bnyadm', [OrgnizationBnyadmRequstController::class, 'getBnyadmRequstList']);

        Route::get('/orgnization/bnyadm/{id}', [OrgnizationBnyadmRequstController::class, 'getBnyadmRequstDetails']);

        Route::put('/orgnization/bnyadm/accept/{id}', [OrgnizationBnyadmRequstController::class, 'acceptBnyadmRequst']);

        Route::put('/orgnization/bnyadm/reject/{id}', [OrgnizationBnyadmRequstController::class, 'rejectBnyadmRequst']);

        Route::put('/orgnization/bnyadm/acceptGroup', [OrgnizationBnyadmRequstController::class, 'acceptGroup']);

        Route::put('/orgnization/bnyadm/rejectGroup', [OrgnizationBnyadmRequstController::class, 'rejectGroup']);

    });
