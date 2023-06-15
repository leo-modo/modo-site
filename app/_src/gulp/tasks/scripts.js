const {src, dest, series} = require('gulp');
const reload = require('require-reload');
const install = require('gulp-install');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
const plumber = require('gulp-plumber');
const babel = require("gulp-babel");
const concat = require('gulp-concat');
const livereload = require('gulp-livereload');

const configBase = require('../config');
const config = configBase.scripts;

function scriptsInstallVendors() {

    return src(configBase.paths.src + '/package.json', {allowEmpty: true})
        .pipe(install());

}

function scriptsVendors() {

    var scriptsmap = reload('../' + config.src.map);
    var vendors = ['glob'];

    // npm dependances
    for (var i in scriptsmap.vendors.npm) {
        vendors.push(configBase.paths.src + '/node_modules/' + scriptsmap.vendors.npm[i]);
    }

    // libs custom dependance
    for (var i in scriptsmap.vendors.libs) {
        vendors.push(config.src.libs + '/' + scriptsmap.vendors.libs[i]);
    }

    return vendors;
}

function scriptsAll() {

    var vendors = scriptsVendors();

    return src(vendors, {allowEmpty: true})
        .pipe(src(config.src.partials, {allowEmpty: true}))
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(babel({presets: [["@babel/env",{modules: false}]]}))
        .pipe(uglify())
        .pipe(concat(config.file))
        .pipe(sourcemaps.write())
        .pipe(dest(config.dest));
        //.pipe(livereload());

}

exports.scripts = series(scriptsInstallVendors, scriptsAll);
exports.scripts.watch = series(scriptsAll);