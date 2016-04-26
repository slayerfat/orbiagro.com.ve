<?php

Route::group(['middleware' => ['web']], function () {
    // rutas de logeo, el resto de estas rutas estan deshabilitadas
    // para rehabilitarlas, invocar el metodo auth dentro de Route.
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    Route::get('/welcome', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
    Route::get('/', ['as' => '/', 'uses' => 'HomeController@index']);
    Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

    // Ajax de Direcciones
    Route::get(
        '/direcciones/estados',
        [
            'as' => 'api.states.index',
            'uses' => 'DirectionsController@states',
            'middleware' => 'auth',
        ]
    );

    Route::get(
        '/direcciones/estados/{states}/municipios',
        [
            'as' => 'api.states.towns.index',
            'uses' => 'DirectionsController@towns',
            'middleware' => 'auth',
        ]
    );

    Route::get(
        '/direcciones/municipios/{towns}',
        [
            'as' => 'api.towns.show',
            'uses' => 'DirectionsController@town',
            'middleware' => 'auth',
        ]
    );

    Route::get(
        '/direcciones/municipios/{towns}/parroquias',
        [
            'as' => '',
            'uses' => 'DirectionsController@parishes',
            'middleware' => 'auth',
        ]
    );

    Route::get(
        '/direcciones/parroquias/{parishes}',
        [
            'as' => 'api.parishes.show',
            'uses' => 'DirectionsController@parish',
            'middleware' => 'auth',
        ]
    );

    // usuario por verificar
    Route::get(
        '/usuarios/por-verificar',
        [
            'as' => 'users.unverified',
            'uses' => 'HomeController@unverified',
            'middleware' => 'user.verified',
        ]
    );

    // para generar confirmaciones de usuario
    Route::get(
        '/usuarios/generar-confirmacion',
        [
            'as' => 'users.confirmations.create',
            'uses' => 'ConfirmationsController@createConfirm',
            'middleware' => 'user.verified',
        ]
    );

    // para generar confirmaciones de usuario
    Route::get(
        '/usuarios/confirmar/{string}',
        [
            'as' => 'users.confirmations.confirm',
            'uses' => 'ConfirmationsController@confirm',
            'middleware' => 'user.verified',
        ]
    );

    // usuarios
    Route::get(
        '/usuarios',
        ['as' => 'users.index', 'uses' => 'UsersController@index']
    );

    Route::get(
        '/usuarios/crear',
        ['as' => 'users.create', 'uses' => 'UsersController@create']
    );

    Route::post(
        '/usuarios',
        ['as' => 'users.store', 'uses' => 'UsersController@store']
    );

    Route::get(
        '/usuarios/{users}',
        ['as' => 'users.show', 'uses' => 'UsersController@show']
    );

    Route::get(
        '/usuarios/{users}/editar',
        ['as' => 'users.edit', 'uses' => 'UsersController@edit']
    );

    Route::patch(
        '/usuarios/{users}',
        ['as' => 'users.update', 'uses' => 'UsersController@update']
    );

    Route::delete(
        '/usuarios/{users}',
        ['as' => 'users.destroy', 'uses' => 'UsersController@destroy']
    );

    // Usuarios Eliminados
    Route::get(
        'usuarios/eliminados/{users}',
        ['as' => 'users.trashed', 'uses' => 'UsersController@showTrashed']
    );

    // Productos de un usuario
    Route::get(
        'usuarios/{users}/productos',
        ['as' => 'users.products', 'uses' => 'UsersController@products']
    );

    // restaura al usuario en la base de datos
    Route::post(
        'usuarios/{users}/restaurar',
        ['as' => 'users.restore', 'uses' => 'UsersController@restore']
    );

    // UX de un usuario que quiere eliminar su cuenta
    // TODO mejorar esto
    Route::get(
        'usuarios/{users}/confirmar-eliminacion',
        ['as' => 'users.destroy.pre', 'uses' => 'UsersController@preDestroy']
    );

    // Eliminar usuarios de DB
    Route::delete(
        'usuarios/{users}/forceDestroy',
        ['as' => 'users.destroy.forced', 'uses' => 'UsersController@forceDestroy']
    );

    // Visitas de productos de un usuario
    Route::get(
        'usuarios/{users}/visitas/productos',
        ['as' => 'users.products.visits', 'uses' => 'UsersController@productVisits']
    );

    // datos personales
    Route::get(
        '/usuarios/datos-personales',
        ['as' => 'users.people.index', 'uses' => 'PeopleController@index']
    );

    Route::get(
        'usuarios/datos-personales/{usuarios}/crear',
        ['as' => 'users.people.create', 'uses' => 'PeopleController@create']
    );

    Route::post(
        'usuarios/datos-personales/{usuarios}',
        ['as' => 'users.people.store', 'uses' => 'PeopleController@store']
    );

    Route::get(
        'usuarios/datos-personales/{usuarios}/editar',
        ['as' => 'users.people.edit', 'uses' => 'PeopleController@edit']
    );

    Route::patch(
        '/usuarios/datos-personales/{people}',
        ['as' => 'users.people.update', 'uses' => 'PeopleController@update']
    );

    Route::delete(
        '/usuarios/datos-personales/{people}',
        ['as' => 'users.people.destroy', 'uses' => 'PeopleController@destroy']
    );

    // productos
    Route::get(
        '/productos',
        ['as' => 'products.index', 'uses' => 'ProductsController@index']
    );

    Route::get(
        '/productos/crear',
        ['as' => 'products.create', 'uses' => 'ProductsController@create']
    );

    Route::post(
        '/productos',
        ['as' => 'products.store', 'uses' => 'ProductsController@store']
    );

    Route::get(
        '/productos/{products}',
        ['as' => 'products.show', 'uses' => 'ProductsController@show']
    );

    Route::get(
        '/productos/{products}/editar',
        ['as' => 'products.edit', 'uses' => 'ProductsController@edit']
    );

    Route::patch(
        '/productos/{products}',
        ['as' => 'products.update', 'uses' => 'ProductsController@update']
    );

    Route::delete(
        '/productos/{products}',
        ['as' => 'products.destroy', 'uses' => 'ProductsController@destroy']
    );

    // features
    Route::get(
        '/productos/distintivos/{features}/editar',
        [
            'as' => 'products.features.edit',
            'uses' => 'FeaturesController@edit',
            'middleware' => 'auth'
        ]
    );

    Route::patch(
        '/productos/distintivos/{features}',
        [
            'as' => 'products.features.update',
            'uses' => 'FeaturesController@update',
            'middleware' => 'auth'
        ]
    );

    Route::delete(
        '/productos/distintivos/{features}',
        [
            'as' => 'products.features.destroy',
            'uses' => 'FeaturesController@destroy',
            'middleware' => 'auth'
        ]
    );

    // restaura a un producto en la base de datos
    Route::post(
        '/productos/{products}/restore',
        [
            'as' => 'products.restore',
            'uses' => 'ProductsController@restore',
        ]
    );

    // destruye a un producto en la base de datos
    Route::delete(
        '/productos/{products}/forceDestroy',
        [
            'as' => 'products.destroy.force',
            'uses' => 'ProductsController@forceDestroy',
        ]
    );

    // heroDetails de un Producto.
    Route::post(
        '/productos/details/{products}',
        [
            'as' => 'products.details',
            'uses' => 'ProductsController@heroDetails',
        ]
    );

    // encontrar un listado de productos segun su categoria
    Route::get(
        '/categorias/{cats}/productos',
        [
            'as' => 'products.cats.index',
            'uses' => 'ProductsController@indexByCategory',
        ]
    );

    // encontrar un listado de productos segun su rubro
    Route::get(
        '/rubros/{subcats}/productos',
        [
            'as' => 'products.subcats.index',
            'uses' => 'ProductsController@indexBySubCategory',
        ]
    );

    // MechanicalInfo
    Route::get(
        '/productos/{products}/info-mecanica/crear',
        [
            'as' => 'products.mechanicals.create',
            'uses' => 'RelatedProductModelsController@createMechInfo',
        ]
    );

    Route::post(
        '/productos/{products}/info-mecanica',
        [
            'as' => 'products.mechanicals.store',
            'uses' => 'RelatedProductModelsController@storeMechInfo',
        ]
    );

    Route::get(
        '/productos/info-mecanica/{mechanicals}/editar',
        [
            'as' => 'products.mechanicals.edit',
            'uses' => 'RelatedProductModelsController@editMechInfo',
        ]
    );

    Route::patch(
        '/productos/info-mecanica/{mechanicals}',
        [
            'as' => 'products.mechanicals.update',
            'uses' => 'RelatedProductModelsController@updateMechInfo',
        ]
    );

    // Characteristics
    Route::get(
        'productos/{products}/caracteristicas/crear',
        [
            'as' => 'products.characteristics.create',
            'uses' => 'RelatedProductModelsController@createCharacteristic',
        ]
    );

    Route::post(
        '/productos/{products}/caracteristicas',
        [
            'as' => 'products.characteristics.store',
            'uses' => 'RelatedProductModelsController@storeCharacteristic',
        ]
    );

    Route::get(
        '/productos/caracteristicas/{characteristics}/editar',
        [
            'as' => 'products.characteristics.edit',
            'uses' => 'RelatedProductModelsController@editCharacteristic',
        ]
    );

    Route::patch(
        '/productos/caracteristicas/{characteristics}',
        [
            'as' => 'products.characteristics.update',
            'uses' => 'RelatedProductModelsController@updateCharacteristic',
        ]
    );

    // Nutritional
    Route::get(
        '/productos/{products}/valores-nutricionales/crear',
        [
            'as' => 'products.nutritionals.create',
            'uses' => 'RelatedProductModelsController@createNutritional',
        ]
    );

    Route::post(
        '/productos/{products}/valores-nutricionales',
        [
            'as' => 'products.nutritionals.store',
            'uses' => 'RelatedProductModelsController@storeNutritional',
        ]
    );

    Route::get(
        '/productos/valores-nutricionales/{nutritionals}/editar',
        [
            'as' => 'products.nutritionals.edit',
            'uses' => 'RelatedProductModelsController@editNutritional',
        ]
    );

    Route::patch(
        '/productos/valores-nutricionales/{nutritionals}',
        [
            'as' => 'products.nutritionals.update',
            'uses' => 'RelatedProductModelsController@updateNutritional',
        ]
    );

    // Providers
    Route::get(
        '/productos/{products}/proveedores/crear',
        [
            'as' => 'products.providers.create',
            'uses' => 'ProductsProvidersController@create',
        ]
    );

    Route::post(
        '/productos/{products}/proveedores',
        [
            'as' => 'products.providers.store',
            'uses' => 'ProductsProvidersController@store',
        ]
    );

    Route::get(
        '/productos/proveedores/{products}/{providers}/editar',
        [
            'as' => 'products.providers.edit',
            'uses' => 'ProductsProvidersController@edit',
        ]
    );

    Route::patch(
        '/productos/proveedores/{products}/{providers}',
        [
            'as' => 'products.providers.update',
            'uses' => 'ProductsProvidersController@update',
        ]
    );

    Route::delete(
        '/productos/proveedores/{products}/{providers}',
        [
            'as' => 'products.providers.destroy',
            'uses' => 'ProductsProvidersController@destroy',
        ]
    );

    // Imagenes
    Route::get(
        '/productos/{productos}/imagenes/crear',
        [
            'as' => 'products.images.create',
            'uses' => 'ImagesController@createProduct',
        ]
    );

    Route::post(
        '/productos/{productos}/imagenes',
        [
            'as' => 'products.images.store',
            'uses' => 'ImagesController@storeProduct',
        ]
    );

    // Feature Create/Store
    Route::get(
        '/productos/{products}/distintivos/crear',
        [
            'as' => 'products.features.create',
            'uses' => 'FeaturesController@create',
            'middleware' => 'auth',
        ]
    );

    Route::post(
        '/productos/{products}/distintivos',
        [
            'as' => 'products.features.store',
            'uses' => 'FeaturesController@store',
            'middleware' => 'auth',
        ]
    );

    // Category
    Route::get(
        '/categorias',
        ['as' => 'cats.index', 'uses' => 'CategoriesController@index']
    );

    Route::get(
        '/categorias/crear',
        ['as' => 'cats.create', 'uses' => 'CategoriesController@create']
    );

    Route::post(
        '/categorias',
        ['as' => 'cats.store', 'uses' => 'CategoriesController@store']
    );

    Route::get(
        '/categorias/{cats}',
        ['as' => 'cats.show', 'uses' => 'CategoriesController@show']
    );

    Route::get(
        '/categorias/{cats}/editar',
        ['as' => 'cats.edit', 'uses' => 'CategoriesController@edit']
    );

    Route::patch(
        '/categorias/{cats}',
        ['as' => 'cats.update', 'uses' => 'CategoriesController@update']
    );

    Route::delete(
        '/categorias/{cats}',
        ['as' => 'cats.destroy', 'uses' => 'CategoriesController@destroy']
    );

    // listado de rubros segun su categoria
    Route::get(
        '/categorias/{categorias}/rubros',
        ['as' => 'cats.subCats.index', 'uses' => 'SubCategoriesController@indexByCategory']
    );

    // SubCategory
    Route::get(
        '/rubros',
        ['as' => 'subCats.index', 'uses' => 'SubCategoriesController@index']
    );

    Route::get(
        '/rubros/crear',
        ['as' => 'subCats.create', 'uses' => 'SubCategoriesController@create']
    );

    Route::post(
        '/rubros',
        ['as' => 'subCats.store', 'uses' => 'SubCategoriesController@store']
    );

    Route::get(
        '/rubros/{subCats}',
        ['as' => 'subCats.show', 'uses' => 'SubCategoriesController@show']
    );

    Route::get(
        '/rubros/{subCats}/editar',
        ['as' => 'subCats.edit', 'uses' => 'SubCategoriesController@edit']
    );

    Route::patch(
        '/rubros/{subCats}',
        ['as' => 'subCats.update', 'uses' => 'SubCategoriesController@update']
    );

    Route::delete(
        '/rubros/{subCats}',
        ['as' => 'subCats.destroy', 'uses' => 'SubCategoriesController@destroy']
    );

    // Makers
    Route::get(
        '/fabricantes',
        ['as' => 'makers.index', 'uses' => 'MakersController@index']
    );

    Route::get(
        '/fabricantes/crear',
        ['as' => 'makers.create', 'uses' => 'MakersController@create']
    );

    Route::post(
        '/fabricantes',
        ['as' => 'makers.store', 'uses' => 'MakersController@store']
    );

    Route::get(
        '/fabricantes/{makers}',
        ['as' => 'makers.show', 'uses' => 'MakersController@show']
    );

    Route::get(
        '/fabricantes/{makers}/editar',
        ['as' => 'makers.edit', 'uses' => 'MakersController@edit']
    );

    Route::patch(
        '/fabricantes/{makers}',
        ['as' => 'makers.update', 'uses' => 'MakersController@update']
    );

    Route::delete(
        '/fabricantes/{makers}',
        ['as' => 'makers.destroy', 'uses' => 'MakersController@destroy']
    );

    // Profiles
    Route::get(
        '/perfiles',
        ['as' => 'profiles.index', 'uses' => 'ProfilesController@index']
    );

    Route::get(
        '/perfiles/crear',
        ['as' => 'profiles.create', 'uses' => 'ProfilesController@create']
    );

    Route::post(
        '/perfiles',
        ['as' => 'profiles.store', 'uses' => 'ProfilesController@store']
    );

    Route::get(
        '/perfiles/{profiles}',
        ['as' => 'profiles.show', 'uses' => 'ProfilesController@show']
    );

    Route::get(
        '/perfiles/{profiles}/editar',
        ['as' => 'profiles.edit', 'uses' => 'ProfilesController@edit']
    );

    Route::patch(
        '/perfiles/{profiles}',
        ['as' => 'profiles.update', 'uses' => 'ProfilesController@update']
    );

    Route::delete(
        '/perfiles/{profiles}',
        ['as' => 'profiles.destroy', 'uses' => 'ProfilesController@destroy']
    );

    // Provider
    Route::get(
        '/proveedores',
        ['as' => 'providers.index', 'uses' => 'ProvidersController@index']
    );

    Route::get(
        '/proveedores/crear',
        ['as' => 'providers.create', 'uses' => 'ProvidersController@create']
    );

    Route::post(
        '/proveedores',
        ['as' => 'providers.store', 'uses' => 'ProvidersController@store']
    );

    Route::get(
        '/proveedores/{providers}',
        ['as' => 'providers.show', 'uses' => 'ProvidersController@show']
    );

    Route::get(
        '/proveedores/{providers}/editar',
        ['as' => 'providers.edit', 'uses' => 'ProvidersController@edit']
    );

    Route::patch(
        '/proveedores/{providers}',
        ['as' => 'providers.update', 'uses' => 'ProvidersController@update']
    );

    Route::delete(
        '/proveedores/{providers}',
        ['as' => 'providers.destroy', 'uses' => 'ProvidersController@destroy']
    );

    // Image
    Route::get(
        '/imagenes/{images}/editar',
        ['as' => 'images.edit', 'uses' => 'ImagesController@edit']
    );

    Route::patch(
        '/imagenes/{images}',
        ['as' => 'images.update', 'uses' => 'ImagesController@update']
    );

    Route::delete(
        '/imagenes/{images}',
        ['as' => 'images.destroy', 'uses' => 'ImagesController@destroy']
    );

    // Promotions
    Route::get(
        '/promociones',
        ['as' => 'promotions.index', 'uses' => 'PromotionsController@index']
    );

    Route::get(
        '/promociones/crear',
        ['as' => 'promotions.create', 'uses' => 'PromotionsController@create']
    );

    Route::post(
        '/promociones',
        ['as' => 'promotions.store', 'uses' => 'PromotionsController@store']
    );

    Route::get(
        '/promociones/{promotions}',
        ['as' => 'promotions.show', 'uses' => 'PromotionsController@show']
    );

    Route::get(
        '/promociones/{promotions}/editar',
        ['as' => 'promotions.edit', 'uses' => 'PromotionsController@edit']
    );

    Route::patch(
        '/promociones/{promotions}',
        ['as' => 'promotions.update', 'uses' => 'PromotionsController@update']
    );

    Route::delete(
        '/promociones/{promotions}',
        ['as' => 'promotions.destroy', 'uses' => 'PromotionsController@destroy']
    );

    // QuantityTypes
    Route::get(
        '/tipos-cantidad',
        ['as' => 'quantityTypes.index', 'uses' => 'QuantityTypesController@index']
    );

    Route::get(
        '/tipos-cantidad/crear',
        ['as' => 'quantityTypes.create', 'uses' => 'QuantityTypesController@create']
    );

    Route::post(
        '/tipos-cantidad',
        ['as' => 'quantityTypes.store', 'uses' => 'QuantityTypesController@store']
    );

    Route::get(
        '/tipos-cantidad/{quantityTypes}',
        ['as' => 'quantityTypes.show', 'uses' => 'QuantityTypesController@show']
    );

    Route::get(
        '/tipos-cantidad/{quantityTypes}/editar',
        ['as' => 'quantityTypes.edit', 'uses' => 'QuantityTypesController@edit']
    );

    Route::patch(
        '/tipos-cantidad/{quantityTypes}',
        ['as' => 'quantityTypes.update', 'uses' => 'QuantityTypesController@update']
    );

    Route::delete(
        '/tipos-cantidad/{quantityTypes}',
        ['as' => 'quantityTypes.destroy', 'uses' => 'QuantityTypesController@destroy']
    );
});
