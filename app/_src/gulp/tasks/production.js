const {src, dest, parallel} = require('gulp');

const clean = require('gulp-clean-css');
const uglify = require('gulp-uglify');

const config = require('../config');

function prodCss() {

    return src(config.sass.prod)
        .pipe(clean())
        .pipe(dest(config.sass.dest));

}

function prodScripts() {

    return src(config.scripts.dest + '/' + config.scripts.file)
        .pipe(uglify({
            sourceMap: false
        }))
        .pipe(dest(config.scripts.dest));

}

exports.production = parallel(prodCss, prodScripts);