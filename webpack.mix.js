let mix = require("laravel-mix");

mix.autoload({
  jquery: ["$", "window.jQuery", "jQuery"],
});

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.mjs$/,
        resolve: { fullySpecified: false },
        include: /node_modules/,
        type: "javascript/auto",
      },
    ],
  },
});

mix.js("vue-admin/main.js", "assets/admin/js/main.js").vue({ version: 3 });
