    <?php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/clear-cache', function () {
        Artisan::call('config:cache');
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
    });

    Route::get('/', function () {
        if (isset(Auth::user()->id)) {
            return redirect()->route('home');
        } else {
            return redirect()->route('login');
        }
    });

    Auth::routes();
    Route::get('get-product-details/{product_id}', 'CustomizerController@getData')->name('get-product-details');
    Route::get('get-configure/{product_id}', 'CustomizerController@getConfigureData')->name('get-configure');
    Route::get('get-gallery-images/{product_id}', 'CustomizerController@getImagesGallery')->name('get-gallery-images');
    Route::get('get-visibility/{custom_build_id}/{com_id}', 'CustomizerController@getVisibility')->name('get-visibility');

    Route::middleware(['auth.shopify'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');

        //===============Component Categories=================================
        Route::resource('component-categories', ComponentCategoriesController::class);
        Route::post('get-component-category', 'ComponentCategoriesDatatablesController@getData')->name('get.component.category');


        //===============Component============================================
        Route::resource('components', ComponentController::class);
        Route::post('get-components', 'ComponentDatatablesController@getData')->name('get.components');


        //===============Accessories============================================
        Route::resource('accessories', AccessoriesController::class);
        Route::post('get-accessories', 'AccessoriesDatatablesController@getData')->name('get.accessories');

        //===============Accessories Categories============================================
        Route::resource('accessories-categories', AccessoriesCategoriesController::class);
        Route::post('get-accessories-categories', 'AccessoriesCategoriesDatatablesController@getData')->name('get.accessory.category');


        //=============== Promotion ============================================
        Route::resource('promotion', PromotionController::class);
        Route::post('get-promotion', 'PromotionDatatablesController@getData')->name('get.promotion');


        //===============Component Visibility ============================================
        Route::resource('component-visibilites', ComponentVisibilityController::class);
        Route::post('get-component-visiblity', 'ComponentVisibilitesDatatablesController@getData')->name('get.component.visiblity');


        //===============Custom Build Categories ============================================
        Route::resource('custom-build-categories', CustomBuildCategoriesController::class);
        Route::post('get-custom-build-category', 'CustomBuildCategoriesDatatablesController@getData')->name('get.custom.build.category');

        //===============Custom Build============================================
        Route::resource('custom-build', CustomBuildController::class);
        Route::post('get-custom-builds', 'CustomBuildDatatablesController@getData')->name('get.custom-builds');
        Route::get('/restore-default/{cat_id}/{id}', 'CustomBuildDatatablesController@restoreDefault');
        Route::get('/category-restore-default/{cat_id}', 'CustomBuildDatatablesController@categoryRestoreDefault');


        //===============Component Brand ============================================
        Route::resource('component-brand', ComponentBrandController::class);
        Route::post('get-component-brand', 'ComponentBrandDatatablesController@getData')->name('get.component.brand');




        if (!isset(Auth::user()->id)) {
            return view('auth.login');
        }
    });
