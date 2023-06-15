/**
 * SASS
 * Compilation des scss, autoprefixage et cleaner
 */

const {src, dest, series} = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const livereload = require('gulp-livereload');
//const extractMediaQueries = require("gulp-extract-media-queries");

const config = require('../config').sass

// Compile sass //
function sassTask() {

    return src(config.src)
        .pipe(sourcemaps.init())
            .pipe(plumber())
            .pipe(sass())
            .pipe(cleanCSS())
            .pipe(autoprefixer())
        .pipe(sourcemaps.write())
        //.pipe(extractMediaQueries())
        .pipe(dest(config.dest))
        .pipe(livereload());

}

exports.sass = series(sassTask);