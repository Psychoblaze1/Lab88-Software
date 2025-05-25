<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetChainController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\LimitSuiteController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SamplePointController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TestStandardController;
use App\Http\Controllers\TestParameterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestParameterCategoryController;

// Public Routes
Route::post('login', [UserController::class, 'login']);
Route::get('validate-token', [UserController::class, 'validateToken']);

// Authenticated Routes
// toDo: setup middleware to always check by account_id / accessible accounts
Route::middleware('auth:sanctum')->group(function () {

    // Accounts
    Route::get('/accounts', [AccountController::class, 'getAccounts']);

    // Assets
    Route::get('/assets', [AssetController::class, 'getAssets']);
    Route::get('/assets-by-account/{id}', [AssetController::class, 'getAssetsByAccount']);
    Route::get('/assets-by-site/{id}', [AssetController::class, 'getAssetsBySite']);

    // Asset Chain
    Route::get('/assetChain', [AssetChainController::class, 'getAssetChain']);
    Route::get('/sample-points', [AssetChainController::class, 'getSamplePoints']);

    // Components
    Route::get('/components', [ComponentController::class, 'getComponents']);

    // Instruments
    Route::get('/instruments', [InstrumentController::class, 'getInstruments']);
    Route::post('/upload/instrument-files', [InstrumentController::class, 'handleFiles']);

    // Labs
    Route::get('/labs', [LabController::class, 'getLabs']);

    // Limit Suites
    Route::get('/limit-suites', [LimitSuiteController::class, 'getLimitSuites']);

    // Logout
    Route::get('/logout', [UserController::class, 'logout']);

    // Samples
    Route::get('/samples', [SampleController::class, 'getSamples']);
    Route::get('/sample/{id}', [SampleController::class, 'getSample']);
    Route::post('/sample/delete', [SampleController::class, 'deleteSample']);

    Route::get('/sample/{id}/validate', [SampleController::class, 'getResultsToValidate']);

    // Sample Steps
    Route::post('/sample/register', [SampleController::class, 'registerSample']);
    Route::post('/sample/receive', [SampleController::class, 'receiveSample']);
    Route::post('/sample/prepare', [SampleController::class, 'prepareSample']);
    Route::post('/sample/test', [SampleController::class, 'testSample']);
    Route::post('/sample/validate', [SampleController::class, 'validateSample']);

    // Sample Points
    // Route::get('/sample-points', [SamplePointController::class, 'getSamplePoints']);
    Route::get('/sample-points', [AssetChainController::class, 'getSamplePoints']);

    // Sites
    Route::get('/sites', [SiteController::class, 'getSites']);
    Route::get('/sites-by-account/{id}', [SiteController::class, 'getSitesByAccount']);

    // TestParameters
    Route::get('/test-parameters', [TestParameterController::class, 'getTestParameters']);
    Route::get('/test-parameter-categories', [TestParameterController::class, 'getTestParameterCategories']);

    // TestStandards
    Route::get('/test-standards', [TestStandardController::class, 'getTestStandards']);
});
