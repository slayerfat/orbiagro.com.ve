// TODO mejor implementacion.
var initBootstrapTable = function(url)
{
  $().bootstrapTable.showUrlBase = url;
  return url;
};

// del url generado por el backend se cambia el recurso (no-data)
// al correcto, segun el seleccionado
$().bootstrapTable.transformUrl = function(resource)
{
  this.showUrl = this.showUrlBase.replace('no-data', resource);

  // console.log('resource: ' + resource + ' this.showUrl: ' + this.showUrl);
  return this.showUrl;
};

// http://wenzhixin.net.cn/p/bootstrap-table/docs/examples.html#table-events

function operateFormatter(value, row, index) {

  // el url con la direccion correcta para laravel
  var url = $().bootstrapTable.transformUrl(row.name.trim());
  // console.log('row.name.trim(): ' + row.name.trim() + ' url: ' + url);

  return [
    '<a class="table-show" href="'+url+'" title="Consultar">',
      '<i class="glyphicon glyphicon-search"></i>',
    '</a>'
  ].join('');
}
