const {series, parallel} = require('gulp');

const iconsTask = require('./tasks/icons');
const sassTask = require('./tasks/sass');
const imagesTask = require('./tasks/images');
const scriptsTask = require('./tasks/scripts');
const fontsTask = require('./tasks/fonts');
const watchTask = require('./tasks/watch');
const productionTask = require('./tasks/production');

exports.default = series(parallel(series(iconsTask.icons, sassTask.sass), scriptsTask.scripts, imagesTask.images, fontsTask.fonts), watchTask.watch);
exports.production = series(iconsTask.icons, sassTask.sass, scriptsTask.scripts, imagesTask.images, fontsTask.fonts, productionTask.production);