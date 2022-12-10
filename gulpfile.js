var gulp = require('gulp');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
const sass = require('gulp-sass')(require('sass'));
// sass.compiler = require('sass');
var autoprefixer = require('gulp-autoprefixer');
var minifyCss = require('gulp-minify-css');
var fs = require('fs');

var PUBLIC_DEST = 'assets/public/';
var ADMIN_DEST = 'assets/admin/';
var JS_SOURCE = 'src/js';
var PLUGIN_SOURCE = 'assets/plugins';
var CSS_SOURCE = 'src/scss';
var JS_OUTPUT_FILE = 'script.min.js';
var JS_OUTPUT_ALL = 'final.min.js';
var CSS_OUTPUT_FILE = 'style.css';


gulp.task('plugin-javascript', function (done) {
    //this must minify and compact with together
    gulp.src(PLUGIN_SOURCE + '/*/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat('plugins.js'))
        .pipe(gulp.dest(PUBLIC_DEST));
    done();
});

gulp.task('plugin-style', function (done) {
    gulp.src(PLUGIN_SOURCE + '/*/*.css')
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                generator.emit('end');
            }
        }))
        .pipe(sass())
        .pipe(autoprefixer('last 2 versions'))
        .pipe(concat('plugins.css'))
        .pipe(gulp.dest(PUBLIC_DEST));
    done();
});

gulp.task('javascript', function (done) {
    //this must minify and compact with together
     gulp.src([
        PUBLIC_DEST+JS_SOURCE + '/*.js',
    ])
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat(JS_OUTPUT_FILE))
        .pipe(uglify())
        .pipe(gulp.dest(PUBLIC_DEST));
    done();
});

gulp.task('javascript_compactor',gulp.series('javascript',  function (done) {
    //this is packages that need for other item and then compact with all item
    gulp.src([
        PUBLIC_DEST + JS_OUTPUT_FILE,
    ])
        .pipe(concat(JS_OUTPUT_ALL))
        .pipe(gulp.dest(PUBLIC_DEST));
    done();
}));


gulp.task('admin_javascript', function (done) {
    //this must minify and compact with together
   gulp.src([
       ADMIN_DEST+JS_SOURCE + '/*.js',
    ])
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(concat(JS_OUTPUT_FILE))
        .pipe(uglify())
        .pipe(gulp.dest(ADMIN_DEST));
    done();
});

gulp.task('admin_javascript_compactor',gulp.series('admin_javascript',  function (done) {
    //this is packages that need for other item and then compact with all item
    gulp.src([
        ADMIN_DEST + JS_OUTPUT_FILE,
    ])
        .pipe(concat(JS_OUTPUT_ALL))
        .pipe(gulp.dest(ADMIN_DEST));
    done();
}));




gulp.task('css_creator', function (done) {
     gulp.src(
        [
            PUBLIC_DEST+CSS_SOURCE + '/*.scss'
            ]
    )
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                generator.emit('end');
            }
        }))
        .pipe(sass())
        .pipe(autoprefixer('last 2 versions'))
        .pipe(concat(CSS_OUTPUT_FILE))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifyCss())
        .pipe(gulp.dest(PUBLIC_DEST));
    done();
});

gulp.task('admin_css_creator', function (done) {
     gulp.src([
        ADMIN_DEST+CSS_SOURCE + '/*.scss'
    ])
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                generator.emit('end');
            }
        }))
        .pipe(sass())
        .pipe(autoprefixer('last 2 versions'))
        .pipe(concat(CSS_OUTPUT_FILE))
        .pipe(gulp.dest(ADMIN_DEST))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifyCss())
        .pipe(gulp.dest(ADMIN_DEST));
    done();
});

//add version to one file for later check
gulp.task('increment-version',async function(){
    try {
        var docString = fs.readFileSync('./version', 'utf8');
    } catch (err) {
        console.log(err);
        require('fs').writeFileSync('./version', '1.0.0');
        return;
    }
    //The code below gets your semantic v# from docString
    var versionNumPattern=/(.*)/; //This is just a regEx with a capture group for version number
    var vNumRexEx = new RegExp(versionNumPattern);
    var oldVersionNumber = (vNumRexEx.exec(docString))[1]; //This gets the captured group

    //...Split the version number string into elements so you can bump the one you want
    var versionParts = oldVersionNumber.split('.');
    var vArray = {
        vMajor : versionParts[0],
        vMinor : versionParts[1],
        vPatch : versionParts[2]
    };

    vArray.vPatch = parseFloat(vArray.vPatch) + 1;
    var periodString = ".";

    var newVersionNumber = vArray.vMajor + periodString +
        vArray.vMinor+ periodString +
        vArray.vPatch;
    require('fs').writeFileSync('./version', newVersionNumber);
    return null;
   });

gulp.task('default'
    , gulp.series(
        'css_creator',
        'admin_css_creator',
        'javascript_compactor',
        'admin_javascript_compactor',
        'plugin-javascript',
        'plugin-style',
        'increment-version',
        function (done) {
            gulp.watch([PUBLIC_DEST+JS_SOURCE + '/*.js', PUBLIC_DEST+JS_SOURCE + '/**/*.js'], gulp.series(['javascript_compactor','increment-version']));
            gulp.watch([ADMIN_DEST+JS_SOURCE + '/*.js', ADMIN_DEST+JS_SOURCE + '/**/*.js'], gulp.series(['admin_javascript_compactor','increment-version']));
            gulp.watch([PUBLIC_DEST+CSS_SOURCE + '/*.scss', PUBLIC_DEST+CSS_SOURCE + '/**/*.scss'], gulp.series('css_creator','increment-version'));
            gulp.watch([ADMIN_DEST+CSS_SOURCE + '/*.scss', ADMIN_DEST+CSS_SOURCE + '/**/*.scss'], gulp.series('admin_css_creator','increment-version'));
            done();
        }));
