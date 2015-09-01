var startEditor = function(target, mode){
  CKEDITOR.config.allowedContent = false;

  CKEDITOR.config.disallowedContent = 'script; *[on*]';

  if (mode == 'replace') {
    CKEDITOR.config.height='450px';

    CKEDITOR.replace(target, {
      language: 'es',
    });
  }

  if (mode == 'inline') {
    CKEDITOR.inline(target, {
      language: 'es',
    });
  }
};
