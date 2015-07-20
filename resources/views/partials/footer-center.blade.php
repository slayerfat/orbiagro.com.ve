<footer class="footer-center">
  <p class="footer-orbiagro">
    orbiagro.com.ve
  </p>

  <p class="footer-enlaces">
    {!! link_to_action('HomeController@index', 'Inicio') !!}
    {!! link_to_action('MakersController@index', 'Fabricantes') !!}
    {!! link_to_action('CategoriesController@index', 'Categorias') !!}
    {!! link_to_action('SubCategoriesController@index', 'Rubros') !!}
    {!! link_to_action('ProductsController@index', 'Productos') !!}
  </p>

  <p class="footer-orbiagro">slayerfat © 2015</p>
</footer>
