const {src, dest, series} = require('gulp');
const clean = require('gulp-clean');
const iconfont = require('gulp-iconfont');
const iconfontCss = require('gulp-iconfont-css');
const spritesmith = require('gulp.spritesmith');
const merge = require('merge-stream');

var configBase = require('../config');
var config = configBase.icons;

function iconsClean() {

    return src(config.dest, {allowEmpty: true})
        .pipe(clean({force: true}));

}


function iconsFont() {

    var runTimestamp = Math.round(Date.now() / 1000);

    return src(config.font.src, {allowEmpty: true})
        .pipe(iconfontCss({
            fontName: config.font.fontName,
            path: config.font.template,
            targetPath: '_iconsfont.scss',
            fontPath: config.font.fontPath,
            cssClass: config.font.className
        }))
        .pipe(iconfont({
            fontName: config.font.fontName,
            centerHorizontally: true,
            normalize: true,
            formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
            timestamp: runTimestamp
        }))
        .pipe(dest(config.font.dest));

}

function iconsFontCss() {

    var deplace = src(config.font.dest + '/_iconsfont.scss', {allowEmpty: true})
        .pipe(dest(config.font.scss))

    var cleaner = src(config.font.dest + '/_iconsfont.scss', {allowEmpty: true})
        .pipe(clean({force: true}));

    return merge(deplace, cleaner);

}

function iconsImg() {

    var spriteData = src(config.img.src, {allowEmpty: true})
        .pipe(spritesmith({
            imgName: config.img.imgName,
            imgPath: config.img.imgPath,
            cssName: config.img.cssName
        }));

    var imgStream = spriteData.img
        .pipe(dest(config.img.dest));

    var cssStream = spriteData.css
        .pipe(dest(config.img.cssPath));

    return merge(imgStream, cssStream);

}

exports.icons = series(iconsClean, iconsFont, iconsFontCss, iconsImg);