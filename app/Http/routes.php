<?php

/**
 * variable para españolificar las rutas
 * @var array
 */
$espanol = ['except' => ['create', 'edit']];

Route::get('/welcome', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::get('usuarios/crear', ['uses' => 'UsersController@create', 'as' => 'usuarios.create']);
Route::get('usuarios/{usuarios}/editar', ['uses' => 'UsersController@edit', 'as' => 'usuarios.edit']);

Route::resource('usuarios', 'UsersController', $espanol);

Route::group(['prefix' => 'usuarios'], function () use ($espanol) {
    // datos personales de un usuario
    Route::get('datos-personales/{usuarios}/crear', ['uses' => 'PeopleController@create', 'as' => 'personas.create']);
    Route::get('datos-personales/{usuarios}/editar', ['uses' => 'PeopleController@edit', 'as' => 'personas.edit']);
    Route::post('datos-personales/{usuarios}', ['uses' => 'PeopleController@store', 'as' => 'personas.store']);
    Route::put('datos-personales/{personas}', ['uses' => 'PeopleController@update', 'as' => 'personas.update']);
    Route::patch('datos-personales/{personas}', ['uses' => 'PeopleController@update', 'as' => 'personas.patch']);
    Route::delete('datos-personales/{personas}', ['uses' => 'PeopleController@destroy', 'as' => 'personas.destroy']);

    // productos de un usuario
    Route::get('{usuarios}/productos', ['uses' => 'UsersController@products', 'as' => 'usuarios.products']);

    // restaura al usuario en la base de datos
    Route::post('{usuarios}/restore', ['uses' => 'UsersController@restore', 'as' => 'usuarios.restore']);

    // muestra al usuario desactivado
    Route::get('eliminados/{usuarios}', ['uses' => 'UsersController@showTrashed', 'as' => 'usuarios.trashed']);

    // elimina el modelo de la base de datos
    Route::delete(
        '{usuarios}/forceDestroy',
        ['uses' => 'UsersController@forceDestroy', 'as' => 'usuarios.forceDestroy']
    );

    // visitas de productos de un usuario
    Route::get(
        '{usuarios}/visitas/productos',
        ['uses' => 'UsersController@productVisits', 'as' => 'usuarios.products.visits']
    );

    // UX de un usuario que quiere eliminar su cuenta
    Route::get(
        '{usuarios}/confirmar-eliminacion',
        ['uses' => 'UsersController@preDestroy', 'as' => 'usuarios.preDestroy']
    );
});

Route::get('productos/crear', ['uses' => 'ProductsController@create', 'as' => 'productos.create']);
Route::get('productos/{productos}/editar', ['uses' => 'ProductsController@edit', 'as' => 'productos.edit']);

// restaura a un producto en la base de datos
Route::post('productos/{productos}/restore', ['uses' => 'ProductsController@restore', 'as' => 'productos.restore']);

// elimina el modelo de la base de datos
Route::delete(
    'productos/{productos}/forceDestroy',
    ['uses' => 'ProductsController@forceDestroy', 'as' => 'productos.forceDestroy']
);

Route::resource('productos', 'ProductsController', $espanol);

// product details
Route::post(
    'productos/details/{productos}',
    ['uses' => 'ProductsController@heroDetails', 'as' => 'productos.details']
);

// encontrar un listado de productos segun su categoria:
Route::get(
    'categorias/{categorias}/productos',
    ['uses' => 'ProductsController@indexByCategory', 'as' => 'productos.category.index']
);

// encontrar un listado de productos segun su rubro:
Route::get(
    'rubros/{rubros}/productos',
    [
        'uses' => 'ProductsController@indexBySubCategory',
        'as'   => 'productos.subcategory.index'
    ]
);

// modelos asociados a producto
Route::group(['prefix' => 'productos', 'middleware' => 'auth'], function () {
    // features
    Route::get('/{productos}/distintivos/crear', 'FeaturesController@create');
    Route::post('/{productos}/distintivos', 'FeaturesController@store');
    Route::get('/distintivos/{features}/editar', 'FeaturesController@edit');
    Route::put('/distintivos/{features}', 'FeaturesController@update');
    Route::patch('/distintivos/{features}', 'FeaturesController@update');
    Route::delete('/distintivos/{features}', 'FeaturesController@destroy');

    // mechanical info
    // Route::get('/{productos}/info-mecanica/crear', 'MechanicalInfoController@create');
    Route::get(
        '/{productos}/info-mecanica/crear',
        [
            'uses' => 'RelatedProductModelsController@createMechInfo',
            'as'   => 'products.mechanicals.create'
        ]
    );

    Route::post(
        '/{productos}/info-mecanica',
        [
            'uses' => 'RelatedProductModelsController@storeMechInfo',
            'as'   => 'products.mechanicals.store'
        ]
    );

    Route::get('/info-mecanica/{mechanicals}/editar', 'MechanicalInfoController@edit');
    Route::put('/info-mecanica/{mechanicals}', 'MechanicalInfoController@update');
    Route::patch('/info-mecanica/{mechanicals}', 'MechanicalInfoController@update');
    Route::delete('/info-mecanica/{mechanicals}', 'MechanicalInfoController@destroy');

    // characteristics
    // Route::get('/{productos}/caracteristicas/crear', 'CharacteristicsController@create');
    Route::get(
        '/{productos}/caracteristicas/crear',
        [
            'uses' => 'RelatedProductModelsController@createCharacteristic',
            'as'   => 'products.characteristics.create'
        ]
    );

    Route::post(
        '/{productos}/caracteristicas',
        [
            'uses' => 'RelatedProductModelsController@storeCharacteristic',
            'as'   => 'products.characteristics.store'
        ]
    );

    Route::get('/caracteristicas/{mechanicals}/editar', 'CharacteristicsController@edit');
    Route::put('/caracteristicas/{mechanicals}', 'CharacteristicsController@update');
    Route::patch('/caracteristicas/{mechanicals}', 'CharacteristicsController@update');
    Route::delete('/caracteristicas/{mechanicals}', 'CharacteristicsController@destroy');

    // nutritional
    // Route::get('/{productos}/valores-nutricionales/crear', 'NutritionalsController@create');

    Route::get(
        '/{productos}/valores-nutricionales/crear',
        [
            'uses' => 'RelatedProductModelsController@createNutritional',
            'as'   => 'products.nutritionals.create'
        ]
    );

    Route::post(
        '/{productos}/valores-nutricionales',
        [
            'uses' => 'RelatedProductModelsController@storeNutritional',
            'as'   => 'products.nutritionals.store'
        ]
    );

    Route::get('/valores-nutricionales/{mechanicals}/editar', 'NutritionalsController@edit');
    Route::put('/valores-nutricionales/{mechanicals}', 'NutritionalsController@update');
    Route::patch('/valores-nutricionales/{mechanicals}', 'NutritionalsController@update');
    Route::delete('/valores-nutricionales/{mechanicals}', 'NutritionalsController@destroy');

    // providers
    Route::get('/{productos}/proveedores/crear', 'ProductsProvidersController@create');
    Route::post('/{productos}/proveedores', 'ProductsProvidersController@store');
    Route::get('/proveedores/{productos}/{proveedores}/editar', 'ProductsProvidersController@edit');
    Route::put('/proveedores/{productos}/{proveedores}', 'ProductsProvidersController@update');
    Route::patch('/proveedores/{productos}/{proveedores}', 'ProductsProvidersController@update');
    Route::delete('/proveedores/{productos}/{proveedoresNombre}', 'ProductsProvidersController@destroy');

    // images
    Route::get(
        '/{productos}/imagenes/crear',
        ['uses' => 'ImagesController@createProduct', 'as' => 'product.imagenes.create']
    );
    Route::post('/{productos}/imagenes', ['uses' => 'ImagesController@storeProduct', 'as' => 'product.imagenes.store']);
});

Route::get('categorias/crear', ['uses' => 'CategoriesController@create', 'as' => 'categorias.create']);
Route::get('categorias/{categorias}/editar', ['uses' => 'CategoriesController@edit', 'as' => 'categorias.edit']);
Route::resource('categorias', 'CategoriesController', $espanol);

Route::get('rubros/crear', ['uses' => 'SubCategoriesController@create', 'as' => 'rubros.create']);
Route::get('rubros/{rubros}/editar', ['uses' => 'SubCategoriesController@edit', 'as' => 'rubros.edit']);
Route::resource('rubros', 'SubCategoriesController', $espanol);

// encontrar un listado de rubros segun su categoria:
Route::get(
    'categorias/{categorias}/rubros',
    ['uses' => 'SubCategoriesController@indexByCategory', 'as' => 'rubros.category.index']
);

Route::get('fabricantes/crear', ['uses' => 'MakersController@create', 'as' => 'fabricantes.create']);
Route::get('fabricantes/{fabricantes}/editar', ['uses' => 'MakersController@edit', 'as' => 'fabricantes.edit']);
Route::resource('fabricantes', 'MakersController', $espanol);

Route::get('perfiles/crear', ['uses' => 'ProfilesController@create', 'as' => 'perfiles.create']);
Route::get('perfiles/{perfiles}/editar', ['uses' => 'ProfilesController@edit', 'as' => 'perfiles.edit']);
Route::resource('perfiles', 'ProfilesController', $espanol);

Route::get('proveedores/crear', ['uses' => 'ProvidersController@create', 'as' => 'proveedores.create']);
Route::get('proveedores/{proveedores}/editar', ['uses' => 'ProvidersController@edit', 'as' => 'proveedores.edit']);
Route::resource('proveedores', 'ProvidersController', $espanol);

Route::get('imagenes/{imagenes}/editar', ['uses' => 'ImagesController@edit', 'as' => 'imagenes.edit']);
Route::resource('imagenes', 'ImagesController', ['only' => ['update', 'destroy']]);

Route::group(['middleware' => 'user.verified'], function () {
    // usuario por verificar
    Route::get('/por-verificar', 'HomeController@unverified');
    // para generar confirmaciones de usuario
    Route::get('/generar-confirmacion', 'ConfirmationsController@generateConfirm');
    Route::get('/confirmar/{string}', 'ConfirmationsController@confirm');
});

Route::get('home', function () {
    return redirect('/');
});

// para ajax de direcciones
Route::group(['middleware' => 'auth'], function () {
    Route::get('/estados', 'DirectionsController@states');
    Route::get('/municipios/{id}', 'DirectionsController@towns');
    Route::get('/municipio/{id}', 'DirectionsController@town');
    Route::get('/parroquias/{id}', 'DirectionsController@parishes');
    Route::get('/parroquia/{id}', 'DirectionsController@parish');
});

Route::resource('promociones', 'PromotionsController');

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
