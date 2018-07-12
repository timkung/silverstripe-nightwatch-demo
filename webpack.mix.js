let mix = require('laravel-mix');

mix.sass(
  'themes/base/src/scss/main.scss',
  'themes/base/dist',
  {
    includePaths: ['node_modules/']
  }
);

mix.options({
  processCssUrls: false,
});

if (!mix.inProduction()) {
  mix.sourceMaps();
}
