<footer class="footer-center">
  <p class="footer-orbiagro">
    orbiagro.com.ve
  </p>

  <p class="footer-enlaces">
    {!! link_to_route('home', 'Inicio') !!}
    {!! link_to_route('makers.index', 'Fabricantes') !!}
    {!! link_to_route('cats.index', 'Categorias') !!}
    {!! link_to_route('subCats.index', 'Rubros') !!}
    {!! link_to_route('products.index', 'Productos') !!}
  </p>

  <p class="footer-slayerfat">
    <a href="https://github.com/slayerfat">
      <i class="fa fa-github"></i> slayerfat
    </a>
    © {{ date('Y') }}
    <br>
    <a href="https://twitter.com/slayerfat">@slayerfat</a>
  </p>
</footer>
