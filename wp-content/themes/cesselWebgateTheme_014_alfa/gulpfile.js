var gulp        = require("gulp"),
    sass        = require("gulp-sass"),
    compass     = require('gulp-compass'),
    bsync       = require('browser-sync'),
    livereload  = require('gulp-livereload'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglifyjs'),
    cssnano     = require('gulp-cssnano'),
    rename      = require('gulp-rename'),
    del         = require('del'),
    imgmin      = require('gulp-imagemin'),
    pngq        = require('imagemin-pngquant'),
    autopref    = require('gulp-autoprefixer'),
    plumber    = require('gulp-plumber'),
    cache        = require('gulp-cache');


gulp.task("sass",function(done)

    {
        return gulp.src('sass/**/*.+(sass|scss)')
            .pipe(compass({
                config_file: __dirname + '/config/compass.rb',
                sass: 'sass',
                css:'css'
            })).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА1" + error);
            })
            .pipe(autopref(['last 15 versions','> 1%', 'ie 8', 'ie 7'],{'cascade':true})).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА2" + error);
            })
            .pipe(gulp.dest('css'))
            .pipe(bsync.reload({stream:true})).on('error', function(error) {
                // у нас ошибка
                done("ОШИБКА3" + error);
            });
    });

gulp.task('bsync',function ()
    {
        bsync
        (
            {
                proxy:"[sitename.ces]",
                logLevel: "info"
            }
        );
    });

gulp.task('scripts',function()
{
    return gulp.src(
        [
        'app/libs/jquery/dist/jquery.min.js',
        'app/lib/owl.carousel/dist/owl.carousel.min.js'
        ])
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('js'));
});
gulp.task('css-libs',['sass'],function()
{
    return gulp.src(
        [
        'css/*.css'
        ])
        .pipe(gulp.dest('css'));
});
gulp.task('css-libs:nano',['sass'],function()
{
    return gulp.src(
        [
        'css/*.css'
        ])
        .pipe(cssnano())
        .pipe(rename({suffix:'.min'}))
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest('css'));
});

gulp.task('cls',function()
    {
       return del.sync('dist');
    });
gulp.task('cache_cls',function()
    {
       return cache.clearAll();
    });

gulp.task('img',function()
    {
       return gulp.src
        (
            'img/**/*.*'
        )
           .pipe(cache(imgmin(
               {
                   interlaces:true
                   ,progressive:true
                   ,svgoPlugins:[{removeViewBox:false}]
                   ,use:[pngq()]
               }
           )))
           .pipe(gulp.dest('img'));
    });

//gulp.task('watch',['bsync','scripts','sass'],function()
gulp.task('default',['bsync','sass'],function()
    {
        gulp.watch('sass/**/*.+(sass|scss)',['sass']);
        gulp.watch('**/*.php',bsync.reload);
        gulp.watch('js/**/*.js',bsync.reload);
    });

gulp.task('build',['cls','css-libs:nano','img'],function () {});