const { series, watch } = require('gulp');
const livereload = require('gulp-livereload');

const config = require('../config');
const sassTask = require('./sass');
const iconsTask = require('./icons');
const imagesTask = require('./images');
const scriptsTask = require('./scripts');
const fontsTask = require('./fonts');

function watchTask(){

    watch(config.scripts.watch.libs, scriptsTask.scripts.watch);
    watch(config.scripts.watch.partials, scriptsTask.scripts.watch);
    watch(config.scripts.watch.map, scriptsTask.scripts.watch);

    livereload.listen();

    watch(config.sass.watch, sassTask.sass);
    watch(config.icons.font.watch, series(iconsTask.icons, sassTask.sass));
    watch(config.icons.img.watch, series(iconsTask.icons, sassTask.sass));
    watch(config.images.watch, imagesTask.images);
    watch(config.fonts.watch, fontsTask.fonts);

};

exports.watch = series(watchTask);