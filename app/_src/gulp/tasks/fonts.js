const {src, dest, series} = require('gulp');
const copy = require('gulp-copy');
const clean = require('gulp-clean');

var config = require('../config').fonts;

function fontsClean(){
    return src(config.dest, {allowEmpty: true})
        .pipe(clean({force: true} ));
}

function fontsTask() {

    return src(config.src)
        .pipe(copy(config.dest, {prefix: 4}));

}

exports.fonts = series(fontsClean,fontsTask);