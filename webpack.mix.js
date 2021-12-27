let mix = require("laravel-mix");

mix.autoload({
  jQuery: ["$", "window.JQuery", "JQuery"],
});

mix.js("vue-admin/main.js", "assets/admin/js/main.js").vue({ version: 3 });
