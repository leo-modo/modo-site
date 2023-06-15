const {src, dest, series} = require('gulp');
const cleaner = require('gulp-clean');
const imagemin = require('gulp-imagemin');

var config = require('../config').images;

function imagesClean() {

    return src(config.dest, {allowEmpty: true})
        .pipe(cleaner({force: true}));

}

function imagesTask() {

    return src(config.src)
        .pipe(imagemin())
        .pipe(dest(config.dest));

}

exports.images = series(imagesClean, imagesTask);

