var themePath = '../../public/wp-content/themes/modo';

var srcAssets = '../assets';
var destAssets = themePath + '/assets';

module.exports = {

    paths: {
        base: themePath,
        src: srcAssets,
        dest: destAssets,
    },

    sass: {
        src: srcAssets + '/scss/*.scss',
        dest: destAssets + '/css',
        watch: srcAssets + '/scss/**/*.scss',
        prod: destAssets + '/css/*.css',
    },

    scripts: {
        src: {
            base: srcAssets + '/js',
            partials: srcAssets + '/js/partials/**/*.js',
            libs: srcAssets + '/js/libs',
            map: srcAssets + '/js/scriptsmap.js'
        },
        dest: destAssets + '/js',
        file: 'app.js',
        watch: {
            partials: srcAssets + '/js/partials/**/*.js',
            libs: srcAssets + '/js/libs/**/*.js',
            map: srcAssets + '/js/scriptsmap.js'
        }
    },

    images: {
        src: srcAssets + '/img/**/*',
        dest: destAssets + '/img',
        watch: srcAssets + '/img/**/*'
    },

    icons: {
        dest: destAssets + '/icons',

        font: {
            src: srcAssets + '/icons/font/*.svg',
            dest: destAssets + '/icons/font',
            watch: srcAssets + '/icons/font/*.svg',
            scss: srcAssets + '/scss/abstracts',
            template: 'templates/_iconsfont.scss',
            fontPath: '../icons/font/',
            fontName: 'iconsfont',
            className: 'icons'
        },

        img: {
            src: srcAssets + '/icons/img/**/*',
            dest: destAssets + '/icons/img',
            watch: srcAssets + '/icons/img/**/*',
            cssName: '_iconsimg.scss',
            imgName: 'iconsimg.png',
            cssPath: srcAssets + '/scss/abstracts',
            imgPath: '../icons/img/iconsimg.png'
        }
    },

    fonts: {
        src: srcAssets + '/fonts/**/*',
        dest: destAssets + '/fonts',
        watch: srcAssets + '/fonts/**/*'
    }
};